@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<div class="callback-management">
		<div class="row">
			<div class="col-sm-12 table-area">
				@include('callback_management._nav')

				@if(!empty($models))
					{{csrf_field()}}
					<table class="table table-bordered table-striped" id="callback-applicants-table">
						<thead>
						<tr>
							<th class="name">{{trans('Név')}}</th>
							<th class="name text-center">{{trans('Jelölt csoport')}}</th>
							<th class="description text-center">{{trans('Információ a jelöltről')}}</th>
							<th class="text-center">{{trans('Visszahívás dátuma')}}</th>
							<th class="cv text-center">{{trans('Önéletrajz')}}</th>
							<th class="delete text-center">{{trans('Törlés')}}</th>
						</tr>
						</thead>
						<tbody>
						@foreach($models as $model)
							<tr>
								<td>{{$model->name}}</td>
								<td class="text-center">{{$model->groups()->pluck('name')->implode(', ')}}</td>
								<td class="text-center">{{$model->description}}</td>
								<td class="text-center">
									<span class="@if($model->last_callback_date == date('Y-m-d')) alert-call-flicker @endif">{{str_replace('-', '.', $model->last_callback_date)}}</span>
								</td>
								<td class="text-center">
									<a href="{{url(route('applicant_management_edit', ['id' => $model->id]))}}">
										<i class="fa @if($model->hasCv()) fa-edit @else fa-plus @endif"></i>
									</a>
								</td>
								<td class="text-center">
									<form method="post"
									      class="delete-applicant"
									      action="{{url(route('callback_management_delete_applicant', ['id' => $model->id]))}}" >
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
										<button type="submit" class="btn btn-sm btn-danger">
											<i class="fa fa-minus"></i>
										</button>
									</form>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>

					@include('callback_management._footbar')
				@endif
			</div>
		</div>
	</div>
@stop