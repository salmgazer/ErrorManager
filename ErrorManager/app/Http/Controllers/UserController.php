<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use Hash;

class UserController extends Controller
{
    //Report unprivileged attempt to admin
    public function reportToAdmin(){
    	//send email to admin
    	//record attempt to access to db
    }

    /**
    *
    * adduser()
    *
    * Takes admin to add user view
    * Return view
    */
    public function adduser(){
      /* Check if user has logged in */
    	if(Auth::check()){
        /* check if user is active */
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
            exit();
        }
        /* check if user is superadmin */
      	if(Auth::user()->type == 'superadmin'){
      		return view('pages.admin.adduser')
      			->with('page_title', 'Add New User | Vodafone Zeus')
            ->with('datatables', 'false')
            ->with('flot', 'false');
      	}else{
          /* redirect user if user is not superadmin */
      		return redirect()
            ->with('failure', 'You do not have access!');
      	}
      }else{
        /* redirect user to login page if user has not logged in */
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * addnewsuer(Request)
    *
    * Adds a new user with specific role to the stream_copy_to_stream
    * @param $request is a POST Request
    * return view - Add user view
    */
    public function addnewuser(Request $request){
      /* Check if user has logged in */
    	if(Auth::check()){
        /* check if user is active */
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
            exit();
        }
        if(Auth::user()->type == 'superadmin'){
            /* validate form inputs from add user form */
        	 $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            /* create new User object and update with validated form inputs */
            $user = new User();
            $user->name= $request->name;
            $user->email= $request->email;
            $user->password = bcrypt($request->password);
            $cur_group = null;
            /* assign new user a group */
            switch ($request->user_group) {
            	case 'Front office':
            		$cur_group = 'front_office';
            		break;
            	case 'Back office':
            		$cur_group = 'back_office';
            		break;
            	case 'Admin':
            		$cur_group = 'admin';
            		break;
            	case 'Superadmin':
            		$cur_group = 'superadmin';
            		break;
            	default:
            		# code...
            		break;
            }
            $user->type = $cur_group;
            /* set user's role if parsed via add user form */
            if($request->user_role){
            	$user->role = $request->user_role;
            }
            /* commit changes made to new User object in db */
            $user->save();
            /* redirect back to add user form with an success alert */
            return redirect()
            	->back()
            	->with('success', 'You have successfully added '.$user->name);
            }else{
              /* redirect user to homepage because he has not right to access add new page */
              return redirect('/')
                ->with('failure', 'You do not have access!');
            }
          }else{
            /* redirect user to log in because user is logged out */
            return redirect('/')
              ->with('failure', 'You need to login!');
          }
    }

    /**
    *
    * updateuser
    *
    * @param $user_id is a user's account id
    * @param $request is a POST Request
    * return view
    */
    public function updateuser($user_id, Request $request){
      /* Check if user has logged in */
        if(Auth::check()){
          /* check if user is active */
          if(Auth::user()->status == 'inactive'){
            return view('auth.login')
              ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
              exit();
          }
          /* Check if user is superadmin */
          if(Auth::user()->type == 'superadmin'){
              $user = User::findOrFail($user_id);
              if($request->password){
                /* validate form inputs */
                  $this->validate($request, [
                      'password' => 'required|min:6|confirmed',
                      ]);
                  $user->password = bcrypt($request->password);
              }
              $user->type = $request->user_group;
              if($request->user_role){
                  $user->role = $request->user_role;
              }
              /* Assign user to a group */
              $cur_group = null;
              switch ($request->user_group) {
              case 'Front office':
                  $cur_group = 'front_office';
                  break;
              case 'Back office':
                  $cur_group = 'back_office';
                  break;
              case 'Admin':
                  $cur_group = 'admin';
                  break;
              case 'Superadmin':
                  $cur_group = 'superadmin';
                  break;
              default:
                  # code...
                  break;
              }
              $user->type = $cur_group;
              /* Commit changes made to user in db */
              $user->save();
              /* redirect back to updae user page with success message */
              return redirect()->back()->with('success', $user->name.' has been updated.');
          }else{
            /* redirect back homepage because user has no access */
              return redirect('/')
                ->with('failure', 'You do not have access');
          }
        }else{
          /* redirect to login page because user is logged out */
          return redirect('/')
            ->with('failure', 'You need to login!');
        }
    }


