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
						<th class="">{{trans('Információ')}}</th>
						<th class="date-col">{{trans('Interjú időpont')}}</th>
						<th class="date-col">{{trans('Utolsó kapcsolat')}}</th>
						<th class="text-center">{{trans('Bérigény')}}</th>
						<th class="text-center">{{trans('Önéletrajz')}}</th>
					</tr>
					</thead>

					<tbody>
					@foreach($models as $index => $m)
						<tr data-applicant="{{$m->applicant_id}}" data-job="{{$m->job_position_id}}">
							<td>{{$m->applicant->name}}</td>
							<td>
								<input type="date" max="2999-12-31" name="send_date" value="{{$m->send_date}}" class="form-control input-sm input-data" />
							</td>
							<td>
								<select name="status" class="form-control input-sm input-data">
									@foreach(\App\Models\ApplicantCompany::getStatusDropdownItems($m->status) as $item)
										<option value="{{$item['value']}}" @if($item['selected'] === true) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<textarea name="information" class="form-control input-sm input-data">{{$m->information}}</textarea>
							</td>
							<td>
								<input type="datetime-local" name="interview_time" value="{{$m->interview_time}}" class="form-control input-sm input-data" />
							</td>
							<td>
								<input type="date" name="last_contact_date" value="{{$m->applicant->last_contact_date}}" max="2999-12-31" class="form-control input-sm input-data" />
							</td>
							<td class="text-center">
								@if(is_numeric($m->applicant->salary)){{number_format($m->applicant->salary, 0, '', '.')}} Ft
								@else<span>Nincs megadva</span>
								@endif
							</td>
							<td class="text-center">
								<a href="{{url(route('applicant_management_edit', ['id' => $m->applicant->id]))}}">
									<i class="fa @if($m->applicant->hasCv()) fa-edit @else fa-plus @endif"></i>
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@stop