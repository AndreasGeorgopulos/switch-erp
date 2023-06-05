@php
$vacationModels = $model->vacations()->whereYear('begin_date', date('Y'))->get();
@endphp

<hr />
<div class="form-group" id="vacation-area"
     data-load-url="{{url(route('ajax_load_profile_vacations'))}}"
     data-save-url="{{url(route('ajax_save_profile_vacation'))}}"
     data-delete-url="{{url(route('ajax_delete_profile_vacation'))}}"
     data-user-id="{{$model->id}}"
     data-days-per-year="{{$model->vacation_days_per_year}}"
     data-free-days="{{$model->free_vacation_days}}"
     data-used-days="{{$model->used_vacation_days}}">

	<label>{{trans('Szabadságok')}}</label>

	@if($model->free_vacation_days)
		<button type="button" class="btn btn-default btn-sm btn-new pull-right">
			<i class="fa fa-plus"></i> {{trans('Új szabadságigény')}}
		</button>
	@endif

	<div class="form-area hidden">
		@include('users.vacations._form')
	</div>

	<div class="table-area"></div>
</div>