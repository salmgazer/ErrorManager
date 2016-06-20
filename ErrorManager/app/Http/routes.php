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

Route::get('/', function () {
	authenticateLDAP();
	if(Auth::check()){
		if(Auth::user()->type == 'front_office'){
			return view('pages.front_office.home')->with('page_title', 'Vodafone');
		}
		elseif(Auth::user()->type == 'back_office'){
			return view('pages.back_office.home')->with('page_title', 'Vodafone');;
		}
		elseif(Auth::user()->type == 'admin'){
			return view('pages.admin.errors')->with('page_title', 'Vodafone');
		}
		elseif(Auth::user()->type == 'superadmin'){
			return redirect('/users');
		}else{
			return view('auth.login')->withError('Access Error', 'You do not have access. Contact administrator');
		}
	}else{
		return view('auth.login');
	}
});

Route::get('/register', function(){
	return view('auth.login')->with('Error', 'You do not have access. Contact administrator');
});

//get view to add new user
Route::get('/adduser', 'UserController@adduser');

//add new user
Route::post('/addnewuser', 'UserController@addnewuser');

//get list of users
Route::get('/users', 'UserController@getusers');

//get list of users based on search
Route::post('/users', 'UserController@getusers');

//activate user
Route::get('/users/activate/{user_id}', 'UserController@activate');

//deactivate user
Route::get('/users/deactivate/{user_id}', 'UserController@deactivate');

//Edit user view
Route::get('/users/edit/{user_id}', 'UserController@edit');

//Update user
Route::post('/users/update/{user_id}', 'UserController@updateuser');

//admin actions
//view stats
Route::get('/errors/statistics', 'UserController@statistics');

Route::get('/errors', function(){
	return redirect('/');
});

Route::auth();

Route::get('/home', 'HomeController@index');
