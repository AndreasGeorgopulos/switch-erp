@extends('index')
@section('content_header')
	<h1><i class="fa fa-cog"></i> {{trans('Beállítások')}} / {{trans('Témák')}}</h1>
@stop

@section('content')
	@include('layout.table.index')
@endsection