@extends('.layouts.app')
@section('content')
	@include('common.success')
    @include('common.failure')
{{ Auth::user()->type }}<br>
{{ Auth::user()->email }}
@stop