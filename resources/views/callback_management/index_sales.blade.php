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
					<table class="table table-bordered table-striped" id="callback-sales-table">
						<thead>
						<tr>
							<th class="name">{{trans('Név')}}</th>
							<th class="status text-center">{{trans('Státusz')}}</th>
							<th class="last-callback-date text-center">{{trans('Visszahívás dátuma')}}</th>
							<th class="contact text-center">{{trans('Kapcsolat')}}</th>
							<th class="job text-center">{{trans('Pozíció')}}</th>
							<th class="phone text-center">{{trans('Telefonszám')}}</th>
							<th class="email text-center">{{trans('E-mail')}}</th>
							<th class="information text-center">{{trans('Információ')}}</th>
							<th class="last-contact text-center">{{trans('Utolsó kapcsolat')}}</th>
							<th class="web text-center">{{trans('Weboldal')}}</th>
							<th class="monogram text-center">{{trans('Intézte')}}</th>
							<th class="delete text-center">{{trans('Törlés')}}</th>
						</tr>
						</thead>
						<tbody>
						@foreach($models as $model)
							<tr>
								<td>{{$model->company_name}}</td>
								<td>{{$model->status}}</td>
								<td class="text-center">
									<span class="@if($model->callback_date == date('Y-m-d')) alert-call-flicker @endif">{{str_replace('-', '.', $model->callback_date)}}</span>
								</td>
								<td class="text-center">{{$model->contact}}</td>
								<td class="text-center">{{$model->position}}</td>
								<td class="text-center">{{$model->phone}}</td>
								<td class="text-center">{{$model->email}}</td>
								<td class="text-center">{{$model->information}}</td>
								<td class="text-center">
									<span>{{str_replace('-', '.', $model->last_contact)}}</span>
								</td>
								<td class="text-center">{{$model->web}}</td>
								<td class="text-center">{{$model->monogram}}</td>
								<td class="text-center">
									<form method="post"
									      class="delete-sale"
									      action="{{url(route('callback_management_delete_sales', ['id' => $model->id]))}}" >
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