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
					<table class="table table-bordered table-striped" id="callback-table">
						<thead>
						<tr>
							<th class="name">{{trans('Név')}}</th>
							<th class="text-center">{{trans('Visszahívás dátuma')}}</th>
							<th class="text-center">{{trans('Intézte')}}</th>
							<th class="text-center">{{trans('Törlés')}}</th>
						</tr>
						</thead>
						<tbody>
						@foreach($models as $model)
							<tr>
								<td>{{$model->company_name}}</td>
								<td class="text-center">
									<span class="@if($model->callback_date == date('Y-m-d')) alert-call-flicker @endif">{{str_replace('-', '.', $model->callback_date)}}</span>
								</td>
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
				@endif
			</div>
		</div>
	</div>
@stop