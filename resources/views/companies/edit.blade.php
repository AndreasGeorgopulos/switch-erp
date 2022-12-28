@extends('index')
@section('content_header')
	<h1>{{trans('Cég')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
	<form method="post" class="" enctype="multipart/form-data">
		{{csrf_field()}}
		@include('layout.messages')
		<div class="box">
			<div class="box-body">
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label>{{trans('Név')}}*</label>
								<input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
							</div>
						</div>
						<div class="col-sm-4">
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
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>{{trans('Szerződés')}} (PDF)</label>
								<input type="file" class="form-control" name="contract_file" accept="application/pdf" />
							</div>
						</div>

						@if($model->hasContract())
							<div class="col-sm-12">
								<div class="form-group">
									<label>{{trans('Feltöltve')}}</label>
									<p>
										<a href="{{route('companies_download_contract', ['id' => $model->id])}}" target="_blank">{{$model->contract_file}}</a>
									</p>
									<p>
										<input type="checkbox" name="delete_contract_file" /> {{trans('Törlés')}}
									</p>
								</div>
							</div>

							<div class="col-md-12">
								<iframe src="{{route('companies_download_contract', ['id' => $model->id])}}" class="pdf_viewer" width="100%" height="600"></iframe>
							</div>
						@endif
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('companies_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection