<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use App\Models\Skill;
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
			$sort = $request->get( 'sort', 'id' );
			$direction = $request->get( 'direction', 'asc' );
			$searchtext = $request->get( 'searchtext', '' );

			if ( $searchtext != '' ) {
				$list = JobPosition::where( 'id', 'like', '%' . $searchtext . '%' )
					->orWhere( 'name', 'like', '%' . $searchtext . '%' )
					->orderby( $sort, $direction )
					->paginate( $length );
			}
			else {
				$list = JobPosition::orderby( $sort, $direction )->paginate( $length );
			}

			return view( 'job_positions.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
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
			$this->setUsers($model, $request->input('users'));

			return redirect( route( 'job_positions_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A pozíció adatai sikeresen rögzítve lettek.' ),
				] );
		}

		$selectedSkillIds = [];

		return view( 'job_positions.edit', [
			'model' => $model,
			'selectedSkillIds' => $model->skills()->pluck('id')->toArray(),
			'selectedUserIds' => $model->users()->pluck('id')->toArray(),
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

	private function setUsers($model, $items)
	{
		$model->users()->sync($items);
	}
}
