@extends('index')
@section('content_header')
	<h1>{{trans('Készség')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
	<form method="post" class="col-md-6 col-md-offset-3">
		{{csrf_field()}}
		@include('layout.messages')
		<div class="box">
			<div class="tab-pane active" id="general_data">
				<div class="col-md-8">
					<div class="form-group">
						<label>{{trans('Név')}}*</label>
						<input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>{{trans('Aktív')}}*</label>
						<select name="is_active" class="form-control">
							<option value="1" @if(old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Igen')}}</option>
							<option value="0" @if(!old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Nem')}}</option>
						</select>
					</div>
				</div>

				<div class="clearfix"></div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('skills_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection