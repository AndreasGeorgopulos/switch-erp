<div class="box-body">
	<div class="dataTables_wrapper form-inline dt-bootstrap">
		@include('layout.table.header')
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered table-striped dataTable">
					<thead>
					<tr role="row">
						<th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
						<th class="@if($sort == 'title') sorting_{{$direction}} @else sorting @endif" data-column="title">{{trans('Megnevezés')}}</th>
						<th class="@if($sort == 'company_name') sorting_{{$direction}} @else sorting @endif" data-column="company_name">{{trans('Cég')}}</th>
						<th>{{trans('Technológiák')}}</th>
						<th>{{trans('Felhasználók')}}</th>
						<th class="@if($sort == 'is_active') sorting_{{$direction}} @else sorting @endif" data-column="is_active" class="text-center">{{trans('Aktív')}}</th>
						<th class="text-center">{{trans('Utolsó módosítás')}}</th>
						<th>
							<a href="{{url(route('job_positions_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Új pozíció')}}</a>
						</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($list as $model)
						<tr role="row" class="odd">
							<td>{{$model->id}}</td>
							<td>{{$model->title}}</td>
							<td>{{$model->company->name}}</td>
							<td>{{$model->skills()->orderBy('name', 'asc')->pluck('name')->implode(', ')}}</td>
							<td>{{$model->users()->orderBy('name', 'asc')->pluck('name')->implode(', ')}}</td>
							<td class="text-center"><i class="fa {{$model->is_active ? 'fa-check text-green' : 'fa-ban text-red'}}"></i></td>
							<td class="text-center">{{date('Y.m.d H:i', strtotime($model->updated_at))}}</td>
							<td class="text-right" style="width: 150px;">
								<a href="{{url(route('job_positions_view', ['id' => $model->id]))}}" class="btn btn-info btn-sm">
									<i class="fa fa-eye"></i>
								</a>
								<a href="{{url(route('job_positions_edit', ['id' => $model->id]))}}" class="btn btn-primary btn-sm">
									<i class="fa fa-edit"></i>
								</a>
								<a href="{{url(route('job_positions_delete', ['id' => $model->id]))}}" class="btn btn-danger btn-sm confirm">
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