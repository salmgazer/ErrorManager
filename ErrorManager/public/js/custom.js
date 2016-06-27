var base_url = 'http://localhost:8000/';
var system_available = true;

//send request function
function sendRequest(u){
	//sed request to server
	//u is a url as a string
	//async is type of request
	var obj=$.ajax({url:u,async:false});
	//convert the JSON to onject
	var result = $.parseJSON(obj.responseText);
	return result;
}

//resolve single error
function resolve_error($error_id){
	var objResult = sendRequest(base_url+'resolve_error/'+$error_id);
	var feedback = document.getElementById('single_action'+$error_id);
	var status = document.getElementById('single_success'+$error_id);
	if(objResult.result == 1){
		status.innerHTML = 'success';
		feedback.innerHTML = '<i class="fa fa-check fa-2x text-success"></i>';
	}else if (objResult.result == 0) {
		status.innerHTML = 'failed';
		feedback.innerHTML = '<i class="fa fa-times fa-2x voda-text"></i>'
	}
}

//solve bulk errors
function bulk_resolve(bulk_id){
	if(!system_available){
		return alert('System is already busy');
	}
	var tbody = document.getElementById('bulk_errors_tb');
	tbody.innerHTML = "";
	var result_area = document.getElementById('bulk_result_area');
	system_available = false;
	var gear = document.createElement('div');
	gear.innerHTML = '<center class="voda-text" id="rolling_gear"><i class="fa fa-cog fa-spin fa-5x"></i><span class="sr-only">Processing...</span></center>';
	tbody.appendChild(gear);
	document.getElementById('processing_bulk_id').innerHTML = bulk_id;

	//send ajax request
	var objResult = sendRequest(base_url+'bulk_resolve/'+bulk_id);
	if (objResult.result === 0) {
		alert(objResult.message);
		gear.remove();
		return;
	}
	//iterate through list of orders from excel sheet
	else if(objResult.result == 1){
		document.getElementById('bulk_action'+bulk_id).innerHTML = '<a href="#" onclick="(bulk_details('+bulk_id+'))" class="voda-text"><i class="fa fa-thumps-o-up fa-1x text-success"></i>Details</a>';
		document.getElementById('bulk_status'+bulk_id).innerHTML = 'processed';
		var errors = objResult.errors;
		document.getElementById('bulk_success'+bulk_id).innerHTML = objResult.success_rate;
		tbody.innerHTML = "";
		for (var i = 0; i < errors.length; i++) {
			var anode = document.createElement('tr');
			var nodecontent = '<td>'+errors[i].oc_id+'</td><td>'+errors[i].scenario+'</td><td>'+errors[i].operation+'</td>';
            if(errors[i].status == 'success'){
        	nodecontent += '<td><i class="fa fa-check fa-2x text-success"></i></td>';
	        }else if(errors[i].status == 'failed'){
	        	nodecontent += '<td><i class="fa fa-times fa-2x voda-text"></i></td>';
	        }
            anode.innerHTML = nodecontent;
            tbody.appendChild(anode);
		}
	}
	system_available = true;
}

//report bulk errors
function bulk_report(bulk_id){
}

//view bulk details
function bulk_details(bulk_id){
	if(!system_available){
		return alert('System is already busy');
	}
	document.getElementById('processing_bulk_id').innerHTML = bulk_id;
	var errors_area = document.getElementById('bulk_errors_tb');
	errors_area.innerHTML = '<center class="voda-text" id="rolling_gear"><i class="fa fa-spin fa-pulse fa-fw fa-5x"></i><span class="sr-only">Processing...</span></center>';
	var objResult = sendRequest(base_url+'bulk_details/'+bulk_id);
	var errors = objResult.errors;
	errors_area.innerHTML = "";

	for (var i = 0; i < errors.length; i++) {
		var anode = document.createElement('tr');
		var nodecontent = '<td>'+errors[i].oc_id+'</td><td>'+errors[i].scenario+'</td><td>'+errors[i].operation+'</td>';
        if(errors[i].status == 'success'){
        	nodecontent += '<td><i class="fa fa-check fa-2x text-success"></i></td>';
        }else if(errors[i].status == 'failed'){
        	nodecontent += '<td><i class="fa fa-times fa-2x voda-text"></i></td>';
        }
        anode.innerHTML = nodecontent;
        errors_area.appendChild(anode);
	}
}
