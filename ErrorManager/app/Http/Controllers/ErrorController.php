<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Carbon\Carbon;
use App\BulkFile;
use App\Error;
use Excel;
use App\User;

class ErrorController extends Controller
{
    /***** instance variables *******/
    protected $bulk_file;

    protected $success_count = 0;

    protected $count = 0;

    /**** end instance variables ****/


    /********************  Redirects *****************/

    /**
    *
    * errors_retry()
    *
    * Takes admin to bulk errors page, mainly bulk Resubmit page
    * return view
    */
    public function errors_retry(){
      /* check if user has logged in */
        if(Auth::check()){
          /* check if user is active */
          if(Auth::user()->status == 'inactive'){
            return view('auth.login')
              ->with('failure', 'You are not an active user. Contact administrator to activate your account!');
              exit();
          }
            /* check if user is an admin */
            if(Auth::user()->type == 'admin'){
              /* get all Bulk Errors file uploaded by current user */
                $bulkfiles = Auth::user()
                    ->bulkfiles()
                    ->where('operation', 'Resubmit')
                    ->orderBy('created_at', 'desc')
                    ->get();
                /* return errors page with bulk Resubmit bulk errors files by user */
                return view('pages.admin.errors')
                    ->with('page_title', 'Bulk errors | Vodafone Zeus')
                    ->with('bulkfiles', $bulkfiles)
                    ->with('datatables', 'false')
                    ->with('flot', 'false');
            }else{
              /* redirect to homepage because user has not right to access */
                return redirect('/')
                    ->with('failure', 'You do not have access!');
            }
        }else{
          /* redirect to login page becuase user has been logged out */
            return redirect('/')
                ->with('failure', 'You need to log in!');
        }
    }

    /**
    *
    * in_progress_name()
    *
    * loads bulk errors with in progress scenario that require oc_name
    * return view
    */
    public function in_progress_name(){
      /* check if user has logged in*/
        if(Auth::check()){
          /* check if user is an admin */
            if(Auth::user()->type == 'admin'){
              /* get all bulk errors file with in progress scenario that include oc_name, uploaded by user */
                $bulkfiles = Auth::user()
                    ->bulkfiles()
                    ->where('operation', 'In progress')
                    ->where('by_id', 'no')
                    ->orderBy('created_at', 'desc')
                    ->get();
                /* return view for bulk in progress, case of oc_name */
                return view('pages.admin.in_progress_name')
                    ->with('page_title', 'Bulk In Progress errors | Vodafone Zeus')
                    ->with('bulkfiles', $bulkfiles)
                    ->with('datatables', 'false')
                    ->with('flot', 'false');
                 }else{
                   /* redirect to homepage if user has no right to access */
                return redirect('/')
                    ->with('failure', 'You do not have access!');
            }
        }else{
          /* redirect to login page id user has been logged out */
            return redirect('/')
                ->with('failure', 'You need to log in!');
        }
    }


    public function in_progress_id(){
        if(Auth::check()){
            if(Auth::user()->type == 'admin'){
                $bulkfiles = Auth::user()
                    ->bulkfiles()
                    ->where('operation', 'In progress')
                    ->where('by_id', 'yes')
                    ->orderBy('created_at', 'desc')
                    ->get();
                return view('pages.admin.in_progress_id')
                    ->with('page_title', 'Bulk In Progress errors | Vodafone Zeus')
                    ->with('bulkfiles', $bulkfiles)
                    ->with('datatables', 'false')
                    ->with('flot', 'false');
                 }else{
                return redirect('/')
                    ->with('failure', 'You do not have access!');
            }
        }else{
            return redirect('/')
                ->with('failure', 'You need to log in!');
        }
    }
    /***************** end Redirects *****************/

