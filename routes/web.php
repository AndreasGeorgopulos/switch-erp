<?php

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
});

/*Route::match(['get', 'post'], '/', 'IndexController@index')->name('index');
Route::match(['get', 'post'], '/login', 'IndexController@login')->name('login');

Route::group(['middleware' => ['locale', 'acl']], function() {
	Route::match(['get', 'post'], '/', 'IndexController@index')->name('index');
	Route::match(['get', 'post'], '/login', 'IndexController@login')->name('login');
	Route::match(['get', 'post'], '/logout', 'IndexController@logout')->name('logout');
	Route::match(['get'], '/change_language/{locale}', 'IndexController@changeLanguage')->name('change_language');
	
	// pages
	Route::match(['get', 'post'], '/contents/list', 'ContentController@index')->name('contents_list');
	Route::match(['get', 'post', 'put'], '/contents/edit/{id?}', 'ContentController@edit')->name('contents_edit');
	Route::match(['get'], '/contents/delete/{id?}', 'ContentController@delete')->name('contents_delete');
	
	// users
	Route::match(['get', 'post'], '/users/list', 'UserController@index')->name('users_list');
	Route::match(['get', 'post', 'put'], '/users/edit/{id?}', 'UserController@edit')->name('users_edit');
	Route::match(['get'], '/users/delete/{id?}', 'UserController@delete')->name('users_delete');
	Route::match(['get'], '/users/force_login/{id?}', 'UserController@forceLogin')->name('users_force_login');
	
	// roles
	Route::match(['get', 'post'], '/roles/list', 'RoleController@index')->name('roles_list');
	Route::match(['get', 'post', 'put'], '/roles/edit/{id?}', 'RoleController@edit')->name('roles_edit');
	Route::match(['get'], '/roles/delete/{id?}', 'RoleController@delete')->name('roles_delete');
	
	//Fordítások
	Route::match(['get'], '/translation/view/{group?}', 'TranslationController@getView')->name('translation_getview');
	Route::match(['get'], '/translation/{group?}', 'TranslationController@getIndex')->name('translation_getindex');
	Route::match(['post'], '/translation/add/{group}', 'TranslationController@postAdd')->name('translation_postadd');
	Route::match(['post'], '/translation/edit/{group}', 'TranslationController@postEdit')->name('translation_postedit');
	Route::match(['post'], '/translation/delete/{group}/{key}', 'TranslationController@postDelete')->name('translation_postdelete');
	Route::match(['post'], '/translation/import', 'TranslationController@postImport')->name('translation_postimport');
	Route::match(['post'], '/translation/find', 'TranslationController@postFind')->name('translation_postfind');
	Route::match(['post'], '/translation/publish/{group}', 'TranslationController@postPublish')->name('translation_postpublish');
	
});*/