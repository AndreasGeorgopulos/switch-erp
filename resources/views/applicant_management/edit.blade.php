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
									<label>{{trans('Angol szóbeli')}}</label>
									<select name="in_english" class="form-control select2">
										@foreach(\App\Models\Applicant::getInEnglishDropdownOptions($model->in_english) as $item)
											<option value="{{$item['value']}}" @if($item['selected'] === true) selected="selected" @endif>{{$item['name']}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Utolsó kapcsolat')}}</label>
									<input type="text" name="last_contact_date datetimepicker" class="form-control" value="{{old('last_contact_date', $model->last_contact_date)}}" placeholder="yyyy-mm-dd" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Visszahívás')}}</label>
									<input type="text" name="last_callback_date" class="form-control datetimepicker" value="{{old('last_callback_date', $model->last_callback_date)}}" placeholder="yyyy-mm-dd" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Végzettség')}}</label>
									<input type="text" name="graduation" class="form-control" value="{{old('graduation', $model->graduation)}}" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Fizetési igény')}}</label>
									<input type="number" name="salary" class="form-control" value="{{old('salary', $model->salary)}}" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Felmondási idő')}} ({{trans('nap')}})</label>
									<input type="number" name="notice_period" class="form-control" value="{{old('notice_period', $model->notice_period)}}" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>{{trans('Alkalmazott')}}/{{trans('Alvállalkozó')}}</label>
									<select name="is_subcontractor" class="form-control select2">
										@foreach(\App\Models\Applicant::getIsSubcontractorDropdownOptions($model->is_subcontractor) as $key => $item)
											<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Technológiák, készségek')}}*</label>
									<select required="required" name="applicant[skills][]" class="form-control select2" multiple>
										@foreach(\App\Models\Applicant::getSkillDropdownOptions($selectedSkillIds) as $item)
											<option @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
										@endforeach
									</select>
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
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Projektek')}}</label>
									<textarea name="projects" class="form-control">{{old('projects', $model->projects)}}</textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>{{trans('Riport')}}</label>
									<textarea name="report" class="form-control">{{old('report', $model->report)}}</textarea>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>{{trans('Jegyzet')}}</label>
									<textarea name="note" class="form-control">{{old('note', $model->note)}}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>{{trans('Önéletrajz')}} (PDF)</label>
							<input type="file" class="form-control" name="cv_file" accept="application/pdf" />
						</div>
						@if($model->hasCV())
							<iframe src="{{route('applicants_download_cv', ['id' => $model->id])}}" class="pdf_viewer" width="100%" height="800"></iframe>
						@endif
					</div>
				</div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('applicant_management_index', ['selectedGroup' => $selectedGroup]))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection