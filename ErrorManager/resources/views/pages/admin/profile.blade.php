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
                            <p href="#" class="profile_item text-primary"><i class="fa fa-user fa-1x voda-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->name }}</p>
                        </div>
                        <div class="fa-hover">
                            <p href="#" class="profile_item text-primary"><i class="fa fa-envelope fa-1x voda-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ Auth::user()->email }}</p>
                        </div>
                        <div class="fa-hover">
                            <p class="profile_item text-primary"><i class="fa fa-group fa-1x voda-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                              <?php $cur_user = Auth::user()->type; ?>
                              @if($cur_user == 'admin')
                                Admin
                              @elseif($cur_user == 'front_office')
                                Front Office
                              @elseif($cur_user == 'back_office')
                                Back Office
                              @elseif($cur_user == 'superadmin')
                                Superadmin
                              @endif
                            </p>
                        </div>
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
