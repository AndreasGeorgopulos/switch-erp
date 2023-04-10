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
							<th class="">{{trans('Név')}}</th>
							<th class="">{{trans('Cég')}}</th>
							<th class="">{{trans('Pozíció')}}</th>
							<th class="">{{trans('Fizetés')}}</th>
							<th class="">{{trans('Kezdés dátuma')}}</th>
							<th class="">{{trans('Utánkövetés')}}</th>
							<th class="">{{trans('Elhelyezte')}}</th>
							<th class="text-center">{{trans('Önéletrajz')}}</th>
						</tr>
						</thead>

						<tbody>
						@foreach($models as $index => $m)
							<tr data-applicant="{{$m->applicant_id}}" data-job="{{$m->job_position_id}}" class="status-{{$m->status}}">
								<td>
									<span class="w-150 display-block">{{$m->applicant->name}}</span>
								</td>
								<td>
									<span class="w-150 display-block">{{$m->job_position->company->name}}</span>
								</td>
								<td>
									<span class="w-150 display-block">{{$m->job_position->title}}</span>
								</td>
								<td class="text-center">
									<input type="text" name="salary" class="form-control input-sm input-data salary only-numbers w-100" value="{{$m->salary}}" tabindex="10" />
								</td>
								<td>
									<input type="date" max="2999-12-31" name="work_begin_date" value="{{$m->work_begin_date}}" class="form-control input-sm input-data w-110" />
								</td>
								<td>
									<textarea name="follow_up" class="form-control input-data min-w-250">{{$m->follow_up}}</textarea>
								</td>
								<td>
									<input type="text" maxlength="4" name="monogram" value="{{$m->monogram}}" class="form-control input-sm input-data w-100" />
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