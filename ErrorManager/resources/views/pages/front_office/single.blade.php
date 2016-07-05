@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @include('common.success')
        @include('common.failure')
        @include('common.validation')
            <div class="panel panel-default">
                <div class="panel-heading">Resolve Single Errors</div>
                <div class="panel-body">
                    <div class="form-border col-md-12" id="search-form">
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'back_office')
                    <b style="margin-bottom: 10px;">Resolve by operation:</b>
                    <form class="form-group" method="POST" action="/errors/singleupload" enctype="multipart/form-data" style="margin-bottom: 40px;">
                        {!! csrf_field() !!}
                        <div class="col-md-3">
                            <input type="text" name="oc_id" class="form-control search-input" placeholder="OC ID"><!--<i class="fa fa-file-excel-o"></i>-->
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="oc_name" class="form-control search-input" placeholder="OC Name"><!--<i class="fa fa-file-excel-o"></i>-->
                        </div>
                        <div class="col-md-3">
                            <select name="operation" class="form-control search-input">
                                <option> Resubmit </option>
                                <option> Force Complete</option>
                                <option> Cancel</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary search-input"><i class="fa fa-send-o fa-1x"></i> &nbsp;&nbsp; Submit &nbsp;&nbsp;
                            </button>
                    </form>
                    @endif
                    @if(Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office' || Auth::user()->type == 'admin')
                    <b style="margin-bottom: 10px;">Resolve by scenario:</b>
                    <form class="form-group" method="POST" action="/errors/singleuploadf" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-3">
                            <input type="text" name="oc_id" class="form-control search-input" placeholder="OC ID"><!--<i class="fa fa-file-excel-o"></i>-->
                        </div>
                        <div class="col-md-4">
                            <select name="scenario" class="form-control search-input">
                                <option> | </option>
                                <option> Time out</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary search-input"><i class="fa fa-send-o fa-1x"></i> &nbsp;&nbsp; Submit &nbsp;&nbsp;
                            </button>
                    </form>
                    @endif

                    </div>

                </div>
            </div>

            <!-- Show error here -->
              <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'front_office' || Auth::user()->type == 'back_office')
                        <thead>
                            <tr>
                              <th>Order ID</th>
                              <th>Scenario</th>
                              <th>Operation</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($oc_errors)
                                @foreach($oc_errors as $error)
                                <tr>
                                  <td>{{ $error->oc_id }}</td>
                                  <td>
                                    @if($error->scenario == null)
                                     Null
                                    @else
                                    {{ $error->scenario }}
                                    @endif
                                  </td>
                                  <td>{{ $error->operation }}</td>
                                  <td id="single_success{{ $error->id }}">{{ $error->status }}</td>
                                  <td id="single_action{{ $error->id }}">
                                  @if($error->tried == 'no')
                                   <button type="button" onclick="resolve_error( {{$error->id }})" class="btn btn-success"><i class="fa fa-cogs fa-1x"></i> &nbsp;&nbsp; Resolve</button>
                                  @elseif($error->status == 'success')
                                    <i class="fa fa-check fa-2x text-success"></i>
                                  @elseif($error->status == 'failed')
                                    <i class="fa fa-times fa-2x voda-text"></i>
                                  @endif
                                  </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                        @endif
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- show error here -->

        </div>
    </div>
</div>
@endsection
