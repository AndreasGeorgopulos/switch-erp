@extends('index')
@section('content_header')
	<h1>{{trans('Jelölt csoportok')}}</h1>
@stop

@section('content')
	@include('layout.table.index')
@endsection