    /**
    * getusers(Request $request)
    *
    * Returns all
    * @param $request is a POST Request
    * return view
    */
    public function getusers(Request $request){
      /* check if user has logged in */
    	if(Auth::check()){
        /* check if user is active */
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
            exit();
        }
      	if(Auth::user()->type == 'superadmin'){
      		/* key type now supports name only */
          /* if user searches without a key value */
      		$key      = $request->key;
      		$key_type = $request->key_type;
      		$users = null;
      		if($key == null && $key_type != null){
      			switch ($key_type) {
      				case 'Name':
      					$users = User::get();
      					break;
      				default:
      					# code...
      					break;
      			}
      		}
          /* if user searches with a key value */
      		elseif($key != null && $key_type != null){
      			switch ($key_type) {
      				case 'Name':
      					$users = User::where('name','LIKE', '%'.$key.'%')->get();
      					break;
      				default:
      					# code...
      					break;
      			}
      		}elseif($key == null && $key_type == null){
      			$users = User::orderBy('status', 'desc')->get();
      		}
      		return view('pages.admin.home')
      			->with('users', $users)
      			->with('page_title', 'Manage Users | Vodafone Zeus')
            ->with('datatables', 'true')
            ->with('flot', 'false');
      	}else{
      		/* redirect user to homepage because user has no access */
      		return redirect('/')
            ->with('failure', 'You do not have access');
      	}
      }else{
        /* redirect to login page because user has logged out */
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * activate($user_id)
    *
    * Activates a user account
    * @param $user_id is a user's id
    * return view
    */
    public function activate($user_id){
      /* check if user has logged in */
    	if(Auth::check()){
        /* check if user is active */
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
            exit();
        }
        /* check if user is superadmin */
      	if(Auth::user()->type == 'superadmin'){
          /* load user account into a User object */
      		$user = User::findOrFail($user_id);
          /* set user status to active if user is inactive */
      		if($user->status == 'inactive'){
      			$user->status = 'active';
      			$user->save();
            /* redirect back if user is already active with message */
      			if($user->status == 'active'){
      				return redirect()->back()->with('success', $user->name.' is now active');
      			}else{
              /* redirect back with error message if system failed to activate user */
      				return redirect()->back()->with('failure', $user->name.' is still inactive. Encountered errors!');
      			}
      		}elseif($user->status == 'active'){
            /* redirect back with success message if user is successfully activated */
      			return redirect()->back()->with('failure', $user->name.' is already active');
      		}
      	}else{
          /* redirect user to homepage because user has no right to access */
      		return redirect('/')
            ->with('failure', 'You do not have access!');
      	}
      }else{
        /* redirect user to login page because user is logged out */
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * deactivate($user_id)
    * @param $user_id is a user's id value
    * return view
    */
    public function deactivate($user_id){
      /* check if user has logged in */
    	if(Auth::check()){
        /* check if user is active */
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
            exit();
        }
        /* check if user is a superadmin */
      	if(Auth::user()->type == 'superadmin'){
          /* load user account from db into User object */
      		$user = User::findOrFail($user_id);
          /* deactivate user if user if active */
      		if($user->status == 'active'){
      			$user->status = 'inactive';
            /* commit changes to user object to db */
      			$user->save();
      			if($user->status == 'inactive'){
              /* redirect back with success message */
      				return redirect()->back()->with('success', $user->name.' is now inactive.');
      			}else{
              /* redirect with error message if system failed to deactivate user */
      				return redirect()->back()->with('failure', $user->name.' is still active. Encountered errors!');
      			}
      		}elseif($user->status == 'inactive'){
            /* redirect with failre message when user is alread inactive */
      			return redirect()->back()->with('failure', $user->name.' is already inactive!');
      		}
      	}else{
          /* redirect user to homepage because user has no access */
      		return redirect('/')
            ->with('failure', 'You do not have access!');
      	}
      }else{
        /* redirect user to login page because user is logged out */
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    * edit($user_id)
    *
    * makes changes to a user's account details
    * @param $user_id is a user's id value
    */
    public function edit($user_id){
      /* check if user has logged in */
    	if(Auth::check()){
        /* check if user is active */
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
            exit();
        }
        /* check if user is a superadmin */
      	if(Auth::user()->type == 'superadmin'){
          /* load user account into a User object */
      		$user = User::findOrFail($user_id);
          /* load edituser view with user details */
      		return view('pages.admin.edituser')
      			->with('user', $user)
      			->with('page_title', 'Edit user | Vodafone Zeus')
            ->with('datatables', 'false')
            ->with('flot', 'false');
      	}else{
          /* redirect to homepage because user has no right to access */
      		return redirect('/')
            ->with('failure', 'You do not have access!');
      	}
      }else{
        /* redirect to login page becuase user has been logged out */
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * statistics()
    *
    * shows statistics of errors
    * return view
    */
    public function statistics(){
      /* chck if user has logged in */
        if(Auth::check()){
          /* check if user is active */
          if(Auth::user()->status == 'inactive'){
            return view('auth.login')
              ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
              exit();
          }
          /* check if user s an admin */
          if(Auth::user()->type == 'admin'){
            /* returnstatistics view */
              return view('pages.admin.statistics')
                ->with('page_title', 'Error Statistics | Vodafone Zeus')
                ->with('datatables', 'false')
                ->with('flot', 'false');
          }
          else{
            /* redirect to homepage becuase user has no right to access */
              return redirect('/')
                ->with('failure', 'You do not have access');
          }
        }else{
          /* redirect to login page because user has been logged out */
          return redirect('/')
            ->with('failure', 'You need to login!');
        }
    }

    /**
    *
    * profile()
    *
    * displays user's account details, with view to change password
    * return view
    */
    public function profile(){
      /* check if user has logged in */
        if(Auth::check()){
          /* check if user is active */
          if(Auth::user()->status == 'inactive'){
            return view('auth.login')
              ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
              exit();
          }
          /* return user profle page */
            return view('pages.admin.profile')
                ->with('page_title', 'Profile | Vodafone Zeus')
                ->with('datatables', 'false')
                ->with('flot', 'false');
        }
        else{
          /* redirect user to login page becuse user has been logged out */
            return redirect('/')
                ->with('failure', 'You need to login!');
        }
    }

    /**
    *
    * updatepass
    *
    * updates password of a user
    * @param $request is a POST Request
    * return view
    */
    public function updatepass(Request $request){
      /* check if user has logged in */
        if(Auth::check()){
          /* check if user is active */
          if(Auth::user()->status == 'inactive'){
            return view('auth.login')
              ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
              exit();
          }
          /* validate form inputs */
            $this->validate($request, [
                'password' => 'required|min:8|confirmed',
                'password_current' => 'required|min:8'
                ]);
            /* load user account into a User object */
            $user =  User::findOrFail(Auth::user()->id);
            /* check if user current password matches the claimed current password */
            if(!Hash::check($request->password_current, $user->password)){
              /* redirect back with error if submitted current password does not match actual current password */
              return redirect()
                ->back()
                ->with('failure', 'The current password you entered is wrong!');
            }
            /* change password to new password */
            $user->password = bcrypt($request->password);
            /* commit changes made to User object to db */
            $user->save();
            /* logout user so user logs in with new password */
            return redirect('/logout')
                ->with('success', 'Your password has been updated!');
        }else{
          /*redirect user if user has been logged out */
            return redirect('/')
                ->with('failure', 'You need to login!');
        }
    }


}
