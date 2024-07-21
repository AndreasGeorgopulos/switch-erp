@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<form method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		@include('layout.messages')
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

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{trans('Sikerdíj mértéke')}} (%)</label>
									<input type="text" name="success_award" class="form-control only-numbers percent" value="{{old('success_award', $model->success_award)}}" maxlength="3" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{trans('Fizetési határidő')}} (nap)</label>
									<input type="text" name="payment_deadline" class="form-control only-numbers" value="{{old('payment_deadline', $model->payment_deadline)}}" maxlength="3" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{trans('Szerződés dátuma')}}</label>
									<input type="date" name="contract_date" max="2999-12-31" class="form-control" value="{{old('contract_date', $model->contract_date)}}" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Kapcsolattartó')}}</label>
									<input type="text" name="contact_name" class="form-control" value="{{old('contact_name', $model->contact_name)}}" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('E-mail')}}</label>
									<input type="text" name="contact_email" class="form-control" value="{{old('contact_email', $model->contact_email)}}" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Telefon')}}</label>
									<input type="text" name="contact_phone" class="form-control phone-number only-numbers" value="{{old('contact_phone', $model->contact_phone)}}" maxlength="11" placeholder="##/###-####" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Cég bemutató')}}</label>
									<textarea name="description" class="form-control height-200" maxlength="65535">{{old('description', $model->description)}}</textarea>
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
									<a href="{{route('contract_management_download', ['id' => $model->id])}}" target="_blank">{{$model->contract_file}}</a>
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
				<button type="submit" class="btn btn-primary pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection