@extends('index')
@section('content_header')
	<h1>{{trans('Jelölt')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
	<form method="post" class="">
		{{csrf_field()}}
		@include('layout.messages')
		<div class="box">
			<div class="tab-pane active" id="general_data">
				<div class="row">
					<div class="col-md-9">
						<div class="col-md-6">
							<div class="form-group">
								<label>{{trans('Név')}}*</label>
								<input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>{{trans('E-mail cím')}}*</label>
								<input type="text" name="email" class="form-control" value="{{old('email', $model->email)}}" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>{{trans('Telefon')}}*</label>
								<input type="text" name="phone" class="form-control" value="{{old('phone', $model->phone)}}" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>{{trans('Linked In')}}</label>
								<input type="text" name="linked_in" class="form-control" value="{{old('linked_in', $model->linked_in)}}" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Tapasztalat')}} ({{trans('Év')}})</label>
								<input type="number" name="experience_year" class="form-control" value="{{old('experience_year', $model->experience_year)}}" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Utolsó kapcsolat')}}</label>
								<input type="text" name="last_contact_date" class="form-control" value="{{old('last_contact_date', $model->last_contact_date)}}" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Visszahívás')}}</label>
								<input type="text" name="last_callback_date" class="form-control" value="{{old('last_callback_date', $model->last_callback_date)}}" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Angol szóbeli')}}</label>
								<input type="text" name="in_english" class="form-control" value="{{old('in_english', $model->in_english)}}" />
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Információ a fejlesztőről')}}</label>
								<textarea name="description" class="form-control">{{old('linked_in', $model->description)}}</textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Cégeknek átküldve')}}</label>
								<textarea name="forwarded_to_companies" class="form-control">{{old('forwarded_to_companies', $model->forwarded_to_companies)}}</textarea>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Aktív')}}*</label>
								<select name="is_active" class="form-control">
									<option value="1" @if(old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Igen')}}</option>
									<option value="0" @if(!old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Nem')}}</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Csoportok')}}*</label>
								@foreach(\App\Models\ApplicantGroup::where('is_active', 1)->get() as $group)
									<div class="">
										<input type="checkbox" id="group_{{$group->id}}" name="groups[]" value="{{$group->id}}" @if(in_array($group->id, $selectedGroupIds)) checked="checked" @endif />
										<label for="group_{{$group->id}}">{{$group->name}}</label>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('applicants_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection