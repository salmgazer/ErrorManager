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
use Parser;

class ErrorController extends Controller
{
    /***** instance variables *******/

    protected $base_dir = '/';

    /**
    * $bulk_file hosts an instance of a bulk errors fle being resolved
    */
    protected $bulk_file;

    /**
    * $success_count holds count of successful attempts when resolving bulk errors
    */
    protected $success_count = 0;

    /**
    * $count holds count of errors that do not already exist in db
    */
    protected $count = 0;

    /**** end instance variables ****/


    /**************** SOAP XML Requests **************/

    /**
    *
    * retry_failed_orders_xml($username, $integration_id, $order_id, $reason)
    *
    * creates the xml format for each error that required a resubmit
    *
    * @param $username username of the one sending Requests
    * @param $integration_id is the integration_id
    * @param $order_id is the id of the error to be resolved (oc_id)
    * @param $reason is the scenario of the error
    * @return String (xml ouput)
    */
    public function retry_failed_orders_xml($username=null, $order_id, $reason){
      $final_xml = '
          <?xml version="1.0" encoding="UTF-8"?>
          <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope" xmlns:com="http://com.telco.to2f.support.services/">
            <soapenv:Header>
              <com:HeaderRequest>
                <UserName>'.$username.'</UserName>
              <com:HeaderRequest>
            </soapenv:Header>
            <soapenv:Body>
              <com:RetryFailedOrders>
                <OrderIDs>'.$order_id.'</OrderIDs>
                <Reason>FC_'.$reason.'</Reason>
              </com:RetryFailedOrders>
            </soapenv:Body>
          </soapenv:Envelope>';
      return $final_xml;
    }

    /**
    *
    * resolve_oc_in_progress_name_xml($username, $integration_id, $order_id, $action, $reason)
    *
    * creates xml format for each error with the In Progress scenario using the oc_name and oc_id
    *
    * @param $username is username of person sending request
    * @param $integration_id is integration is
    * @param $order_id is the id of error to be resolved (oc_id)
    * @param $action is the action to be performed on OC (RETRY, FC, FAILED)
    * @param $function_name is the scenario of the error (oc_name)
    * @return String (xml output)
    */
    public function resolve_oc_in_progress_name_xml($username=null, $order_id, $action, $function_name){
      $final_xml = '
          <?xml version="1.0" encoding="UTF-8"?>
          <soapenv:Envelope xmlsn:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://com.telco.to2f.support.services/">
            <soapenv:Header>
              <com:HeaderRequest>
                <UserName>'.$username.'</UserName>
              </com:HeaderRequest>
            </soapenv:Header>
            <soapenv:Body>
              <com:ResolveOCInProgressByName>
                <OrderIDs>'.$order_id.'</OrderIDs>
                <Action>
                  <ActionType>'.$action.'</ActionType>
                </Action>
                <FunctionName>'.$functon_name.'</FunctionName>
              </com:ResolveOCInProgressByName>
            </soapenv:Body>
          </soapenv:Envelope>';
      return $final_xml;
    }

    /**
    *
    * resolve_oc_in_progress_id_xml($username, $order_id, $action)
    *
    * creates xml format for each of the In Progress errors that need to be resolved
    * @param $username is the name of the user sending the Requests
    * @param $order_id is the id of the error to be resolved (oc_id)
    * @param $action is the action to be performed on the oc (RETRY, FC, FAILED)
    * @return String (xml ouput)
    */
    public function resolve_oc_in_progress_id_xml($username=null, $order_id, $action){
      $final_xml = '
          <?xml version="1.0" encoding="UTF-8"?>
          <soapenv:Envelope xmlsn:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://com.telco.to2f.support.services/">
            <soapenv:Header>
              <com:HeaderRequest>
                <UserName>'.$username.'</UserName>
              </com:HeaderRequest>
            </soapenv:Header>
            <soapenv:Body>
              <com:ResolveOCInProgressByOCID>
                <OrderIDs>'.$order_id.'</OrderIDs>
                <Action>
                  <ActionType>'.$action.'</ActionType>
                </Action>
              </com:ResolveOCInProgressByOCID>
            </soapenv:Body>
          </soapenv:Envelope>';
      return $final_xml;
    }