    //decides what request xml request to send
    public function master_resolve($error, $by_id='no', $action=null){
        //the case of Retry Failed Orders
        if($operation == 'Resubmit'){
            if($error->scenario == null){
                return $this->resolve_failed_orders($error->oc_id, 'Null');
            }else{
                return $this->resolve_failed_orders($error->oc_id, 'FC_'.$error->scenario);
            }
        }
        //the case of Resolve OC In Progress (by OC name) -- acton i given
        elseif($operation == 'In progress'){
            if($by_id =='no'){
                //in progres with oc_name
                return $this->resolve_oc_in_progress_name($error->oc_id, $action, $error->scenario);
            }elseif($by_id == 'yes'){
                //in progress without oc_name
                return $this->resolve_oc_in_progress_id($error->oc_id, $action);
            }
        }
    }


    /*** Single Error Actions ***/
    public function resolve_error($error_id){
      $error = Error::findOrFail($error_id);
    //  $result = $this->master_resolve($error);
      //simulate
      $result = 'failure';
      if(($error->id % 2) == 0){
        $result = 'success';
      }
      $error->tried = 'yes';
      if($result == 'success'){
        $error->status = 'success';
        $error->save();
        echo '{"result": 1}';
        return;
      }else{
        $error->status = 'failed';
        $error->save();
        echo '{"result": 0}';
        return;
      }
    }

    public function resolve_oc_in_progress_name($oc_id, $action, $scenario){
        //xml request
    }

    //Function for resolving an oc in progress :: RETRY, FAILED,
    public function resolve_oc_in_progress_id($oc_id, $action){
        //xml request
    }

    //Function for resubmitting
    public function resolve_failed_orders($oc_id, $action_scenario){
        //xml request
    }

    /****************** Single Error Actions ****************/


    /****************** Bulk Error Actions *******************/

    /*get oc_ids that are not already being worked on */
    public function get_all_new_ocs($rows){
        $ocs = array();
        foreach ($rows as $row) {
            if(!Error::where('oc_id', $row->oc_id)->count()){
                array_push($ocs, $row);
            }
        }
        return $ocs;
    }

    //main bulk resolve function
    public function bulk_resolve($bulk_id){
        if(Auth::check()){
            if(Auth::user()->type == 'admin'){
                $base_file_dir = base_path() . '/public/files/error_files/new/';
                $this->bulk_file = BulkFile::findOrFail($bulk_id);
                Excel::load($base_file_dir . $this->bulk_file->filename, function($reader) {

                    //decide how to read csv
                    if($this->bulk_file->by_id == 'yes'){
                        $reader->get(array('oc_id'));               //get only oc_id column from csv
                    }elseif($this->bulk_file->by_id =='no'){
                        $reader->get(array('oc_id', 'oc_name'));
                    }

                    //get all unique rows
                    $csv_rows = $reader->get();
                    $rows = $this->get_all_new_ocs($csv_rows);                     //get all oc_id rows

                    /** if file does not have correct columns **/
                    if(!$rows){
                        echo '{"result": 0, "message": "File does not have new oc_id and oc_name columns!"}';
                        return;
                    }

                    $this->bulk_file->status = 'processed';     //state that file has been visited

                    echo '{"result": 1, "errors": [';           //Store each error in json

                    //process and save each error into db
                    $this->process_bulk_errors($rows);

                    echo '],';
                    if(!$this->success_count == 0){
                        $this->bulk_file->success_rate = (double)($this->success_count / $this->count);
                        echo '"success_rate": '.$this->bulk_file->success_rate.'';
                    }else{
                        echo '"success_rate": '.$this->success_rate.'';
                    }
                    echo "}";
                    $this->bulk_file->status =  'processed';
                    $this->bulk_file->save();
                    //clean up instance
                    $this->bulk_file = null;                         //set bulk_file to null
                    $this->success_count = 0;
                    $this->count = 0;
                    return;

                });
            }else{
                return redirect()                                //if user has not right to access function
                    ->with('failure', 'You do not have access!');
            }
        }else{
            return redirect('/')                                 //if user has not logged in
                ->with('failure', 'You need to first login');
        }
    }

