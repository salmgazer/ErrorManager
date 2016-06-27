@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @include('common.success')
        @include('common.failure')
            <div class="panel panel-default">
                <div class="panel-heading">Your Profile</div>
                <div class="panel-body">

                    <div class="col-md-8 col-md-offset-2 danger">

                        <div class="fa-hover">
                            <a href="#" class="profile_item"><i class="fa fa-user fa-1x voda-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->name }}</a>
                        </div><br>
                        <div class="fa-hover">
                            <a href="#" class="profile_item"><i class="fa fa-envelope fa-1x voda-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->email }}</a>
                        </div><br>
                        <div class="fa-hover">
                            <a href="#" class="profile_item"><i class="fa fa-group fa-1x voda-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                              @if(Auth::user()->type == 'admin')
                                Admin
                              @elseif(Auth::user()->type == 'front_office')
                                Front Office
                              @elseif(Auth::user()->type == 'back_office')
                                Back Office
                              @endif
                            </a>
                        </div><br>
                        <hr>

                        <form class="form-horizontal" role="form" method="POST" action="/profile/updatepass">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="password_current" type="password" class="form-control" name="password_current">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-user"></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
