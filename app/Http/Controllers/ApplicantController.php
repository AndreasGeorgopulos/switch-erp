<?php
namespace App\Http\Controllers;

use App\Models\Applicant;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Applicant management controller
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
class ApplicantController extends Controller implements ICrudController
{
	/**
	 * @param Request $request
	 * @return Factory|Application|View|mixed
	 */
	public function index(Request $request )
	{
		if ( $request->isMethod( 'post' ) ) {
			$length = $request->get( 'length', config( 'adminlte.paginator.default_length' ) );
			$sort = $request->get( 'sort', 'id' );
			$direction = $request->get( 'direction', 'asc' );
			$searchtext = $request->get( 'searchtext', '' );

			if ( $searchtext != '' ) {
				$list = Applicant::where( 'id', 'like', '%' . $searchtext . '%' )
					->orWhere( 'name', 'like', '%' . $searchtext . '%' )
					->orderby( $sort, $direction )
					->paginate( $length );
			}
			else {
				$list = Applicant::orderby( $sort, $direction )->paginate( $length );
			}

			return view( 'applicants.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			] );
		}

		return view( 'applicants.index' );
	}

	/**
	 * @param int $request
	 * @return mixed|void
	 */
	public function view(int $id )
	{
		$model = Applicant::findOrFail( $id );

		return view('applicants.view', [
			'model' => $model,
		]);
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return Factory|Application|RedirectResponse|Redirector|View|mixed
	 */
	public function edit( Request $request, int $id = 0 )
	{
		$model = Applicant::findOrNew( $id );

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), Applicant::rules() );
			$validator->setAttributeNames( Applicant::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'applicants_edit', ['id' => $id] ) )
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

			$model->groups()->sync( $request->input( 'groups', [] ) );
			$model->skills()->sync( $request->input( 'skills', [] ) );

			if ( $file = $request->file('pdf_file') ) {
				$path = storage_path( Applicant::STORAGE_PATH );
				if ( !file_exists( $path) ) {
					mkdir( $path, 0775, true );
				}

				$model->pdf_file = $model->id . '-' . $file->getClientOriginalName();

				$file->move( $path, $model->pdf_file );
				chmod($path . '/' . $model->pdf_file, 0775);
				$model->save();

			} elseif ( $request->get('delete_pdf_file') ) {
				unlink($model->getPdfPath());
				$model->pdf_file = null;
				$model->save();

			}

			return redirect( route( 'applicants_edit', ['id' => $model->id] ) )
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A jelölt adatai sikeresen rögzítve lettek.' ),
				] );
		}

		return view( 'applicants.edit', [
			'model' => $model,
			'selectedGroupIds' => $model->groups()->pluck('id')->toArray(),
			'selectedSkillIds' => $model->skills()->pluck('id')->toArray(),
		] );
	}

	/**
	 * @param int $id
	 * @return Application|RedirectResponse|Redirector|mixed|void
	 * @throws Exception
	 */
	public function delete( int $id )
	{
		if ( $model = Applicant::find( $id ) ) {
			$model->delete();
			return redirect( route( 'applicants_list' ) )
				->with( 'form_success_message', [
					trans( 'Sikeres törlés' ),
					trans( 'A jelölt sikeresen el lett távolítva.' ),
				] );
		}
	}

	/**
	 * @param int $id
	 * @return BinaryFileResponse
	 */
	public function downloadPdf(int $id )
	{
		if ( ($model = Applicant::find( $id) ) == null ) {
			throw new NotFoundHttpException('Pdf file not found.');
		}

		return response()->download($model->getPdfPath(), $model->pdf_file, [], 'inline');
	}
}