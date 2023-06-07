@extends('index')
@section('content_header')
	<h1><i class="fa fa-calendar"></i> {{trans('Naptár')}}</h1>
@stop

@section('content')
	@include('calendar._vacation_modal')
	<div id="calendar" data-load-url="{{url(route('ajax_get_calendar_events'))}}"></div>
@endsection