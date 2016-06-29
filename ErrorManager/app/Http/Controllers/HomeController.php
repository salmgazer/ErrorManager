<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //check if user has logged in
      if(Auth::check()){
        //check if user is in front office
        if(Auth::user()->type == 'front_office'){
          return redirect('/errors/single')
            ->with('page_title', 'Vodafone')
            ->with('datatables', 'false')
            ->with('flot', 'false');
        }
        //check is user is in back office
        elseif(Auth::user()->type == 'back_office'){
          return redirect('/errors/single')
            ->with('page_title', 'Vodafone')
            ->with('datatables', 'false')
            ->with('flot', 'false');
        }
        //check if user is an admin
        elseif(Auth::user()->type == 'admin'){
          return redirect('/errors/retry');
        }
        //check if user is superadmin
        elseif(Auth::user()->type == 'superadmin'){
          return redirect('/users');
        }
        //if user does not have access
        else{
          return view('auth.login')->withError('Access Error', 'You do not have access. Contact administrator');
        }
      }
      //if user is logged out already
      else{
        return view('auth.login');
      }
    }



}
