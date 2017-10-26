<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	
	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');
	
	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	
	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== Kontraktors ================== */
	Route::resource(config('laraadmin.adminRoute') . '/kontraktors', 'LA\KontraktorsController');
	Route::get(config('laraadmin.adminRoute') . '/kontraktor_dt_ajax', 'LA\KontraktorsController@dtajax');

	/* ================== Clients ================== */
	Route::resource(config('laraadmin.adminRoute') . '/clients', 'LA\ClientsController');
	Route::get(config('laraadmin.adminRoute') . '/client_dt_ajax', 'LA\ClientsController@dtajax');

	/* ================== Data_Kontraktors ================== */
	Route::resource(config('laraadmin.adminRoute') . '/data_kontraktors', 'LA\Data_KontraktorsController');
	Route::get(config('laraadmin.adminRoute') . '/data_kontraktor_dt_ajax', 'LA\Data_KontraktorsController@dtajax');


	/* ================== Suppliers ================== */
	Route::resource(config('laraadmin.adminRoute') . '/suppliers', 'LA\SuppliersController');
	Route::get(config('laraadmin.adminRoute') . '/supplier_dt_ajax', 'LA\SuppliersController@dtajax');


	/* ================== Products ================== */
	Route::resource(config('laraadmin.adminRoute') . '/products', 'LA\ProductsController');
	Route::get(config('laraadmin.adminRoute') . '/product_dt_ajax', 'LA\ProductsController@dtajax');

	/* ================== Pemesanans ================== */
	Route::resource(config('laraadmin.adminRoute') . '/pemesanans', 'LA\PemesanansController');
	Route::get(config('laraadmin.adminRoute') . '/pemesanan_dt_ajax', 'LA\PemesanansController@dtajax');

	/* ================== Detail_Suppliers ================== */
	Route::resource(config('laraadmin.adminRoute') . '/detail_suppliers', 'LA\Detail_SuppliersController');
	Route::get(config('laraadmin.adminRoute') . '/detail_supplier_dt_ajax', 'LA\Detail_SuppliersController@dtajax');

	/* ================== Detail_Proyeks ================== */
	Route::resource(config('laraadmin.adminRoute') . '/detail_proyeks', 'LA\Detail_ProyeksController');
	Route::get(config('laraadmin.adminRoute') . '/detail_proyek_dt_ajax', 'LA\Detail_ProyeksController@dtajax');
});