    //save bulk errors into db and try to resolve
    private function process_bulk_errors($rows){
        $last_row = $rows[sizeof($rows) - 1];       //get the last_row in oc_id column
        foreach($rows as $row){
            //save error in errors table
            $this->count += 1;
            $error =  new Error();
            $error->oc_id = $row->oc_id;
            if($this->bulk_file->by_id == 'no'){
                $error->scenario = $row->oc_name;
            }
            $error->user_id = Auth::user()->id;
            $error->by_scenario = 'yes';
            $error->action = $this->bulk_file->action;
            $error->bulk_id = $this->bulk_file->id;
            $error->operation = $this->bulk_file->operation;

            //send xml http_request(method, url)
            //$xml_result = $this->master_resolve();

            $error->tried = 'yes';
            if($this->count % 2 == 0){
                $error->status = 'success';
            }
            else{
                $error->status = 'failed';
            }
            if($error->status == 'success')
                $this->success_count += 1;
            $error->save();                    //save error state in db
            echo json_encode($error);          //convert error row into json format
            if($row != $last_row){
                echo ",";
            }
        }
    }

    /***************** End Bulk errors **********************/

/*************  Redirection and other functions **************/

	//upload bulk file first into folder
    public function bulkupload(Request $request){
      if(Auth::check()){
      	if(Auth::user()->type == 'admin'){
              $this->validate($request, [
                  'operation' => 'required'
                  ]);
      		$file = $request->file('errors_file');
      		$file_extension = $file->getClientOriginalExtension();
      		if($file->isValid()){
      			if($file_extension == 'csv' || $file_extension == 'xlsx'){
      				$datetime = Carbon::now();
  		    		$filename =  $file->getClientOriginalName();
  		    		//move file to directory
  		    		$file->move(base_path() . '/public/files/error_files/new/', $filename);
  		    		//new bul file instance
  		    		$bulkfile = new BulkFile();
  		    		$bulkfile->filename = $filename;
  		    		$bulkfile->user_id = Auth::user()->id;
  		    		$bulkfile->operation = $request->operation;
                      if($request->by_id){
                          $bulkfile->by_id = $request->by_id;
                      }
                      if($request->action){
                          $bulkfile->action = $request->action;
                      }
  		    		$bulkfile->save();
  		    	return redirect()
  		    		->back()
  		    		->with('success', 'Ready to resolve errors');
  	    		}else {
  	    			return redirect()
  	    				->back()
  	    				->with('failure', 'Upload only .csv or .xlsx files');
  	    		}
      		}else{
      			return redirect()
      				->back()
      				->with('failure', 'File is corrupted, try again!');
      		}
      	}else{
      		return redirect('/')
      			->withError('Access', 'You do not have access');
      	}
      }else{
        return redirect()
          ->with('failure', 'You need to login!');
      }
    }

