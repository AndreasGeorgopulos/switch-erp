<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * Skill management controller
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
class SkillController extends Controller implements ICrudController
{
	/**
	 * @param Request $request
	 * @return Factory|Application|View|mixed
	 */
	public function index(Request $request)
	{
		if ( $request->isMethod( 'post' ) ) {
			$length = $request->get( 'length', config( 'adminlte.paginator.default_length' ) );
			$sort = $request->get( 'sort', 'id' );
			$direction = $request->get( 'direction', 'asc' );
			$searchtext = $request->get( 'searchtext', '' );

			if ( $searchtext != '' ) {
				$list = Skill::where( 'id', 'like', '%' . $searchtext . '%' )
					->orWhere( 'name', 'like', '%' . $searchtext . '%' )
					->orderby( $sort, $direction )
					->paginate( $length );
			}
			else {
				$list = Skill::orderby( $sort, $direction )->paginate( $length );
			}

			return view( 'skills.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			] );
		}

		return view( 'skills.index' );
	}

	/**
	 * @param int $id
	 * @return Factory|Application|View|mixed
	 */
	public function view(int $id)
	{
		$model = Skill::findOrFail( $id );

		return view('skills.view', [
			'model' => $model,
		]);
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return Factory|Application|RedirectResponse|Redirector|View|mixed
	 */
	public function edit(Request $request, int $id = 0)
	{
		$model = Skill::findOrNew( $id );

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), Skill::rules() );
			$validator->setAttributeNames( Skill::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'skills_edit', ['id' => $id] ) )
					->withErrors( $validator )
					->withInput()
					->with('form_warning_message', [
						trans( 'Sikertelen mentés' ),
						trans( 'A készség adatainak rögzítése nem sikerült a következő hibák miatt:' ),
					]);
			}

			// data save
			$model->fill( $request->all() );
			$model->save();

			return redirect(route( 'skills_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A készség adatai sikeresen rögzítve lettek.' ),
				]);
		}

		return view( 'skills.edit', [
			'model' => $model,
		] );
	}

	/**
	 * @param int $id
	 * @return Application|RedirectResponse|Redirector|mixed|void
	 * @throws Exception
	 */
	public function delete(int $id)
	{
		if ( $model = Skill::find( $id ) ) {
			$model->delete();
			return redirect( route( 'skills_list' ) )
				->with( 'form_success_message', [
					trans( 'Sikeres törlés' ),
					trans( 'A készség sikeresen el lett távolítva.' ),
				] );
		}
	}
}
