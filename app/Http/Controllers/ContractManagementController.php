<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *
 */
class ContractManagementController extends Controller
{
	/**
	 * @return Factory|Application|View
	 */
	public function index(Request $request)
	{
        $getParams = [
            'id' => $request->get('id', null),
        ];

        $companies = Company::where(function ($q) use ($getParams) {
            foreach ($getParams as $k => $v) {
                if (empty($v)) {
                    continue;
                }

                $q->where($k, $v);
            }
        })->orderBy('name', 'asc')->get();

		return view('contract_management.index', [
			'site_title' => trans('Partnereink'),
			'site_subtitle' => 'Version 3.0',
			'breadcrumb' => [],
			'companies' => $companies,
            'getParams' => $getParams,
		]);
	}

	public function edit(Request $request, int $id = 0)
	{
        $model = Company::findOrNew( $id );

        if (!$model->id) {
            $model->is_active = 1;
            $model->contract_date = Carbon::now()->format('Y-m-d');
        }

		if ( $request->isMethod( 'post' ) ) {
			// validate
			$validator = Validator::make( $request->all(), Company::rules() );
			$validator->setAttributeNames( Company::niceNames() );
			if ( $validator->fails() ) {
				return redirect( route( 'contract_management_edit', ['id' => $id] ) )
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
					return redirect( route( 'contract_management_edit', ['id' => $id] ) )
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

			return redirect( route( 'contract_management_edit', ['id' => $id] ) )
				->withInput()
				->with( 'form_success_message', [
					trans( 'Sikeres mentés' ),
					trans( 'A cég adatainak rögzítése sikeresen megtörtént' ),
				] );
		}

		return view('contract_management.edit', [
			'site_title' => trans('Partnereink'),
			'site_subtitle' => 'Version 3.0',
			'breadcrumb' => [],
			'model' => $model,
		]);
	}

	/**
	 * @param int $id
	 * @return void
	 */
	public function delete(int $id)
	{
		$model = $this->findModel($id);

		if (!$model->delete()) {
			return redirect(route('contract_management_index'))->with( 'form_warning_message', [
				trans( 'Sikertelen törlés' ),
				trans( 'A cég törlése nem sikerült.' ),
			] );
		}

		return redirect(route('contract_management_index'))->with( 'form_success_message', [
			trans( 'Sikeres törlés' ),
			trans( 'A cég törlése sikeresen megtörtént' ),
		] );
	}

	public function saveRows(Request $request)
	{
		$contracts = $request->get('contract', []);
		foreach ($contracts as $item) {
			if (empty($item['name'])) {
				continue;
			}
			$companyName = trim(strip_tags($item['name']));
			if (!Company::where('name', $companyName)->first()) {
				(new Company())->fill(['name' => $item['name']])->save();
			}
		}

		return redirect(route('contract_management_index', [
			'form_success_message' => [
				trans( 'Sikeres mentés' ),
				trans( 'A cégek sikeresen rögzítve lettek.' ),
			],
		])/*->with( 'form_success_message', [
			trans( 'Sikeres mentés' ),
			trans( 'A cégek sikeresen rögzítve lettek.' ),
		])*/);
	}

    /**
     * @param int $id
     * @return BinaryFileResponse
     */
    public function downloadContract(int $id ): BinaryFileResponse
    {
        if ( ($model = Company::find( $id) ) == null ) {
            throw new NotFoundHttpException('Contract file not found.');
        }

        return response()->download($model->getContractPath(), $model->contract_file, [], 'inline');
    }

	/**
	 * @param $id
	 * @return Company|Company[]|Collection|Model|mixed
	 */
	private function findModel($id)
	{
		if ( !( $model = Company::find($id) ) ) {
			throw new NotFoundHttpException('Model not found');
		}

		return $model;
	}
}
