@extends('index')
@section('content_header')
	<h1>{{trans('Cégek')}}</h1>
@stop

@section('content')
	@include('layout.table.index')
@endsection