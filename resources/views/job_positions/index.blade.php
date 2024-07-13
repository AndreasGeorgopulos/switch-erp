@extends('index')
@section('content_header')
	<h1><i class="fa fa-cog"></i> {{trans('Beállítások')}} / {{trans('Pozíciók')}}</h1>
@stop

@section('content')
	@php
		$data_init_sort = 'is_active';
		$data_init_direction = 'desc';
	@endphp
	@include('layout.table.index')
@endsection