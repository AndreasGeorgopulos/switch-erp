<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'MainController@Login')->name('index');
Route::match(['get', 'post'], '/login', 'MainController@Login')->name('login');
Route::match(['get', 'post'], '/logout', 'MainController@Logout')->name('logout');

Route::group(['middleware' => ['acl', 'locale']], function () {
	// Kezdőlap
	Route::match(['get'], '/', function () {
		return redirect(route('dashboard'));
	});
	Route::match(['get'], '/dashboard', 'MainController@Dashboard')->name('dashboard');

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
});