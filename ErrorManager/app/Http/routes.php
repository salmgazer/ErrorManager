<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Base directory
$base_dir = '/';

function authenticateLDAP(){
	//authenticate on LDAP
}

Route::get($base_dir, ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get($base_dir.'register', function(){
	return view('auth.login')->with('Error', 'You do not have access. Contact administrator');
});

Route::get($base_dir.'login', function(){
	return view('auth.login');
});

//get view to add new user
Route::get($base_dir.'adduser', ['as' => 'Add user', 'uses' => 'UserController@adduser']);

//add new user
Route::post($base_dir.'addnewuser', 'UserController@addnewuser');

//get list of users
Route::get($base_dir.'users', ['as' => 'users', 'uses' => 'UserController@getusers']);

//get list of users based on search
Route::post($base_dir.'users', ['as' => 'users', 'uses' => 'UserController@getusers']);

//update profle view
Route::get($base_dir.'profile', ['as' => 'Profile', 'uses' => 'UserController@profile']);

//update password
Route::post($base_dir.'profile/updatepass', 'UserController@updatepass');

//activate user
Route::get($base_dir.'users/activate/{user_id}', 'UserController@activate');

//deactivate user
Route::get($base_dir.'users/deactivate/{user_id}', 'UserController@deactivate');

//Edit user view.
Route::get($base_dir.'users/edit/{user_id}', ['as' => 'Update user', 'uses' => 'UserController@edit']);

//Update user
Route::post($base_dir.'users/update/{user_id}', 'UserController@updateuser');

//admin actions
//view stats
Route::get($base_dir.'errors/statistics', 'UserController@statistics');

//move to errors retry page
Route::get($base_dir.'errors/retry', ['as' => 'Bulk Resubmit', 'uses' => 'ErrorController@errors_retry']);

//moves to errors in porgress with oc name --view
Route::get($base_dir.'errors/bulk_in_progress', ['as'=> 'Bulk In Progress (oc_name)', 'uses' => 'ErrorController@in_progress_name']);

//move to errors in progress with id --view
Route::get($base_dir.'errors/bulk_in_progress_id', ['as'=> 'Bulk In Progress (oc_id)', 'uses' => 'ErrorController@in_progress_id']);

//Dealing with errors
//Bulk errors upload
Route::post($base_dir.'errors/bulkupload/', 'ErrorController@bulkupload');

//Result bulk
Route::get($base_dir.'errors/resolvebulk', 'ErrorController@resolvebulk');

Route::get($base_dir.'bulk_resolve/{bulk_file_id}', 'ErrorController@bulk_resolve');

//get all errors of a bulk error file after processing
Route::get($base_dir.'bulk_details/{bulk_file_id}','ErrorController@bulk_details');

//upload single error
Route::get($base_dir.'errors/single', ['as' => 'Single Errors', 'uses' => 'ErrorController@single']);

//store single error
Route::post($base_dir.'errors/singleupload', 'ErrorController@singleupload');

//store single error, front office
Route::post($base_dir.'errors/singleuploadf', 'ErrorController@singleuploadf');

Route::auth();

//Route::get('/home', 'HomeController@index');

Route::get($base_dir.'getuserdetails', 'UserController@getUserDetails');


//Future
//Bulk errors history
Route::get($base_dir.'errors/history', ['as' => 'Bulk Errors - History', 'uses' => 'ErrorController@bulk_history']);

//Single Errors report
Route::get($base_dir.'errors/report', ['as' => 'Single Errors - History', 'uses' => 'ErrorController@single_errors_history']);

//resolve single errors
Route::get($base_dir.'resolve_error/{error_id}', 'ErrorController@resolve_error');
