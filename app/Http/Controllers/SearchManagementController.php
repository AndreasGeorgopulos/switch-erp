<?php

namespace App\Http\Controllers;

use App\Models\ApplicantJobPosition;
use App\Models\Company;
use Illuminate\Http\Request;

class SearchManagementController extends Controller
{
    public function index()
    {
		$models = ApplicantJobPosition::orderBy('created_at', 'asc')->get();

	    return view('search_management.index', [
		    'site_title' => trans('Keresés'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'models' => $models,
	    ]);
    }
}
