@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<form method="post" enctype="multipart/form-data">
		{{csrf_field()}}

		<input type="hidden" name="backUrl" value="{{$backUrl}}" />

		@include('layout.messages')
		<div class="box">
			<div class="box-header">
				<a href="{{$backUrl}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-primary pull-right">{{trans('Mentés')}}</button>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>{{trans('Név')}}*</label>
									<input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" tabindex="1" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>{{trans('E-mail cím')}}</label>
									<input type="text" name="email" class="form-control" value="{{old('email', $model->email)}}" tabindex="2" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>{{trans('Telefon')}}</label>
									<input type="text" name="phone" class="form-control phone-number only-numbers" value="{{old('phone', $model->phone)}}" maxlength="11" placeholder="##/###-####" tabindex="3" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>{{trans('Linked In')}}</label>
									<input type="text" name="linked_in" class="form-control" value="{{old('linked_in', $model->linked_in)}}" tabindex="4" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Tapasztalat')}} ({{trans('Év')}})</label>
									<input type="number" name="experience_year" class="form-control" value="{{old('experience_year', $model->experience_year)}}" tabindex="5" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Angol szóbeli')}}</label>
									<select name="in_english" class="form-control select2" tabindex="6">
										@foreach(\App\Models\Applicant::getInEnglishDropdownOptions($model->in_english) as $item)
											<option value="{{$item['value']}}" @if($item['selected'] === true) selected="selected" @endif>{{$item['name']}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Utolsó kapcsolat')}}</label>
									<input type="date" name="last_contact_date" max="2999-12-31" class="form-control" value="{{old('last_contact_date', $model->last_contact_date)}}" tabindex="7" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Visszahívás')}}</label>
									<input type="date" name="last_callback_date" max="2999-12-31" class="form-control" value="{{old('last_callback_date', $model->last_callback_date)}}" tabindex="8" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Végzettség')}}</label>
									<select name="graduation" class="form-control" tabindex="9">
										@foreach(\App\Models\Applicant::getGraduationDropdownOptions() as $option)
											<option value="{{$option}}" @if($option == old('graduation', $model->graduation)) selected="selected" @endif>{{$option}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Fizetési igénye (nettó)')}}</label>
									<input type="text" name="salary" class="form-control salary only-numbers" value="{{old('salary', $model->salary)}}" tabindex="10" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Felmondási idő')}} ({{trans('nap')}})</label>
									<input type="number" name="notice_period" class="form-control" value="{{old('notice_period', $model->notice_period)}}" tabindex="11" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Munkaviszony')}}</label>
									<select name="employment_relationship" class="form-control select2" tabindex="12">
										@foreach(\App\Models\Applicant::getEmploymentRelationshipDropdownOptions($model->employment_relationship) as $key => $item)
											<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('HO')}} ({{trans('nap/hét')}})</label>
									<select name="home_office" class="form-control select2">
										@for($i = 0; $i <= 5; $i++)
											<option value="{{$i}}" @if(old('home_office', $model->home_office) === $i) selected="selected" @endif>{{$i}}</option>
										@endfor
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Technológiák, készségek')}}</label>
									<select name="applicant[skills][]" class="form-control select2" multiple tabindex="13">
										@foreach(\App\Models\Applicant::getSkillDropdownOptions($selectedSkillIds) as $item)
											<option @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Információ a jelöltről')}}</label>
									<textarea name="description" class="form-control" tabindex="14">{{old('linked_in', $model->description)}}</textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Cégeknek átküldve')}}</label>
									<select name="applicant[companies][]" class="form-control select2" multiple tabindex="15">
										@foreach(\App\Models\JobPosition::getCompanyDropdownItems(false) as $item)
											<option value="{{$item->id}}"
												@if(in_array($item->id, $model->companies()->pluck('id')->toArray())) selected="selected" @endif
											>{{$item->company->name}} - {{$item->title}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Intézte')}}</label>
									<input type="text" name="monogram" value="{{old('monogram', $model->monogram)}}"  class="form-control" tabindex="16" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>{{trans('Riport')}}</label>
									<textarea name="report" class="form-control" rows="17">{{old('report', $model->report)}}</textarea>
								</div>
							</div>
							<div class="col-sm-6">
								@include('applicant_management._notes')
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>{{trans('Önéletrajz')}} (PDF)</label>
							<input type="file" class="form-control" name="cv_file" accept="application/pdf" />
						</div>
						@if($model->hasCV())
							@php($cvUrl = url(route('applicants_download_cv', ['id' => $model->id])) . '?ts=' . time())
							<div class="form-group">
								<a href="{{$cvUrl}}" target="_blank">
									{{$model->cv_file}}
								</a>

								<label class="pull-right">
									<input type="checkbox" name="delete_cv_file" /> {{trans('Feltöltött file törlése')}}
								</label>
							</div>
							<iframe src="{{$cvUrl}}" class="pdf_viewer" width="100%" height="1045"></iframe>
						@endif
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{$backUrl}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-primary pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection