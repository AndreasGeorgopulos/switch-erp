<?php

use Illuminate\Support\Facades\Route;

Route::any('adminer', '\Miroc\LaravelAdminer\AdminerController@index');

Route::match(['get', 'post'], '/', 'MainController@Login')->name('index');
Route::match(['get', 'post'], '/login', 'MainController@Login')->name('login');
Route::match(['get', 'post'], '/logout', 'MainController@Logout')->name('logout');

Route::group(['middleware' => ['acl', 'locale']], function () {
	// Kezdőlap
	Route::match(['get'], '/', function () {
		return redirect(route('applicant_management_index'));
	});
	//Route::match(['get'], '/dashboard', 'MainController@Dashboard')->name('dashboard');

	// Applicant Management
	Route::match(['get'], '/applicant_management/{selectedGroup?}', 'ApplicantManagementController@index')->name('applicant_management_index');
	Route::match(['post'], '/applicant_management/save_rows/{selectedGroup?}', 'ApplicantManagementController@saveRows')->name('applicant_management_save_rows');
	Route::match(['get', 'post'], '/applicant_management/edit/{id}/{selectedGroup?}', 'ApplicantManagementController@edit')->name('applicant_management_edit');
	Route::match(['post'], '/applicant_management/add-note', 'ApplicantManagementController@addNote')->name('applicant_management_add_note');
	Route::match(['get'], '/applicant_management/get-notes/{applicant_id}', 'ApplicantManagementController@getNotes')->name('applicant_management_get_notes');
	Route::match(['get'], '/applicant_management/delete-note/{id}', 'ApplicantManagementController@deleteNote')->name('applicant_management_delete_note');
	Route::match(['get'], '/applicant_management/get-job-position-options/{company_id}', 'ApplicantManagementController@getJobPositionOptions')->name('applicant_management_get_job_position_options');

	// Search management
	Route::match(['get'], '/search_management', 'SearchManagementController@index')->name('search_management_index');

	// Contract management
	Route::match(['get'], '/contract_management', 'ContractManagementController@index')->name('contract_management_index');
	Route::match(['post'], '/contract_management/save_rows', 'ContractManagementController@saveRows')->name('contract_management_save_rows');
	Route::match(['get', 'post'], '/contract_management/edit/{id}', 'ContractManagementController@edit')->name('contract_management_edit');
	Route::match(['get'], '/contract_management/delete/{id}', 'ContractManagementController@delete')->name('contract_management_delete');

	// users
	Route::match(['get', 'post'], '/users/list', 'UserController@index')->name('users_list');
	Route::match(['get', 'post', 'put'], '/users/edit/{id?}', 'UserController@edit')->name('users_edit');
	Route::match(['get'], '/users/delete/{id?}', 'UserController@delete')->name('users_delete');
	Route::match(['get'], '/users/force_login/{id?}', 'UserController@forceLogin')->name('users_force_login');

	// roles
	Route::match(['get', 'post'], '/roles/list', 'RoleController@index')->name('roles_list');
	Route::match(['get', 'post', 'put'], '/roles/edit/{id?}', 'RoleController@edit')->name('roles_edit');
	Route::match(['get'], '/roles/delete/{id?}', 'RoleController@delete')->name('roles_delete');

	// applicant groups
	Route::match(['get', 'post'], '/applicant_groups/list', 'ApplicantGroupController@index')->name('applicant_groups_list');
	Route::match(['get'], '/applicant_groups/view/{id}', 'ApplicantGroupController@view')->name('applicant_groups_view');
	Route::match(['get', 'post', 'put'], '/applicant_groups/edit/{id?}', 'ApplicantGroupController@edit')->name('applicant_groups_edit');
	Route::match(['get'], '/applicant_groups/delete/{id?}', 'ApplicantGroupController@delete')->name('applicant_groups_delete');

	// applicants
	Route::match(['get', 'post'], '/applicants/list', 'ApplicantController@index')->name('applicants_list');
	Route::match(['get'], '/applicants/view/{id}', 'ApplicantController@view')->name('applicants_view');
	Route::match(['get', 'post', 'put'], '/applicants/edit/{id?}', 'ApplicantController@edit')->name('applicants_edit');
	Route::match(['get'], '/applicants/delete/{id?}', 'ApplicantController@delete')->name('applicants_delete');
	Route::match(['get'], '/applicants/download_pdf/{id}', 'ApplicantController@downloadCV')->name('applicants_download_cv');

	// skills
	Route::match(['get', 'post'], '/skills/list', 'SkillController@index')->name('skills_list');
	Route::match(['get'], '/skills/view/{id}', 'SkillController@view')->name('skills_view');
	Route::match(['get', 'post', 'put'], '/skills/edit/{id?}', 'SkillController@edit')->name('skills_edit');
	Route::match(['get'], '/skills/delete/{id?}', 'SkillController@delete')->name('skills_delete');

	// companies
	Route::match(['get', 'post'], '/companies/list', 'CompanyController@index')->name('companies_list');
	Route::match(['get'], '/companies/view/{id}', 'CompanyController@view')->name('companies_view');
	Route::match(['get', 'post', 'put'], '/companies/edit/{id?}', 'CompanyController@edit')->name('companies_edit');
	Route::match(['get'], '/companies/delete/{id?}', 'CompanyController@delete')->name('companies_delete');
	Route::match(['get'], '/companies/download_pdf/{id}', 'CompanyController@downloadContract')->name('companies_download_contract');

	// job positions
	Route::match(['get', 'post'], '/job_positions/list', 'JobPositionController@index')->name('job_positions_list');
	Route::match(['get'], '/job_positions/view/{id}', 'JobPositionController@view')->name('job_positions_view');
	Route::match(['get', 'post', 'put'], '/job_positions/edit/{id?}', 'JobPositionController@edit')->name('job_positions_edit');
	Route::match(['get'], '/job_positions/delete/{id?}', 'JobPositionController@delete')->name('job_positions_delete');
});