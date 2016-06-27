@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @include('common.success')
        @include('common.failure')
            <div class="panel panel-default">
                <div class="panel-heading"><strong class="text-primary">Resolve Bulk <b class="voda-text">In Progress</b> Errors</strong></div>
                <div class="panel-body">   
                    <div class="form-border col-md-12" id="search-form">
                    <form class="form-group" method="POST" action="/errors/bulkupload/" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-3">
                            <input type="file" name="errors_file" class="form-control search-input" class="required" required="required">
                        </div>
                        <div>
                            <input type="text" value="In progress" name="operation" hidden>
                        </div>
                        <div  class="col-md-2">
                            <select class="form-control" name="action" id="action">
                                <option>RETRY</option>
                                <option>FC</option>
                                <option>FAILED</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                        <button type="submit" class="btn btn-primary search-input"><i class="fa fa-upload fa-1x"></i> &nbsp;&nbsp; Upload &nbsp;&nbsp;
                            </button>
                            </div>
                            <div class="col-md-1">
                                File Format:
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>oc_id</th>
                                            <th>oc_name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>25452</td>
                                            <td>Billing.CBS.ActvateSubscriber</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </form>
                    </div>

                </div>
            </div>

            <!-- /.panel-heading -->
        
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Operation</th>
                                <th>Action</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Success Rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bulkfiles as $bf)
                                <tr>
                                <td>{{ $bf->id }}</td>
                                <td>{{ $bf->operation }}</td>
                                <td>{{ $bf->action }}</td>
                                <td>
                                    <center>
                                        <a href="/files/error_files/new/{{ $bf->filename }}" target="_blank" class="text-danger"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                    </center>
                                </td>
                                <td id="bulk_status{{ $bf->id }}">{{ $bf->status }}</td>
                                <td id="bulk_success{{ $bf->id }}">{{ $bf->success_rate }}</td>
                                <td id="bulk_action{{ $bf->id }}">
                                @if($bf->status == 'new')
                                    <a href="#" id="bulk_resolve_btn{{ $bf->id }}" class="btn btn-success" onclick="bulk_resolve({{ $bf->id }})"><i class="fa fa-cogs fa-1x"></i> &nbsp;&nbsp; Resolve</a>
                                @elseif($bf->status == 'processed')
                                    <a href="#" onclick="(bulk_details({{ $bf->id }}))" class="voda-text"><i class="fa fa-thumps-o-up fa-1x text-success"></i>Details</a>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
  
            <!-- Processing area -->
            <div class="panel panel-warning" style="margin-top: 50px;">
                <div class="panel-heading">Details ~ Bulk file ID: <strong class="text-danger" id="processing_bulk_id" style="font-size: 25px;"></strong></div>
                <div class="panel-body" id="bulk_result_area">   
                    
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>OC_ID</th>
                                    <th>Scenario
                                    <th>Operation</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="bulk_errors_tb">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection