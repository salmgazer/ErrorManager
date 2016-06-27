<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use Hash;

class UserController extends Controller
{
    //
    //check if user is autherized to access the system
    public function authuser(){
    	if(!Auth::check()){
    		return view('auth.login');
    		exit();
    	}
    }

    //Redirect if user is not autherized
    public function unautherized(){
    	return redirect('/')
    			->withError('Access', 'You do not have privilege for the action');
    			exit();
    }

    //Report unprivileged attempt to admin
    public function reportToAdmin(){
    	//send email to admin
    	//record attempt to access to db
    }

    //add user view
    public function adduser(Request $request){
    	$this->authuser();
    	if(Auth::user()->type == 'superadmin'){
    		return view('pages.admin.adduser')
    			->with('page_title', 'Add New User | Vodafone')
          ->with('datatables', 'false');
    	}else{
    		//note the person and report to admin
    		$this->unautherized();
    	}
    }

    //add new user --- edit after LDAP
    public function addnewuser(Request $request){
    	 $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password = bcrypt($request->password);
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
        if($request->user_role){
        	$user->role = $request->user_role;
        }
        $user->save();
        return redirect()
        	->back()
        	->with('success', 'You have successfully added '.$user->name);
    }

    public function updateuser($user_id, Request $request){
        $this->authuser();
        if(Auth::user()->type == 'superadmin'){
            $user = User::findOrFail($user_id);
            if($request->password){
                $this->validate($request, [
                    'password' => 'required|min:6|confirmed',
                    ]);
                $user->password = bcrypt($request->password);
            }
            $user->type = $request->user_group;
            if($request->user_role){
                $user->role = $request->user_role;
            }
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
            $user->save();
            return redirect()->back()->with('success', $user->name.' has been updated.');
        }else{
            $this->unautherized();
        }
    }


    //get list of users
    public function getusers(Request $request){
    	$this->authuser();
    	if(Auth::user()->type == 'superadmin'){
    		//key type now suppors name only
    		//get users
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
    			$users = User::get();
    		}
    		return view('pages.admin.home')
    			->with('users', $users)
    			->with('page_title', 'Manage Users | Vodafone')
                ->with('datatables', 'true');
    	}else{
    		//note the person and report to admin
    		$this->unautherized();
    	}
    }

    //Activate a user
    public function activate($user_id){
    	$this->authuser();
    	if(Auth::user()->type == 'superadmin'){
    		$user = User::findOrFail($user_id);
    		if($user->status == 'inactive'){
    			$user->status = 'active';
    			$user->save();
    			if($user->status == 'active'){
    				return redirect()->back()->with('success', $user->name.' is now active');
    			}else{
    				return redirect()->back()->with('failure', $user->name.' is still inactive. Encountered errors!');
    			}
    		}elseif($user->status == 'active'){
    			return redirect()->back()->with('failure', $user->name.' is already active');
    		}
    	}else{
    		$this->unautherized();
    	}
    }

    //Deactivate a user
    public function deactivate($user_id){
    	$this->authuser();
    	if(Auth::user()->type == 'superadmin'){
    		$user = User::findOrFail($user_id);
    		if($user->status == 'active'){
    			$user->status = 'inactive';
    			$user->save();
    			if($user->status == 'inactive'){
    				return redirect()->back()->with('success', $user->name.' is now inactive.');
    			}else{
    				return redirect()->back()->with('failure', $user->name.' is still active. Encountered errors!');
    			}
    		}elseif($user->status == 'inactive'){
    			return redirect()->back()->with('failure', $user->name.' is already inactive!');
    		}
    	}else{
    		$this->unautherized();
    	}
    }

    //edit user
    public function edit($user_id){
    	$this->authuser();
    	if(Auth::user()->type == 'superadmin'){
    		$user = User::findOrFail($user_id);
    		return view('pages.admin.edituser')
    			->with('user', $user)
    			->with('page_title', 'Edit user | Vodafone');
    	}else{
    		$this->unautherized();
    	}
    }


    public function statistics(){
        $this->authuser();
        if(Auth::user()->type == 'admin'){
            return view('pages.admin.statistics')->with('page_title', 'Error Statistics | Vodafone');
        }
        else{
            return $this->unautherized();
        }
    }

    public function getUserDetails(){
        echo '{"name": "'.Auth::user()->name.'", "email": "'.Auth::user()->email.'"}';
        return;
    }

    public function profile(){
        if(Auth::check()){
            return view('pages.admin.profile')
                ->with('page_title', 'Profile | Vodafone')
                ->with('datatables', false);
        }
        else{
            return redirect('/')
                ->with('failure', 'You need to login!');
        }
    }

    public function updatepass(Request $request){
        if(Auth::check()){
            $this->validate($request, [
                'password' => 'required|min:8|confirmed',
                'password_current' => 'required|min:8'
                ]);
            $user =  User::findOrFail(Auth::user()->id);
            if(!Hash::check($request->password_current, $user->password)){
              return redirect()
                ->back()
                ->with('failure', 'The current password you entered is wrong!');
            }
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect('/logout')
                ->with('success', 'Your password has been updated!');
        }else{
            return redirect('/')
                ->with('failure', 'You need to login!');
        }
    }


}
