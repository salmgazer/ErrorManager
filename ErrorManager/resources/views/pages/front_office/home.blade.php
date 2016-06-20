@extends('.layouts.app')
@section('content')
{{ Auth::user()->type }}<br>
{{ Auth::user()->email }}
@stop