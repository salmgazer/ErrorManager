@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @include('common.success')
        @include('common.failure')
            <div class="panel panel-default">
                <div class="panel-heading">Update User</div>
                <div class="panel-body">
                    <div>
                        <!-- user details -->
                       <center>
                       <p><strong>Name:</strong> {{ $user->name }} &nbsp;&nbsp;&nbsp;&nbsp; <strong>Email:</strong> {{ $user->email }}<p>
                        </center>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ '/users/update/'.$user->id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="user_group" class="col-md-4 control-label">User group</label>
                            <div class="col-md-6">
                                <select name="user_group" id="user_group" class="form-control">
                                @if($user->type == 'front_office')
                                    <option>Front office</option>
                                    <option>Back office</option>
                                    <option>Admin</option>
                                    <option>Superadmin</option>
                                @elseif($user->type == 'back_office')
                                    <option>Back office</option>
                                    <option>Front office</option>
                                    <option>Admin</option>
                                    <option>Superadmin</option>
                                @elseif($user->type == 'admin')
                                    <option>Admin </option>
                                    <option>Front office</option>
                                    <option>Back office</option>
                                    <option>Superadmin</option>
                                @elseif($user->type == 'superadmin')
                                    <option>Superadmin</option>
                                    <option>Front office</option>
                                    <option>Back office</option>
                                    <option>Admin</option>
                                @else
                                    <option>Front office</option>
                                    <option>Back office</option>
                                    <option>Admin</option>
                                    <option>Superadmin</option>
                                @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_role" class="col-md-4 control-label">User Role</label>
                            <div class="col-md-6">
                                <input type="text" value="{{ $user->role }}" class="form-control" name="user_role" id="user_role">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection