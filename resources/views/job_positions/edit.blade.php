@extends('index')
@section('content_header')
	<h1>{{trans('Pozíció')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
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
								<label>{{trans('Megnevezés')}}*</label>
								<input type="text" name="title" class="form-control" value="{{old('title', $model->title)}}" />
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
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label>{{trans('Cég')}}*</label>
								<select name="company_id" class="form-control select2">
									@foreach(\App\Models\Company::getDropdownItems($model->company_id) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>{{trans('Technológiák')}}*</label>
								<select required="required" name="skills[]" class="form-control select2" multiple>
									@foreach(\App\Models\Applicant::getSkillDropdownOptions($selectedSkillIds) as $item)
										<option @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>{{trans('Leírás')}}*</label>
								<textarea name="description" class="form-control">{{old('description', $model->description)}}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-info">
						<div class="panel-header pl-2"><h3 class="h3 m-0">{{trans('Kapcsolattartó')}}</h3></div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>{{trans('Név')}}*</label>
										<input type="text" name="contact_name" class="form-control" value="{{old('contact_name', $model->contact_name)}}" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>{{trans('E-mail')}}*</label>
										<input type="email" name="contact_email" class="form-control" value="{{old('contact_email', $model->contact_email)}}" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>{{trans('Telefon')}}*</label>
										<input type="text" name="contact_phone" class="form-control phone-number" value="{{old('contact_phone', $model->contact_phone)}}" maxlength="11" placeholder="xx/xxx-xxxx" />
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('job_positions_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection