@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<div class="search-management">
		<div class="row">
			<div class="col-1-5">
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
			<div class="col-8-5 table-area">
				@if(!empty($models))
					{{csrf_field()}}

					<h2>{{trans('Jelöltek')}} @include('search_management._counter') <div class="active-applicants"><label><input type="checkbox" class="ch-active-applicants" /> {{trans('Aktív jelöltek')}}</label></div></h2>

					<table class="table table-bordered table-striped" id="search-table">
						<thead>
						<tr role="row">
							<th class="w-300 text-center">{{trans('Név')}}</th>
							<th class="w-300 text-center">{{trans('Átküldés dátuma')}}</th>
							<th class="w-320 text-center status-col">{{trans('Státusz')}}</th>
							<th class="w-500 text-center">{{trans('Információ')}}</th>
							<th class="w-300 text-center date-col">{{trans('Interjú időpont')}}</th>
							<th class="w-300 text-center date-col">{{trans('Utolsó kapcsolat')}}</th>
							<th class="w-200 text-center text-center">{{trans('Fizetés')}} ({{trans('nettó')}})</th>
							<th class="text-center">{{trans('Önéletrajz')}}</th>
						</tr>
						</thead>

						<tbody>
						@foreach($models as $index => $m)
							<tr data-applicant="{{$m->applicant_id}}" data-job="{{$m->job_position_id}}" class="status-{{$m->status}}">
								<td>
									<span class="w-200" style="display: block;">{{$m->applicant->name}}</span>
								</td>
								<td>
									<input type="date" max="2999-12-31" name="send_date" value="{{$m->send_date}}" class="form-control input-sm input-data w-150" />
								</td>
								<td>
									<select name="status" class="form-control input-sm input-data w-180">
										@foreach(\App\Models\ApplicantCompany::getStatusDropdownItems($m->status) as $item)
											<option value="{{$item['value']}}" class="text-center" @if($item['selected'] === true) selected="selected" @endif>{{$item['title']}}</option>
										@endforeach
									</select>
								</td>
								<td>
									<textarea name="information" class="form-control input-sm input-data w-500">{{$m->information}}</textarea>
								</td>
								<td>
									<input type="datetime-local" name="interview_time" value="{{$m->interview_time}}" class="form-control input-sm input-data" />
								</td>
								<td>
									<input type="date" name="last_contact_date" value="{{$m->applicant->last_contact_date}}" max="2999-12-31" class="form-control input-sm input-data" />
								</td>
								<td class="text-center">
									<span class="w-150" style="display: block;">
									@if(is_numeric($m->applicant->salary)){{number_format($m->applicant->salary, 0, '', '.')}} Ft
									@else<span>Nincs megadva</span>
									@endif
									</span>
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

					<div class="foot-toolbar">
						<button type="button" class="btn btn-default btn-scroll-left">
							<i class="fa fa-arrow-left"></i>
						</button>

						<button type="button" class="btn btn-default btn-scroll-right">
							<i class="fa fa-arrow-right"></i>
						</button>
					</div>
				@endif
			</div>
		</div>
	</div>
@stop