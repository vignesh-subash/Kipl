<?php

$as = "";
if(\Kipl\Crmadmin\Helpers\CAHelper::laravel_ver() == 5.5) {
	$as = config('crmadmin.adminRoute').'.';
}

Route::group([
    'namespace'  => 'Kipl\Crmadmin\Controllers',
	'as' => 'admin.',
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {

	/* ================== Modules ================== */
	Route::resource(config('crmadmin.adminRoute') . '/modules', 'ModuleController');
	Route::resource(config('crmadmin.adminRoute') . '/module_fields', 'FieldController');
	Route::get(config('crmadmin.adminRoute') . '/module_generate_crud/{model_id}', 'ModuleController@generate_crud');
	Route::get(config('crmadmin.adminRoute') . '/module_generate_migr/{model_id}', 'ModuleController@generate_migr');
	Route::get(config('crmadmin.adminRoute') . '/module_generate_update/{model_id}', 'ModuleController@generate_update');
	Route::get(config('crmadmin.adminRoute') . '/module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
	Route::get(config('crmadmin.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
	Route::post(config('crmadmin.adminRoute') . '/save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
	Route::get(config('crmadmin.adminRoute') . '/save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
	Route::post(config('crmadmin.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
	Route::get(config('crmadmin.adminRoute') . '/module_fields/{id}/delete', 'FieldController@destroy');
	Route::post(config('crmadmin.adminRoute') . '/get_module_files/{module_id}', 'ModuleController@get_module_files');

	/* ================== Code Editor ================== */
	Route::get(config('crmadmin.adminRoute') . '/cacodeeditor', function () {
		if(file_exists(resource_path("views/ca/editor/index.blade.php"))) {
			return redirect(config('crmadmin.adminRoute') . '/caeditor');
		} else {
			// show install code editor page
			return View('ca.editor.install');
		}
	});

	/* ================== Menu Editor ================== */
	Route::resource(config('crmadmin.adminRoute') . '/ca_menus', 'MenuController');
	Route::post(config('crmadmin.adminRoute') . '/ca_menus/update_hierarchy', 'MenuController@update_hierarchy');

	/* ================== Configuration ================== */
	Route::resource(config('crmadmin.adminRoute') . '/ca_configs', '\App\Http\Controllers\CA\CAConfigController');

    Route::group([
        'middleware' => 'role'
    ], function () {
		/*
		Route::get(config('crmadmin.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'CAController@index'
        ]);
		*/
    });
});
