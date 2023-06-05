@php
	$vacationModels = $userModel->vacations()->whereYear('begin_date', date('Y'))->orderBy('begin_date', 'asc')->get();
@endphp

@if(count($vacationModels))
	<table class="table table-striped vacation-table">
		<thead>
		<tr>
			<th>{{trans('Állapot')}}</th>
			<th class="text-center">{{trans('Kezdete')}}</th>
			<th class="text-center">{{trans('Vége')}}</th>
			<th class="text-center">{{trans('Felhasznált napok')}}</th>
			<th class="text-center">{{trans('Megjegyzés')}}</th>
			<th class="text-right">{{trans('Műveletek')}}</th>
		</tr>
		</thead>

		<tbody>
		@foreach($vacationModels as $vacationModel)
			<tr class="vacation-status-{{$vacationModel->status}}">
				<td>{{$vacationModel->status_title}}</td>
				<td class="text-center">{{$vacationModel->begin_date}}</td>
				<td class="text-center">{{$vacationModel->end_date}}</td>
				<td class="text-center">{{$vacationModel->status !=\App\Models\Vacation::STATUS_REJECTED ? $vacationModel->diff_days : ''}}</td>
				<td class="text-center">{{$vacationModel->notice}}</td>
				<td class="text-right">
					@if($vacationModel->isEditable())
						<button type="button" class="btn btn-default btn-sm btn-edit margin-r-5" data-id="{{$vacationModel->id}}">
							<i class="fa fa-edit"></i>
						</button>
					@endif
					@if($vacationModel->isDeletable())
						<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{$vacationModel->id}}">
							<i class="fa fa-minus"></i>
						</button>
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
		<thead>
		<tr>
			<td colspan="3" class="text-right text-bold">{{trans('Felhasznált napok a ' . date('Y') . '. évben')}}: </td>
			<td class="text-center text-bold">{{$userModel->used_vacation_days}} / {{$userModel->vacation_days_per_year}}</td>
			<td colspan="2"></td>
		</tr>
		</thead>
	</table>
@else
	<div class="text-center">{{trans('Nincs megjeleníthető elem.')}}</div>
@endif