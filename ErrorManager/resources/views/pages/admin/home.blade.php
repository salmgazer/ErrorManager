@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
    <!-- Search Form comes here -->
        <div class="form-border col-md-10 col-md-offset-1" id="search-form">
            <form class="form-group well well-sm input_mask" method="POST" action="/users">
                {!! csrf_field() !!}
                <div class="col-md-4">
                    <input type="text" name="key" class="form-control search-input">
                </div>
                <div class="col-md-4">
                    <select name="key_type" class="form-control search-input">
                        <option>Name</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search fa-2x"></i></button>
            </form>
        </div>

        <div class="col-md-12">
        @include('common.success')
        @include('common.failure')

        @if($users != null)
            <div class="panel panel-warning">
                <div class="panel-heading">Manage Users</div>
                <div class="panel-body">

                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="users-Table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Group</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr class="odd gradeX">
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->type }}</td>
                                            <td>{{ $user->status }}</td>
                                            <td><a href="/users/edit/{{ $user->id }}" class="btn btn-primary">Edit</a>
                                            @if($user->status == 'active')
                                                <a href="/users/deactivate/{{ $user->id }}" class="btn btn-danger button-gap">Deactivate</a>
                                            @elseif($user->status == 'inactive')
                                                <a href="/users/activate/{{ $user->id }}" class="btn btn-success button-gap">Activate</a>
                                            @endif
                                            </td>
                                        </tr>
                              		@endforeach
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
