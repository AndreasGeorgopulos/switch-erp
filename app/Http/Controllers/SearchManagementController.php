<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class SearchManagementController extends Controller
{
    public function index()
    {
		$companies = Company::where('is_active', 1)
			->orderBy('name', 'asc')
			->get();

	    return view('search_management.index', [
		    'site_title' => trans('Keresés'),
		    'site_subtitle' => 'Version 3.0',
		    'breadcrumb' => [],
		    'companies' => $companies,
	    ]);
    }
}
