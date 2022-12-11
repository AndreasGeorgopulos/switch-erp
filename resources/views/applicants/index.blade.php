@extends('index')
@section('content_header')
	<h1>{{trans('Jelöltek')}}</h1>
@stop

@section('content')
	@include('layout.table.index')
@endsection