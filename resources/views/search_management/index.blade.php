@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<div class="row">
		<div class="col-sm-2">
			<h2>{{trans('Cégek')}}</h2>
			<ul class="nav" id="applicant-skill-sidebar">
				@foreach($companies as $company)
					<li class="nav-item @if($selectedCompany !== null && $company->id == $selectedCompany->id) active @endif">
						<a href="{{url(route('search_management_index', ['company' => $company->id]))}}" class="nav-link">
							{{$company->name}}
						</a>
					</li>
				@endforeach
			</ul>
		</div>
		<div class="col-sm-2">
			@if(!empty($job_positions))
				<h2>{{trans('Pozíciók')}}</h2>
				<ul class="nav" id="applicant-skill-sidebar">
					@foreach($job_positions as $jp)
						<li class="nav-item @if($selectedJobPosition !== null && $jp->id == $selectedJobPosition->id) active @endif">
							<a href="{{url(route('search_management_index', ['company' => $selectedCompany->id, 'job' => $jp->id]))}}" class="nav-link">
								{{$jp->title}}
							</a>
						</li>
					@endforeach
				</ul>
			@endif
		</div>
		<div class="col-sm-8">
			@if(!empty($models))
				{{csrf_field()}}
				<h2>{{trans('Jelöltek')}}</h2>
				<table class="table table-bordered table-striped" id="search-table">
					<thead>
					<tr role="row">
						<th>{{trans('Név')}}</th>
						<th class="date-col">{{trans('Átküldés dátuma')}}</th>
						<th class="status-col">{{trans('Státusz')}}</th>
						<th></th>
					</tr>
					</thead>

					<tbody>
					@foreach($models as $index => $m)
						<tr data-applicant="{{$m->applicant_id}}" data-job="{{$m->job_position_id}}">
							<td>{{$m->applicant->name}}</td>
							<td>
								<input type="date" name="send_date" value="{{$m->send_date}}" class="form-control input-sm input-data" />
							</td>
							<td>
								<select name="status" class="form-control input-sm input-data">
									@foreach(\App\Models\ApplicantCompany::getStatusDropdownItems($m->status) as $item)
										<option value="{{$item['value']}}" @if($item['selected'] === true) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</td>
							<td></td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@stop