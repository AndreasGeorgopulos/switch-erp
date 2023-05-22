@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<div class="work-management">
		<div class="row">
			<div class="col-sm-12 table-area">
				@if(!empty($models))
					{{csrf_field()}}
					<table class="table table-bordered table-striped" id="work-table">
						<thead>
						<tr role="row">
							<th class="name">{{trans('Név')}}</th>
							<th class="name text-center">{{trans('Cég')}}</th>
							<th class="job text-center">{{trans('Pozíció')}}</th>
							<th class="last-contact text-center">{{trans('Fizetés')}} ({{trans('bruttó')}})</th>
							<th class="last-contact text-center">{{trans('Kezdés dátuma')}}</th>
							<th class="last-contact text-center">{{trans('Utánkövetés')}}</th>
							<th class="monogram text-center">{{trans('Elhelyezte')}}</th>
							<th class="cv text-center">{{trans('Önéletrajz')}}</th>
						</tr>
						</thead>

						<tbody>
						@foreach($models as $index => $m)
							<tr data-applicant="{{$m->applicant_id}}" data-job="{{$m->job_position_id}}" >
								<td>
									<span class="w-150 display-block">{{$m->applicant->name}}</span>
								</td>
								<td class="text-center">
									<span class="w-150 display-block center-block">{{$m->job_position->company->name}}</span>
								</td>
								<td class="text-center">
									<span class="w-150 display-block center-block">{{$m->job_position->title}}</span>
								</td>
								<td class="text-center">
									<input type="text" name="salary" class="form-control input-sm input-data salary only-numbers center-block w-100" value="{{$m->salary}}" tabindex="10" />
								</td>
								<td class="text-center">
									<input type="date" max="2999-12-31" name="work_begin_date" value="{{$m->work_begin_date}}" class="form-control text-center center-block input-sm input-data w-110" />
								</td>
								<td class="text-center">
									<textarea name="follow_up" class="form-control text-center input-data min-w-250">{{$m->follow_up}}</textarea>
								</td>
								<td class="text-center">
									<input type="text" maxlength="4" name="monogram" value="{{$m->monogram}}" class="form-control text-center center-block input-sm input-data w-100" />
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