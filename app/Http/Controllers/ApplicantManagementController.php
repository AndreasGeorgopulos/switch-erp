<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantGroup;
use App\Models\ApplicantJobPosition;
use App\Models\JobPosition;
use App\Models\Skill;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function foo\func;

/**
 *
 */
class ApplicantManagementController extends Controller
{
	/**
	 * @param Request $request
	 * @param int|null $selectedGroup
	 * @return Factory|Application|View
	 */
	public function index(Request $request, int $selectedGroup = null)
    {
	    $getParams = [
		    'experience_year' => intval($request->get('experience_year')) ?: '',
		    'in_english' => intval($request->get('in_english')) ?: '',
	    ];

		$applicantGroups = ApplicantGroup::where('is_active', true)->orderBy('name', 'asc')->get();
	    $applicants = [];
		if ($selectedGroup !== null) {
			$selectedGroup = ApplicantGroup::find($selectedGroup);
			$applicants = $selectedGroup->applicants()->where(function ($q) use($getParams) {
				if (!empty($getParams['experience_year'])) {
					$q->where('experience_year', '<=', $getParams['experience_year']);
				}
				if (!empty($getParams['in_english'])) {
					$q->where('in_english', $getParams['in_english']);
				}
			})->get();
		}

	    return view('applicant_management.index', [
		    'site_title' => trans('Jelöltek'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'selectedGroup' => $selectedGroup,
		    'applicantGroups' => $applicantGroups,
		    'applicants' => $applicants,
		    'getParams' => $getParams,
	    ]);
    }

	/**
	 * @param Request $request
	 * @param $selectedGroup
	 * @return Application|RedirectResponse|Redirector
	 */
	public function saveRows(Request $request, $selectedGroup)
	{
		$selectedGroup = ApplicantGroup::find($selectedGroup);

		if ( ( $applicants = $request->get('applicant', null) ) === null ) {
			throw new NotFoundHttpException('Model not found');
		}

		foreach ($applicants as $item) {
			$model = new Applicant();
			$model->fill($item)->save();

			$this->setSkills($model, $item['skills']);
			$this->setGroups($model, [$selectedGroup->name]);
		}

		return redirect(route('applicant_management_index', [
			'selectedGroup' => $selectedGroup,
		]))->with( 'form_success_message', [
			trans( 'Sikeres mentés' ),
			trans( 'A jelöltek sikeresen rögzítve lettek.' ),
		] );;
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return void
	 */
	public function edit(Request $request, int $id, int $selectedGroup = null)
	{
		$model = $this->findModel($id);
		$skills = Skill::where('is_active', true)->orderBy('name', 'asc')->get();
		$groups = ApplicantGroup::where('is_active', true)->orderBy('name', 'asc')->get();

		if ( $request->isMethod( 'post' ) ) {
			$inputSkills = $request->input('applicant.skills', []);
			$inputGroups = $request->input('applicant.groups', []);

			// validate
			$validator = Validator::make( $request->all(), Applicant::rules() );
			$validator->setAttributeNames( Applicant::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'applicant_management_edit', ['id' => $id, 'selectedGroup' => $selectedGroup] ) )
					->withErrors( $validator )
					->withInput()
					->with( 'form_warning_message', [
						trans( 'Sikertelen mentés' ),
						trans( 'A jelölt adatainak rögzítése nem sikerült a következő hibák miatt:' ),
					] );
			}

			// data save
			$model->fill( $request->all() );
			$model->save();

			$this->setSkills($model, $inputSkills);
			//$this->setGroups($model, $inputGroups);

			if ( $file = $request->file('cv_file') ) {
				try {
					$model->uploadCV( $file );
				} catch ( Exception $exception ) {
					return redirect( route( 'applicant_management_edit', ['id' => $id, 'selectedGroup' => $selectedGroup] ) )
						->withErrors( $exception->getMessage() )
						->withInput()
						->with( 'form_warning_message', [
							trans( 'Sikertelen mentés' ),
							trans( $exception->getMessage() ),
						] );
				}

			} elseif ( $request->get('delete_cv_file') ) {
				$model->deleteCV();

			}

			return redirect( route( 'applicant_management_edit', ['id' => $model->id, 'selectedGroup' => $selectedGroup] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A jelölt adatai sikeresen rögzítve lettek.' ),
				] );
		}

		return view( 'applicant_management.edit', [
			'model' => $model,
			'skills' => $skills,
			'groups' => $groups,
			'selectedGroup' => $selectedGroup,
			'selectedGroupIds' => $model->groups()->pluck('id')->toArray(),
			'selectedSkillIds' => $model->skills()->pluck('id')->toArray(),
		] );
	}

