@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@endsection

@section('content')
	<form method="post" action="{{route('contract_management_save_rows')}}">
		{{csrf_field()}}
		<table class="table table-bordered table-striped dataTable" id="contract-table">
			<thead>
			<tr role="row">
				<th>{{trans('Név')}}</th>
				<th>{{trans('Aktív')}}</th>
				<th class="text-center">{{trans('Szerződés')}}</th>
				<th class="text-center">{{trans('Cég törlése')}}</th>
			</tr>
			</thead>

			<tbody>
			@foreach($companies as $model)
				<tr>
					<td>{{$model->name}}</td>
					<td class="text-center">
						<i class="fa @if($model->is_active) fa-check text-green @else fa-lock text-red @endif"></i>
					</td>
					<td class="text-center">
						<a href="{{url(route('contract_management_edit', ['id' => $model->id]))}}">
							<i class="fa @if($model->hasContract()) fa-edit @else fa-plus @endif"></i>
						</a>
					</td>
					<td class="text-center">
						<button type="button"
						        @if(!$model->isDeletable()) disabled="disabled" @endif
						        class="btn btn-danger btn-delete"
						        data-href="{{url(route('contract_management_delete', ['id' => $model->id]))}}"
						        data-message="Biztos, hogy törölni akarja ezt a céget? {{$model->name}}"
						>
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>

			<tfoot>
			<tr>
				<td colspan="1">
					<button type="button" class="btn btn-default btn-sm btn-new">
						<i class="fa fa-plus"></i> {{trans('Új cég hozzáadása')}}
					</button>
				</td>
				<td colspan="3" class="text-right hidden save-buttonbar">
					<button type="submit" class="btn btn-success btn-sm btn-save">
						<i class="fa fa-save"></i> {{trans('Mentés')}}
					</button>
					<button type="button" class="btn btn-default btn-sm btn-cancel">
						<i class="fa fa-close"></i> {{trans('Mégsem')}}
					</button>
				</td>
			</tr>
			</tfoot>
		</table>
	</form>
@endsection