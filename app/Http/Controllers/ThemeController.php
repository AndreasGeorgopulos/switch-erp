<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ThemeController extends Controller
{
	/**
	 * @param Request $request
	 * @return Factory|Application|View
	 */
	public function index (Request $request)
    {
	    if ( $request->isMethod( 'post' ) ) {
		    $length = $request->get( 'length', config( 'adminlte.paginator.default_length' ) );
		    $sort = $request->get( 'sort', 'id' );
		    $direction = $request->get( 'direction', 'asc' );
		    $searchtext = $request->get( 'searchtext', '' );

		    if ( $searchtext != '' ) {
			    $list = Theme::where( 'id', 'like', '%' . $searchtext . '%' )
				    ->orWhere( 'name', 'like', '%' . $searchtext . '%' )
				    ->orderby( $sort, $direction )
				    ->paginate( $length );
		    }
		    else {
			    $list = Theme::orderby( $sort, $direction )->paginate( $length );
		    }

		    return view( 'themes.list', [
			    'list' => $list,
			    'sort' => $sort,
			    'direction' => $direction,
			    'searchtext' => $searchtext
		    ] );
	    }

		return view('themes.index');
    }

	/**
	 * @param Request $request
	 * @param int $id
	 * @return Factory|Application|RedirectResponse|Redirector|View
	 */
	public function edit(Request $request, int $id = 0)
	{
		$model = Theme::findOrNew( $id );

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), Theme::rules() );
			$validator->setAttributeNames( Theme::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'themes_edit', ['id' => $id] ) )
					->withErrors( $validator )
					->withInput()
					->with('form_warning_message', [
						trans( 'Sikertelen mentés' ),
						trans( 'A téma adatainak rögzítése nem sikerült a következő hibák miatt:' ),
					]);
			}

			// data save
			$model->name = $request->get('name');
			$model->is_active = $request->get('is_active');
			$model->data = serialize($request->get('css_data'));
			$model->save();

			return redirect(route( 'themes_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A téma adatai sikeresen rögzítve lettek.' ),
				]);
		}

		return view( 'themes.edit', [
			'model' => $model,
			'css_data' => unserialize($model->data),
		] );
	}
}
