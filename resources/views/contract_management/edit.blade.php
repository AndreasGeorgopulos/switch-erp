@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<form method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="row">
							<div class="col-md-7">
								<div class="form-group">
									<label>{{trans('Név')}}*</label>
									<input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{trans('Aktív')}}*</label>
									<select name="is_active" class="form-control select2">
										<option value="1" @if(old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Igen')}}</option>
										<option value="0" @if(!old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Nem')}}</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>{{trans('Szerződés')}} (PDF)</label>
							<input type="file" class="form-control" name="contract_file" accept="application/pdf" />
						</div>
						@if($model->hasContract())
							<div class="form-group">
								<label>{{trans('Feltöltve')}}</label>
								<p>
									<a href="{{route('companies_download_contract', ['id' => $model->id])}}" target="_blank">{{$model->contract_file}}</a>
								</p>
								<p>
									<input type="checkbox" name="delete_contract_file" /> {{trans('Feltöltött file törlése')}}
								</p>
							</div>
							<iframe src="{{route('companies_download_contract', ['id' => $model->id])}}" class="pdf_viewer" width="100%" height="800"></iframe>
						@endif
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('contract_management_index'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection