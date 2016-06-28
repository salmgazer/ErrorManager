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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/register', function(){
	return view('auth.login')->with('Error', 'You do not have access. Contact administrator');
});

//get view to add new user
Route::get('/adduser', ['as' => 'Add user', 'uses' => 'UserController@adduser']);

//add new user
Route::post('/addnewuser', 'UserController@addnewuser');

//get list of users
Route::get('/users', ['as' => 'users', 'uses' => 'UserController@getusers']);

//get list of users based on search
Route::post('/users', 'UserController@getusers');

//update profle view
Route::get('/profile', ['as' => 'Profile', 'uses' => 'UserController@profile']);

//update password
Route::post('/profile/updatepass', 'UserController@updatepass');

//activate user
Route::get('/users/activate/{user_id}', 'UserController@activate');

//deactivate user
Route::get('/users/deactivate/{user_id}', 'UserController@deactivate');

//Edit user view.
Route::get('/users/edit/{user_id}', ['as' => 'Update user', 'uses' => 'UserController@edit']);

//Update user
Route::post('/users/update/{user_id}', 'UserController@updateuser');

//admin actions
//view stats
Route::get('/errors/statistics', 'UserController@statistics');

//move to errors retry page
Route::get('/errors/retry', ['as' => 'Bulk Resubmit', 'uses' => 'ErrorController@errors_retry']);

//moves to errors in porgress with oc name --view
Route::get('/errors/bulk_in_progress', ['as'=> 'Bulk In Progress (oc_name)', 'uses' => 'ErrorController@in_progress_name']);

//move to errors in progress with id --view
Route::get('/errors/bulk_in_progress_id', ['as'=> 'Bulk In Progress (oc_id)', 'uses' => 'ErrorController@in_progress_id']);

//Dealing with errors
//Bulk errors upload
Route::post('/errors/bulkupload/', 'ErrorController@bulkupload');

//Result bulk
Route::get('/errors/resolvebulk', 'ErrorController@resolvebulk');

Route::get('/bulk_resolve/{bulk_file_id}', 'ErrorController@bulk_resolve');

//get all errors of a bulk error file after processing
Route::get('/bulk_details/{bulk_file_id}','ErrorController@bulk_details');

//upload single error
Route::get('/errors/single', ['as' => 'Single Errors', 'uses' => 'ErrorController@single']);

//store single error
Route::post('/errors/singleupload', 'ErrorController@singleupload');

//store single error, front office
Route::post('/errors/singleuploadf', 'ErrorController@singleuploadf');

Route::auth();

//Route::get('/home', 'HomeController@index');

Route::get('/getuserdetails', 'UserController@getUserDetails');


//Future
//Bulk errors history
Route::get('/errors/history', ['as' => 'Bulk Errors - History', 'uses' => 'ErrorController@bulk_history']);

//Single Errors report
Route::get('/errors/report', ['as' => 'Single Errors - History', 'uses' => 'ErrorController@single_errors_history']);

//resolve single errors
Route::get('/resolve_error/{error_id}', 'ErrorController@resolve_error');