    /**************** End SOAP XML Requests **********/


    /********************  Redirects *****************/

    /**
    *
    * errors_retry()
    *
    * Takes admin to bulk errors page, mainly bulk Resubmit page
    *
    * @return view
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
                return redirect($this->base_dir)
                    ->with('failure', 'You do not have access!');
            }
        }else{
          /* redirect to login page becuase user has been logged out */
            return redirect($this->base_dir.'login')
                ->with('failure', 'You need to log in!');
        }
    }

    /**
    *
    * in_progress_name()
    *
    * loads bulk errors with in progress scenario that require oc_name
    *
    * @return view
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
                return redirect($this->base_dir)
                    ->with('failure', 'You do not have access!');
            }
        }else{
          /* redirect to login page id user has been logged out */
            return redirect($this->base_dir.'login')
                ->with('failure', 'You need to log in!');
        }
    }

    /**
    *
    * in_progress_id()
    *
    * loads bulk errors with in progress scenario that require oc_id only
    *
    * @return view
    */
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
                return redirect($this->base_dir)
                    ->with('failure', 'You do not have access!');
            }
        }else{
            return redirect($this->base_dir.'login')
                ->with('failure', 'You need to log in!');
        }
    }
    /***************** end Redirects *****************/

    /**
    *
    * master_resolve($error, $by_id, $action)
    *
    * Decides what request xml request to send
    *
    *
    */
    public function master_resolve($error, $by_id='no', $action=null){
        /* the case of Retry Failed Orders */
        if($error->operation == 'Resubmit'){                                                           //if operation type is Resubmit
            if($error->scenario == null){                                                       //when scenario of error is null
                return $this->resolve_failed_orders($error->oc_id, 'Null');                     //call resolve_failed_orders
            }else{                                                                              //when scenario is not null
                switch ($error->scenario) {
                  case 'Time out':
                    return $this->resolve_failed_orders($error->oc_id, 'Null');                 //call resolve_failed_orders and parse Null
                    break;
                  case '|':
                    return $this->resolve_failed_orders($error->oc_id, 'Null');                 //call resolve_failed_orders and parse Null
                    break;
                  default:
                    return $this->resolve_failed_orders($error->oc_id, 'FC_'.$error->scenario); //call resolve_failed_orders and parse scenario
                    break;
                }
            }
        }
        /* the case of Resolve OC In Progress (by OC name) -- acton i given */
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


    /**
    *
    * resolve_error($error_id)
    *
    * This function resolves single errors by deciding which resolution function to call
    *
    * @param $error-id is the id of the error that needs to be resolved
    * @return JSON
    */
    public function resolve_error($error_id){
      $error = Error::findOrFail($error_id);    //get error from db
      $result = $this->master_resolve($error);  //call master_resolve to try to resolve
      /*
      //simulation
      $result = 'failed';
      if($error->id % 2 == 0){
        $result = 'success';
      }*/
      $error->tried = 'yes';                    //set that system has tried to resolve
      if($result == 'success'){                 // if error is resolved
        $error->status = 'success';             //set status of error to success
        $error->save();                         // save state of error to db
        echo '{"result": 1}';                   //return result of action in json format [1 = success, 0 = failure]
        return;
      }else{                                    //if error failed to be resolved
        $error->status = 'failed';              //set status of error to failed
        $error->save();                         //save state of error to db
        echo '{"result": 0}';                   //return result of action in json format [1 = success, 0 = failure]
        return;
      }
    }

    /**
    *
    * resolve_oc_in_progress_name($oc_id, $action, $scenario)
    *
    * This function resolves a single in_progress error using the oc_id and oc_name
    *
    * @param $oc_id is the order component id
    * @param $action is the kind of action that needs to be taken to resolve the Error
    * @param $scenario is the kind of scenario that needs to be resolved.
    * @return String
    */
    public function resolve_oc_in_progress_name($oc_id, $action, $scenario){
      $url = 'http://10.255.35.34.7001/to2f-support/TO2FSupportService';
      $request = new HTTPRequest($url, HTTP_METH_POST);
      $request->setRawData($this->retry_failed_orders_xml(Auth::user()->email, $oc_id, $action, $scenario));
      $request->send();
      $response = $request->getResponseBody();
      if($response == 'Success'){
        return 'Success';
      }else{
        return 'failed';
      }
    }

    /**
    *
    * resolve_oc_in_progress_id($oc_id, $action)
    *
    * This function resolves in progress issues with oc_id only and the action required
    * @param $oc_id is the id of an oc
    * @param $action is the action taken to resolve issue
    * @return String
    */
    public function resolve_oc_in_progress_id($oc_id, $action){
      $url = 'http://10.255.35.34.7001/to2f-support/TO2FSupportService';
      $request = new HTTPRequest($url, HTTP_METH_POST);
      $request->setRawData($this->resolve_oc_in_progress_id_xml(Auth::user()->email, $oc_id, $action));
      $request->send();
      $response = $request->getResponseBody();
      if($response == 'Success'){
        return 'Success';
      }else{
        return 'failed';
      }
    }

    /**
    *
    * resolve_failed_orders($oc_id, $action_scenario)
    *
    * @param $oc_id is the id of the OC that needs to be resolve_failed_orders
    * @param $action_scenario is the scenario of the issue to be resolved
    * @return String
    */
    public function resolve_failed_orders($oc_id, $scenario){
      $url = 'http://10.255.35.34:7001/to2f-support/TO2FSupportService';
      $request = new HTTPRequest($url, HTTP_METH_POST);
      $request->setRawData($this->retry_failed_orders_xml(Auth::user()->email, $oc_id, $scenario));
      $request->send();
      $response = $request->getResponseBody();
      if($response == 'Success'){
        return 'Success';
      }else{
        return 'failed';
      }
    }

    /****************** Single Error Actions ****************/


    /****************** Bulk Error Actions *******************/

    /**
    *
    * get_all_new_ocs($rows)
    *
    * get oc_ids that are not already being worked on
    * @param $rows An array of ocs within submitted file that are not already processed
    * @return array
    */
    public function get_all_new_ocs($rows){
        $ocs = array();
        foreach ($rows as $row) {
            if(!Error::where('oc_id', $row->oc_id)->count()){
                array_push($ocs, $row);
            }
        }
        return $ocs;
    }

    /**
    *
    * bulk_resolve($bulk_id)
    *
    * main bulk resolve function
    * @param $bulk_id is the id of the bulk_file being processed
    * @return view
    */
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
                return redirect($this->base_dir)                                //if user has not right to access function
                    ->with('failure', 'You do not have access!');
            }
        }else{
            return redirect($this->base_dir.'login')                                 //if user has not logged in
                ->with('failure', 'You need to first login');
        }
    }

    /**
    *
    * process_bulk_errors($rows)
    *
    * saves bulk errors into db and tries to resolve them
    *
    * @param $rows is list of errors to resolve (from a common bulk errors file)
    * @return JSON
    */
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
            $xml_result = 'failed';
            if(($error_id % 2) == 0)
              $xml_result = 'success';
            $error->tried = 'yes';
            if($xml_result == 'success'){
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

	/**
  *
  * bulkupload(Request)
  *
  * upload bulk file into folder
  *
  * @param $request is a POST request from form
  * @return view
  */
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
      		return redirect($this->base_dir)
      			->withError('Access', 'You do not have access');
      	}
      }else{
        return redirect($this->base_dir.'login')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * single()
    *
    * redirects to single errors page
    *
    * @return view
    */
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
      		return redirect($this->base_dir)
      			->withError('failure', 'You do not have access');
      	}
      }else{
        return redirect($this->base_dir.'login')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * single_errors_history()
    *
    * moves to signle errors history page
    * @return view
    */
    public function single_errors_history(){
      if(Auth::check()){
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'Your account is inactive. Contact Administrator to activate your account.');
            exit();
        }
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
          //bar chart
          $errors = (User::findOrFail(Auth::user()->id));
          $errors_success = count(Error::where('user_id', Auth::user()->id)->where('status', 'success')->whereRaw('Date(created_at) = CURDATE()')->get());
          $errors_failure = count(Error::where('user_id', Auth::user()->id)->where('status', 'failed')->whereRaw('Date(created_at) = CURDATE()')->get());

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
          return redirect($this->base_dir)
            ->withError('failure', 'You do not have access');
        }
      }else{
        return redirect($this->base_dir.'login')
          ->withError('failure', 'You need to login!');
      }
    }

    /**
    *
    * bulk_history()
    *
    * move to bulk history page
    *
    * @return view
    */
    public function bulk_history(){
      if(Auth::check()){
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'Your account is inactive. Contact Administrator to activate your account.');
            exit();
        }
        if(Auth::user()->type == 'admin'){
          return view('pages.admin.history')
            ->with('page_title', 'History - Bulk Errors | Vodafone Zeus')
            ->with('datatables', 'false')
            ->with('flot', 'false');
        }else{
          return redirect($this->base_dir)
            ->with('failure', 'You do not have access!');
        }
      }else{
        return redirect($this->base_dir.'login')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * singleupload(Request)
    *
    * upload single error to db (back office and admin only)
    *
    * @return view
    */
    public function singleupload(Request $request){
      if(Auth::check()){
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'Your account is inactive. Contact Administrator to activate your account.');
            exit();
        }
      	if(Auth::user()->type == 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
      		$this->validate($request, [
      			'oc_id' => 'required|unique:errors',
      			'operation' => 'required',
      			]);

      		$error = new Error();
      		$error->operation = $request->operation;
      		$error->oc_id = $request->oc_id;
          if($request->oc_name){
            $error->scenario = $request->oc_name;
          }else{
            $error->scenario = null;
          }
      		$error->user_id = Auth::user()->id;
      		$error->save();
      		return redirect()
      			->back()
      			->with('error', $error);
      	}else{
      		return redirect($this->base_dir)
      			->withError('Access', 'You do not have access');
      	}
      }else {
        return redirect($this->base_dir.'login')
          ->with('failure', 'You need to login!');
      }
    }

    /**
    *
    * singleuploadf(Request)
    *
    * upload single error to db (front office, admin, back office)
    *
    * @return view
    */
    public function singleuploadf(Request $request){
      if(Auth::check()){
        if(Auth::user()->status == 'inactive'){
          return view('auth.login')
            ->with('failure', 'Your account is inactive. Contact Administrator to activate your account.');
            exit();
        }
        if(Auth::user()->type = 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office'){
            //validate
            $this->validate($request, [
                'oc_id' => 'required',
                'scenario' => 'required'
                ]);
            $error = new Error();
            $error->scenario = $request->scenario;
            $error->operation = $this->getoperation($error->scenario);
            $error->oc_id = $request->oc_id;
            $error->by_scenario = 'yes';
            $error->user_id = Auth::user()->id;
            $error->save();
            return redirect()
                ->back()
                ->with('error', $error);
        }else{
            return redirect($this->base_dir)
                ->withError('Access', 'You do not have access');
        }
      }else{
        return redirect($this->base_dir.'login')
            ->with('Access', 'You need to login!');
      }
    }

    /**
    *
    * getoperation($scenario)
    *
    * Finds the right operation for a scenario
    *
    * @param $scenario is the oc_name or scenario of Error
    * @return String returns an operation for the scenario
    */
    public function getoperation($scenario){
      $operation = null;
      switch ($scenario) {
        case '|':
          $operation = 'Resubmit';
          break;
        case 'Time out':
          $operation = 'Resubmit';
          break;
        default:
          $operation = 'unknown';
          break;
      }
      return $operation;
    }

    /**
    *
    * bulk_details($bulk_id)
    *
    * view details of errors from a common bulk file
    *
    * @return view
    */
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
                return redirect($this->base_dir)
                    ->withError('Access', 'You do not have access');
            }
        }else{
            return redirect($this->base_dir.'login')
                ->withError('failure', 'You need to login');
        }

    }

/************ End  Redirection and other functions   *********/

}