    //move to single errors page
    public function single(){
      if(Auth::check()){
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'Your account is inactive. Contact Administrator to activate your account.');
            exit();
        }
      	if(Auth::user()->type == 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
      		$errors = Auth::user()->errors()->orderBy('created_at', 'desc')->get();
      			return view('pages.front_office.single')
      				->with('oc_errors', $errors)
      				->with('page_title', 'Single Error | Vodafone Zeus')
      				->with('datatables', 'false')
              ->with('flot', 'false');
      	}else{
      		return redirect('/')
      			->withError('failure', 'You do not have access');
      	}
      }else{
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    //move to single errors History page
    public function single_errors_history(){
      if(Auth::check()){
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
          //bar chart
          $errors = (User::findOrFail(Auth::user()->id));
          $errors_success = count(Error::where('user_id', Auth::user()->id)->where('status', 'success')->get());
          $errors_failure = count(Error::where('user_id', Auth::user()->id)->where('status', 'failed')->get());

          //pie Chart
          $null = count(Error::where('user_id', Auth::user()->id)->where('scenario', null)->get());
          $billing =  count(Error::where('user_id', Auth::user()->id)->where('scenario', 'Billing.CBS.ActivateSubscriber')->get());
          $smtp = count(Error::where('user_id', Auth::user()->id)->where('scenario', 'Communications.SMTP.SendEmail')->get());
          $timeout = count(Error::where('user_id', Auth::user()->id)->where('scenario', 'Time out')->get());
          $vb = count(Error::where('user_id', Auth::user()->id)->where('scenario', '|')->get());

          return view('pages.front_office.report')
            ->with('page_title', 'Report - Single Errors | Vodafone Zeus')
            ->with('datatables', 'false')
            ->with('errors_success', $errors_success)
            ->with('errors_failure', $errors_failure)
            ->with('null', $null)
            ->with('billing', $billing)
            ->with('smtp', $smtp)
            ->with('timeout', $timeout)
            ->with('vb', $vb)
            ->with('flot', 'true');
        }else{
          return redirect('/')
            ->withError('failure', 'You do not have access');
        }
      }else{
        return redirect('/')
          ->withError('failure', 'You need to login!');
      }
    }

    //move to bulk history page
    public function bulk_history(){
      if(Auth::check()){
        if(Auth::user()->type == 'admin'){
          return view('pages.admin.history')
            ->with('page_title', 'History - Bulk Errors | Vodafone Zeus')
            ->with('datatables', 'false')
            ->with('flot', 'false');
        }else{
          return redirect('/')
            ->with('failure', 'You do not have access!');
        }
      }else{
        return redirect('/')
          ->with('failure', 'You need to login!');
      }
    }

    //upload single error -- admin
    public function singleupload(Request $request){
      if(Auth::check()){
      	if(Auth::user()->type == 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
      		$this->validate($request, [
      			'oc_id' => 'required|unique:errors',
      			'operation' => 'required'
      			]);

      		$error = new Error();
      		$error->operation = $request->operation;
      		$error->oc_id = $request->oc_id;
      		$error->user_id = Auth::user()->id;
      		$error->save();
      		return redirect()
      			->back()
      			->with('error', $error);
      	}else{
      		return redirect('/')
      			->withError('Access', 'You do not have access');
      	}
      }else {
        return redirect()
          ->with('failure', 'You need to login!');
      }
    }

    //upload single error -- front office
    public function singleuploadf(Request $request){
      if(Auth::check()){
        if(Auth::user()->type = 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
            //validate
            $this->validate($request, [
                'oc_id' => 'required',
                'scenario' => 'required'
                ]);
            $error = new Error();
            $error->scenario = $request->scenario;
            $error->oc_id = $request->oc_id;
            $error->by_scenario = 'yes';
            $error->user_id = Auth::user()->id;
            $error->save();
            return redirect()
                ->back()
                ->with('error', $error);
        }else{
            return redirect('/')
                ->withError('Access', 'You do not have access');
        }
      }else{
        return redirect('/')
            ->with('Access', 'You need to login!');
      }
    }

    //view details of errors with a comman bulk_id
    public function bulk_details($bulk_id){
        if(Auth::check()){
            if(Auth::user()->type == 'admin'){
                $errors = Error::where('bulk_id', $bulk_id)->get();
                $last_row = $errors[sizeof($errors) - 1];
                echo '{"result": 1, "errors": [';
                foreach($errors as $error){
                    echo json_encode($error);
                    if($error != $last_row){
                        echo ",";
                    }
                }
                echo "]}";
                return;
            }else{
                return redirect('/')
                    ->withError('Access', 'You do not have access');
            }
        }else{
            return redirect('/')
                ->withError('failure', 'You need to login');
        }

    }

/************ End  Redirection and other functions   *********/
}
