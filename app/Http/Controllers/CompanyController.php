<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Company controller
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-28
 */
class CompanyController extends Controller implements ICrudController
{

	/**
	 * @param Request $request
	 * @return mixed|void
	 */
	public function index(Request $request)
	{
		if ( $request->isMethod( 'post' ) ) {
			$length = $request->get( 'length', config( 'adminlte.paginator.default_length' ) );
			$sort = $request->get( 'sort', 'id' );
			$direction = $request->get( 'direction', 'asc' );
			$searchtext = $request->get( 'searchtext', '' );

			if ( $searchtext != '' ) {
				$list = Company::where( 'id', 'like', '%' . $searchtext . '%' )
					->orWhere( 'name', 'like', '%' . $searchtext . '%' )
					->orderby( $sort, $direction )
					->paginate( $length );
			}
			else {
				$list = Company::orderby( $sort, $direction )->paginate( $length );
			}

			return view( 'companies.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			] );
		}

		return view( 'companies.index' );
	}

	/**
	 * @param int $id
	 * @return mixed|void
	 */
	public function view(int $id)
	{
		$model = Company::findOrFail( $id );

		return view('companies.view', [
			'model' => $model,
		]);
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return mixed|void
	 */
	public function edit(Request $request, int $id = 0)
	{
		$model = Company::findOrNew( $id );

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), Company::rules() );
			$validator->setAttributeNames( Company::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'companies_edit', ['id' => $id] ) )
					->withErrors( $validator )
					->withInput()
					->with( 'form_warning_message', [
						trans( 'Sikertelen mentés' ),
						trans( 'A cég adatainak rögzítése nem sikerült a következő hibák miatt:' ),
					] );
			}

			// data save
			$model->fill( $request->all() );
			$model->save();

			if ( $file = $request->file('contract_file') ) {
				try {
					$model->uploadContract( $file );
				} catch ( Exception $exception ) {
					return redirect( route( 'companies_edit', ['id' => $id] ) )
						->withErrors( $exception->getMessage() )
						->withInput()
						->with( 'form_warning_message', [
							trans( 'Sikertelen mentés' ),
							trans( $exception->getMessage() ),
						] );
				}

			} elseif ( $request->get('delete_contract_file') ) {
				$model->deleteContract();

			}

			return redirect( route( 'companies_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A cég adatai sikeresen rögzítve lettek.' ),
				] );
		}

		return view( 'companies.edit', [
			'model' => $model,
		] );
	}

	/**
	 * @param int $id
	 * @return mixed|void
	 */
	public function delete(int $id)
	{
		if ( $model = Company::find( $id ) ) {
			$model->deleteContract();
			$model->delete();
			return redirect( route( 'companies_list' ) )
				->with( 'form_success_message', [
					trans( 'Sikeres törlés' ),
					trans( 'A cég sikeresen el lett távolítva.' ),
				] );
		}
	}

	/**
	 * @param int $id
	 * @return BinaryFileResponse
	 */
	public function downloadContract(int $id )
	{
		if ( ($model = Company::find( $id) ) == null ) {
			throw new NotFoundHttpException('CV file not found.');
		}

		return response()->download($model->getContractPath(), $model->contract_file, [], 'inline');
	}
}
