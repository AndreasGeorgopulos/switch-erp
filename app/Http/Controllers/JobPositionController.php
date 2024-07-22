<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use App\Models\Skill;
use App\Models\User;
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

/**
 * Job position controller
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-28
 */
class JobPositionController extends Controller implements ICrudController
{
	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function index(Request $request)
	{
		if ( $request->isMethod( 'post' ) ) {
			$length = $request->get( 'length', config( 'adminlte.paginator.default_length' ) );
			$sort = $request->get( 'sort', 'is_active' );
			$direction = $request->get( 'direction', 'desc' );
			$searchText = $request->get( 'searchtext', '' );

            if ($searchText != '') {
                $list = JobPosition::with('company')
                    ->whereHas('company', function ($q) use($searchText) {
                        $q->where('name', 'like', '%' . $searchText . '%');
                    })
                    ->orWhere('job_positions.id', 'like', '%' . $searchText . '%')
                    ->orWhere('title', 'like', '%' . $searchText . '%');

                if ($sort == 'company_name') {
                    $list->join('companies', 'job_positions.company_id', '=', 'companies.id')
                        ->select('job_positions.*')
                        ->orderBy('companies.name', $direction);
                } else {
                    $list->orderBy($sort, $direction);
                }
            } else {
                $list = JobPosition::with('company');

                if ($sort == 'company_name') {
                    $list->join('companies', 'job_positions.company_id', '=', 'companies.id')
                        ->select('job_positions.*') // Csak a JobPosition mezőket választjuk ki
                        ->orderBy('companies.name', $direction);
                } else {
                    $list->orderBy($sort, $direction);
                }
            }

            $list = $list->paginate($length);

			return view( 'job_positions.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchText
			] );
		}

		return view( 'job_positions.index' );
	}

	/**
	 * @param int $id
	 * @return Factory|Application|View
	 */
	public function view(int $id)
	{
		$model = $this->findModel($id);

		return view('job_positions.view', [
			'model' => $model,
		]);
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return mixed
	 */
	public function edit(Request $request, int $id = 0)
	{
		$model = JobPosition::findOrNew($id);
        $isNewModel = !$model->id;

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), JobPosition::rules() );
			$validator->setAttributeNames( JobPosition::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'job_positions_edit', ['id' => $id] ) )
					->withErrors( $validator )
					->withInput()
					->with( 'form_warning_message', [
						trans( 'Sikertelen mentés' ),
						trans( 'A pozíció adatainak rögzítése nem sikerült a következő hibák miatt:' ),
					] );
			}

			// data save
			$model->fill( $request->all() );
			$model->save();

			$this->setSkills($model, $request->input('skills'));
			$this->setUsers($model, $request->input('users'), $isNewModel);

			return redirect( route( 'job_positions_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A pozíció adatai sikeresen rögzítve lettek.' ),
				] );
		}

		$selectedSkillIds = $model->skills()->pluck('id')->toArray();
        $selectedUserIds = $model->users()->pluck('id')->toArray();
        if ($isNewModel) {
            $selectedUserIds = $this->mergeAutoAddUserIds($selectedUserIds);
        }

		return view( 'job_positions.edit', [
			'model' => $model,
			'selectedSkillIds' => $selectedSkillIds,
			'selectedUserIds' => $selectedUserIds,
		] );
	}

	/**
	 * @param int $id
	 * @return Application|RedirectResponse|Redirector
	 */
	public function delete(int $id)
	{
		$model = $this->findModel($id);

		if (!$model->delete()) {
			return redirect( route( 'job_positions_list' ) )
				->with( 'form_warning_message', [
					trans( 'Sikertelen törlés' ),
					trans( 'A pozíció eltávolítása sikertelen.' ),
				] );
		}

		return redirect( route( 'job_positions_list' ) )
			->with( 'form_success_message', [
				trans( 'Sikeres törlés' ),
				trans( 'A cég sikeresen el lett távolítva.' ),
			] );
	}

	/**
	 * @param int $id
	 * @return JobPosition|JobPosition[]|Collection|Model|mixed
	 */
	private function findModel(int $id)
	{
		if ( !( $model = JobPosition::find($id) ) ) {
			throw new NotFoundHttpException('Model not found');
		}

		return $model;
	}

	private function setSkills($model, $items)
	{
        if ($items === null) {
            $ids = [];
        } else {
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
        }

		$model->skills()->sync($ids);
	}

	private function setUsers($model, $items, $isNewModel)
	{
        $items = $isNewModel ? $this->mergeAutoAddUserIds($items) : $this->mergeNotRemovableUserIds($items);
		$model->users()->sync($items);
	}

    private function mergeAutoAddUserIds(array $items): array
    {
        $autoUserIds = User::where('add_for_new_job_position', true)->pluck('id')->toArray();
        return collect($items)->merge($autoUserIds)->unique()->toArray();
    }

    private function mergeNotRemovableUserIds(array $items): array
    {
        $autoUserIds = User::where('deletable_from_job_position', false)->pluck('id')->toArray();
        return collect($items)->merge($autoUserIds)->unique()->toArray();
    }
}
