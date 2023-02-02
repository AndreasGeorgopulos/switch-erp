@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered table-striped dataTable" id="search-table">
				<thead>
				<tr role="row">
					<th>{{trans('Cégnév')}}</th>
					<th>{{trans('Pozíció')}}</th>
					<th>{{trans('Jelölt')}}</th>
					<th>{{trans('Átküldve')}}</th>
				</tr>
				</thead>

				<tbody>
				@foreach($models as $m)
					<tr>
						<td>{{$m->job_position->company->name}}</td>
						<td>{{$m->job_position->title}}</td>
						<td>{{$m->applicant->name}}</td>
						<td>{{$m->send_date}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop