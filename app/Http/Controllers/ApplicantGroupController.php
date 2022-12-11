<?php

namespace App\Http\Controllers;

use App\Models\ApplicantGroup;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * Applicant group management controller
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
class ApplicantGroupController extends Controller implements ICrudController
{
	/**
	 * @param Request $request
	 * @return Factory|Application|View
	 */
	public function index ( Request $request ) {
		if ( $request->isMethod( 'post' ) ) {
			$length = $request->get( 'length', config( 'adminlte.paginator.default_length' ) );
			$sort = $request->get( 'sort', 'id' );
			$direction = $request->get( 'direction', 'asc' );
			$searchtext = $request->get( 'searchtext', '' );

			if ( $searchtext != '' ) {
				$list = ApplicantGroup::where( 'id', 'like', '%' . $searchtext . '%' )
					->orWhere( 'name', 'like', '%' . $searchtext . '%' )
					->orderby( $sort, $direction )
					->paginate( $length );
			}
			else {
				$list = ApplicantGroup::orderby( $sort, $direction )->paginate( $length );
			}

			return view( 'applicant_groups.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			] );
		}

		return view( 'applicant_groups.index' );
	}

	/**
	 * @param int $id
	 * @return mixed|void
	 */
	public function view(int $id )
	{
		$model = ApplicantGroup::findOrFail( $id );

		return view('applicant_groups.view', [
			'model' => $model,
		]);
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return Factory|Application|RedirectResponse|Redirector|View
	 */
	public function edit ( Request $request, int $id = 0 ) {
		$model = ApplicantGroup::findOrNew( $id );

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), ApplicantGroup::rules() );
			$validator->setAttributeNames( ApplicantGroup::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'applicant_groups_edit', ['id' => $id] ) )
					->withErrors( $validator )
					->withInput()
					->with('form_warning_message', [
						trans( 'Sikertelen mentés' ),
						trans( 'A jelölt csoport adatainak rögzítése nem sikerült a következő hibák miatt:' ),
					]);
			}

			// data save
			$model->fill( $request->all() );
			$model->save();

			return redirect(route( 'applicant_groups_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A jelölt csoport adatai sikeresen rögzítve lettek.' ),
				]);
		}

		return view( 'applicant_groups.edit', [
			'model' => $model,
		] );
	}

	/**
	 * @param int $id
	 * @return Application|RedirectResponse|Redirector|void
	 * @throws Exception
	 */
	public function delete ( int $id ) {
		if ( $model = ApplicantGroup::find( $id ) ) {
			$model->delete();
			return redirect( route( 'applicant_groups_list' ) )
				->with( 'form_success_message', [
					trans( 'Sikeres törlés' ),
					trans( 'A jelölt csoport sikeresen el lett távolítva.' ),
				] );
		}
	}
}
