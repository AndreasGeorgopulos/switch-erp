<div class="box-body">
	<div class="dataTables_wrapper form-inline dt-bootstrap">
		@include('layout.table.header')
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered table-striped dataTable">
					<thead>
					<tr role="row">
						<th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
						<th data-column="name">{{trans('Név')}}</th>
						<th data-column="applicants_count" class="text-center">{{trans('Jelöltek száma')}}</th>
						<th data-column="is_active" class="text-center">{{trans('Aktív')}}</th>
						<th>
							<a href="{{url(route('applicant_groups_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Új jelölt csoport')}}</a>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($list as $model)
						<tr role="row" class="odd">
							<td>{{$model->id}}</td>
							<td>{{$model->name}}</td>
							<td class="text-center">{{$model->applicants->count()}}</td>
							<td class="text-center"><i class="fa {{$model->is_active ? 'fa-check text-green' : 'fa-ban text-red'}}"></i></td>
							<td class="text-right" style="width: 150px;">
								<a href="{{url(route('applicant_groups_view', ['id' => $model->id]))}}" class="btn btn-info btn-sm">
									<i class="fa fa-eye"></i>
								</a>
								<a href="{{url(route('applicant_groups_edit', ['id' => $model->id]))}}" class="btn btn-primary btn-sm">
									<i class="fa fa-edit"></i>
								</a>
								<a href="{{url(route('applicant_groups_delete', ['id' => $model->id]))}}" class="btn btn-danger btn-sm confirm">
									<i class="fa fa-trash"></i>
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@include('layout.table.footer')
	</div>
</div>