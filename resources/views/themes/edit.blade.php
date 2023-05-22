@extends('index')
@section('content_header')
	<h1>{{trans('Téma')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form method="post">
				{{csrf_field()}}
				@include('layout.messages')
				<div class="box">
					<div class="box-body">
						<div class="row">
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
						</div>

						@foreach(config('theme.groups') as $group)
							<h3>{{$group['title']}}</h3>
							<table class="table table-striped">
								<thead>
								<tr>
									<th style="width: 250px;">{{trans('Megnevezés')}}</th>
									<th class="text-center">{{trans('CSS selector')}}</th>
									<th class="text-center" style="width: 100px;">{{trans('Érték')}}</th>
								</tr>
								</thead>

								<tbody>
								@foreach($group['items'] as $item)
									<tr>
										<td>{{$item['title']}}</td>
										<td>{{$item['css_selector']}}</td>
										<td class="text-center">
											<input type="{{$item['input_type']}}"
											       name="css_data[{{$item['css_selector']}}][{{$item['property']}}]"
											       value="{{ $css_data[$item['css_selector']][$item['property']] ?? ($item['default_value'] ?? '')  }}"
											/>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						@endforeach

						<div class="clearfix"></div>
					</div>

					<div class="box-footer">
						<a href="{{url(route('themes_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
						<button type="submit" class="btn btn-success pull-right">{{trans('Mentés')}}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection