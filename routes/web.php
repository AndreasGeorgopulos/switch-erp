<?php

use Illuminate\Support\Facades\Route;

Route::any('adminer', '\Miroc\LaravelAdminer\AdminerController@index');

Route::match(['get', 'post'], '/', 'MainController@Login')->name('index');
Route::match(['get', 'post'], '/login', 'MainController@Login')->name('login');
Route::match(['get', 'post'], '/logout', 'MainController@Logout')->name('logout');

Route::match(['get'], '/calendar', 'CalendarController@index')->name('calendar');
Route::match(['get'], '/ajax_get_calendar_events', 'CalendarController@ajaxGetCalendarEvents')->name('ajax_get_calendar_events');
Route::match(['get'], '/ajax_load_profile_vacations', 'VacationController@ajaxLoadProfileVacations')->name('ajax_load_profile_vacations');
Route::match(['post'], '/ajax_delete_profile_vacation', 'VacationController@ajaxDeleteProfileVacation')->name('ajax_delete_profile_vacation');
Route::match(['post'], '/ajax_save_profile_vacation', 'VacationController@ajaxSaveProfileVacation')->name('ajax_save_profile_vacation');
Route::match(['post'], '/ajax_approve_vacation', 'VacationController@ajaxApproveVacation')->name('ajax_approve_vacation');
Route::match(['post'], '/ajax_reject_vacation', 'VacationController@ajaxRejectVacation')->name('ajax_reject_vacation');

Route::group(['middleware' => ['acl', 'locale']], function () {
	// Kezdőlap
	Route::match(['get'], '/', function () {
		return redirect(route('applicant_management_index'));
	});
	//Route::match(['get'], '/dashboard', 'MainController@Dashboard')->name('dashboard');

	// Applicant Management
	Route::match(['get'], '/applicant_management/{selectedGroup?}', 'ApplicantManagementController@index')->name('applicant_management_index');
	Route::match(['post'], '/applicant_management/save_rows/{selectedGroup?}', 'ApplicantManagementController@saveRows')->name('applicant_management_save_rows');
	Route::match(['delete'], '/applicant_management/delete/{selectedGroup}/{id}', 'ApplicantManagementController@delete')->name('applicant_management_delete');
	Route::match(['get', 'post'], '/applicant_management/edit/{id}/{selectedGroup?}', 'ApplicantManagementController@edit')->name('applicant_management_edit');
	Route::match(['post'], '/applicant_management/add-note', 'ApplicantManagementController@addNote')->name('applicant_management_add_note');
	Route::match(['get'], '/applicant_management/get-notes/{applicant_id}', 'ApplicantManagementController@getNotes')->name('applicant_management_get_notes');
	Route::match(['get'], '/applicant_management/delete-note/{id}', 'ApplicantManagementController@deleteNote')->name('applicant_management_delete_note');
	Route::match(['get'], '/applicant_management/get-job-position-options/{company_id}', 'ApplicantManagementController@getJobPositionOptions')->name('applicant_management_get_job_position_options');
	Route::match(['post'], '/applicant_management/reorder/{selectedGroup}', 'ApplicantManagementController@reorder')->name('applicant_management_reorder');
	Route::match(['post'], '/applicant_management/set-is-marked', 'ApplicantManagementController@setIsMarked')->name('applicant_management_set_is_marked');

	// Search management
	Route::match(['get'], '/search_management/get_counters/{job?}', 'SearchManagementController@getCounters')->name('search_management_get_counters');
	Route::match(['get'], '/search_management/{company?}/{job?}', 'SearchManagementController@index')->name('search_management_index');
	Route::match(['post'], '/search_management/save_data', 'SearchManagementController@saveData')->name('search_management_save_data');

	// Work management
	Route::match(['get'], '/work_management', 'WorkManagementController@index')->name('work_management_index');
	Route::match(['post'], '/work_management/save_data', 'WorkManagementController@saveData')->name('work_management_save_data');
	Route::match(['post'], '/work_management/upload_tig/{applicant_id}/{job_position_id}', 'WorkManagementController@uploadTig')->name('work_management_upload_tig');
	Route::match(['get'], '/work_management/delete_tig/{applicant_id}/{job_position_id}', 'WorkManagementController@deleteTig')->name('work_management_delete_tig');
	Route::match(['get'], '/work_management/download_tig/{applicant_id}/{job_position_id}', 'WorkManagementController@downloadTig')->name('work_management_download_tig');

	// Contract management
	Route::match(['get'], '/contract_management', 'ContractManagementController@index')->name('contract_management_index');
	Route::match(['post'], '/contract_management/save_rows', 'ContractManagementController@saveRows')->name('contract_management_save_rows');
	Route::match(['get', 'post'], '/contract_management/edit/{id}', 'ContractManagementController@edit')->name('contract_management_edit');
	Route::match(['get'], '/contract_management/delete/{id}', 'ContractManagementController@delete')->name('contract_management_delete');

	// Sales management
	Route::match(['get'], '/sales_management', 'SalesManagementController@index')->name('sales_management_index');
	Route::match(['post'], '/sales_management/add', 'SalesManagementController@add')->name('sales_management_add');
	Route::match(['post'], '/sales_management/update', 'SalesManagementController@update')->name('sales_management_update');
	Route::match(['delete'], '/sales_management/delete/{id}', 'SalesManagementController@delete')->name('sales_management_delete');
	Route::match(['post'], '/sales_management/reorder', 'SalesManagementController@reorder')->name('sales_management_reorder');
    Route::match(['post'], '/sales_management/set-is-marked', 'SalesManagementController@setIsMarked')->name('sales_management_set_is_marked');

	// Callback management
	Route::match(['get'], '/callback_management', 'CallbackManagementController@index')->name('callback_management_index');
	Route::match(['get'], '/callback_management/applicant', 'CallbackManagementController@indexApplicant')->name('callback_management_index_applicant');
	Route::match(['post', 'delete'], '/callback_management/applicant/delete', 'CallbackManagementController@deleteApplicant')->name('callback_management_delete_applicant');
	Route::match(['get'], '/callback_management/sales', 'CallbackManagementController@indexSales')->name('callback_management_index_sales');
	Route::match(['post', 'delete'], '/callback_management/sales/delete', 'CallbackManagementController@deleteSales')->name('callback_management_delete_sales');

	// users
	Route::match(['get', 'post'], '/users/list', 'UserController@index')->name('users_list');
	Route::match(['get', 'post', 'put'], '/users/edit/{id?}', 'UserController@edit')->name('users_edit');
	Route::match(['get'], '/users/delete/{id?}', 'UserController@delete')->name('users_delete');
	Route::match(['get'], '/users/force_login/{id?}', 'UserController@forceLogin')->name('users_force_login');
	Route::match(['get', 'post'], '/users/profile', 'UserController@profile')->name('users_profile');

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

	// themes
	Route::match(['get', 'post'], '/themes/list', 'ThemeController@index')->name('themes_list');
	Route::match(['get', 'post', 'put'], '/themes/edit/{id?}', 'ThemeController@edit')->name('themes_edit');
	Route::match(['get'], '/themes/delete/{id?}', 'ThemeController@delete')->name('themes_delete');
});