	/**
	 * @param $selectedGroup
	 * @return Application|RedirectResponse|Redirector
	 * @throws Exception
	 */
	public function delete($selectedGroup = null)
	{
		$model = $this->findModel();
		$model->deleteCV();
		$model->delete();
		return redirect(route('index', [
			'selectedGroup' => $selectedGroup,
		]));
	}

	public function getNotes($applicant_id)
	{
		$result = [];
		foreach (ApplicantJobPosition::where('applicant_id', $applicant_id)->get() as $model) {
			$result[] = [
				'id' => $model->id,
				'job_position_id' => $model->job_position_id,
				'applicant_id' => $model->applicant_id,
				'job_position_title' => $model->job_position_id ? $model->job_position->title : null,
				'company' => $model->job_position_id ? $model->job_position->company->name : null,
				'description' => $model->description,
				'send_date' => $model->send_date,
				'monogram' => $model->monogram,
			];
		}

		return view('applicant_management._note_list', [
			'result' => $result,
		]);
	}

	public function addNote(Request $request)
	{
		$model = ApplicantJobPosition::where(function($q) use($request) {
			$q->where('applicant_id', $request->get('applicant_id'));
			$q->where('job_position_id', $request->get('job_position_id'));
		})->first();

		if (empty($model) || $model->job_position_id === null) {
			$model = new ApplicantJobPosition();
		}

		$model->fill($request->all());
		if (!$request->get('job_position_id')) {
			$model->job_position_id = null;
		}
		$model->send_date = date('Y-m-d');

		return response()->json(['success' => (bool) $model->save()]);
	}

	public function deleteNote($id)
	{
		$model = ApplicantJobPosition::where('id', $id)->first();

		if (!empty($model)) {
			$model->delete();
		}

		return response()->json(['success' => true]);
	}

	public function getJobPositionOptions($company_id)
	{
		return response()->json(JobPosition::getDropdownItems($company_id));
	}

	/**
	 * @param $id
	 * @return Applicant|Applicant[]|Collection|Model|mixed
	 */
	private function findModel($id)
	{
		if ( !( $model = Applicant::find($id) ) ) {
			throw new NotFoundHttpException('Model not found');
		}

		return $model;
	}

	/**
	 * @param $model
	 * @param $items
	 * @return void
	 */
	private function setSkills($model, $items)
	{
		$ids = array_map(function ($skillName) {
			$skillName = trim($skillName);
			if (($skill = Skill::where('name', $skillName)->first()) === null) {
				$skill = new Skill();
				$skill->name = $skillName;
				$skill->is_active = true;
				$skill->save();
			}
			return $skill->id;
		}, $items);

		$model->skills()->sync($ids);
	}

	/**
	 * @param $model
	 * @param $items
	 * @return void
	 */
	private function setGroups($model, $items)
	{
		$ids = array_map(function ($groupName) {
			$groupName = trim($groupName);
			if (($group = ApplicantGroup::where('name', $groupName)->first()) === null) {
				$group = new ApplicantGroup();
				$group->name = $groupName;
				$group->is_active = true;
				$group->save();
			}
			return $group->id;
		}, $items);

		$model->groups()->sync($ids);
	}
}
