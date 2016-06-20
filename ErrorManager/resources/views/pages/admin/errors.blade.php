@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @include('common.success')
        @include('common.failure')
            <div class="panel panel-default">
                <div class="panel-heading">Resolve Bulk Errors:  <strong class="text-danger">Two IDS</strong></div>
                <div class="panel-body">   
                    <div class="form-border col-md-12 col-md-offset-1" id="search-form">
                    <form class="form-group" method="POST" action="/errors/resolve/double_id" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-4">
                            <select name="operation" class="form-control search-input">
                                <option> Retry Failed Orders </option>
                                <option> Resolve OC In Progress (by OC ID)</option>
                                <option> Resolve OC In Progress (by OC name) </option>
                                <option> Resolve Different Version</option>
                                <option> All </option>
                            </select>
                        </div>
   
                        <div class="col-md-3">
                            <input type="file" name="error_csv" class="form-control search-input"><!--<i class="fa fa-file-excel-o"></i>-->
                        </div>
                        <button type="button" class="btn btn-primary search-input"><i class="fa fa-send-o fa-1x"></i> &nbsp;&nbsp; Submit &nbsp;&nbsp;
                            </button>
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
                                <th>Error Category</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Success</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Resolve OC In Progress (by OC name)</td>
                                <td>
                                    <center>
                                        <a href="#" class="text-danger"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                    </center>
                                </td>
                                <td>New</td>
                                <td>Unprocessed</td>
                                <td><a href="#" class="btn btn-success"><i class="fa fa-cogs fa-1x"></i> &nbsp;&nbsp; Resolve</a></td>
                            </tr>
                             <tr>
                                <td>Resolve OC In Progress (by OC name)</td>
                                <td>
                                    <center>
                                        <a href="#" class="text-danger"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                    </center>
                                </td>
                                <td>In progress</td>
                                <td> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Retry Failed Orders</td>
                                <td>
                                    <center>
                                        <a href="#" class="text-danger"><i class="fa fa-file-excel-o fa-2x"></i></a>
                                    </center>
                                </td>
                                <td>Processed</td>
                                <td>50 %</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
            <!--
            <div class="panel panel-default">
                <div class="panel-heading">Resolve Bulk Errors:  <strong class="text-danger">One ID</strong></div>
                <div class="panel-body">   
                    <div class="form-border col-md-12 col-md-offset-1" id="search-form">
                    <form class="form-group" method="POST" action="/errors/resolve/double_id" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-2">
                            <select name="operation" class="form-control search-input">
                                <option> Resubmit </option>
                                <option> Force Complete </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="file" name="error_csv" class="form-control search-input">
                        </div>
                        <button type="button" class="btn btn-success search-input"><i class="fa fa-cogs fa-1x"></i> &nbsp;&nbsp; Resolve &nbsp;&nbsp;
                            </button>
                    </form>
                    </div>

                </div>
            </div>
            -->
        </div>
    </div>
</div>
@endsection