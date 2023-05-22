@extends('index')
@section('content_header')
	<h1>{{trans('Jelölt')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
	<form method="post" enctype="multipart/form-data">
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
								<input type="text" name="phone" class="form-control phone-number only-numbers" value="{{old('phone', $model->phone)}}" maxlength="11" placeholder="##/###-####" />
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
								<input type="date" name="last_contact_date" class="form-control" value="{{old('last_contact_date', $model->last_contact_date)}}" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Visszahívás')}}</label>
								<input type="date" name="last_callback_date" class="form-control" value="{{old('last_callback_date', $model->last_callback_date)}}" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Angol szóbeli')}}</label>
								<input type="text" name="in_english" class="form-control" value="{{old('in_english', $model->in_english)}}" />
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Végzettség')}}</label>
								<select name="graduation" class="form-control">
									@foreach(\App\Models\Applicant::getGraduationDropdownOptions() as $option)
										<option value="{{$option}}" @if($option == old('graduation', $model->graduation)) selected="selected" @endif>{{$option}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>{{trans('Fizetési igénye (nettó)')}}</label>
								<input type="text" name="salary" class="form-control salary only-numbers" value="{{old('salary', $model->salary)}}" />
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
									<option value="0" @if(old('is_subcontractor', $model->is_subcontractor) == 0) selected="selected" @endif>{{trans('Alkalmazott')}}</option>
									<option value="1" @if(old('is_subcontractor', $model->is_subcontractor) == 1) selected="selected" @endif>{{trans('Alvállalkozó')}}</option>
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
								<label>{{trans('Riport')}}</label>
								<textarea name="report" class="form-control">{{old('report', $model->report)}}</textarea>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Jegyzet')}}</label>
								<textarea name="note" class="form-control">{{old('note', $model->note)}}</textarea>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Csoportok')}}*</label>
								<div class="columns-count-3">
								@foreach(\App\Models\ApplicantGroup::where('is_active', 1)->get() as $group)
									<div class="">
										<input type="checkbox" id="group_{{$group->id}}" name="groups[]" value="{{$group->id}}" @if(in_array($group->id, $selectedGroupIds)) checked="checked" @endif />
										<label for="group_{{$group->id}}">{{$group->name}}</label>
									</div>
								@endforeach
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Technológiák, készségek')}}*</label>
								<div class="columns-count-3">
									@foreach(\App\Models\Skill::where('is_active', 1)->get() as $skill)
										<div class="">
											<input type="checkbox" id="skill_{{$skill->id}}" name="skills[]" value="{{$skill->id}}" @if(in_array($skill->id, $selectedSkillIds)) checked="checked" @endif />
											<label for="skill_{{$skill->id}}">{{$skill->name}}</label>
										</div>
									@endforeach
								</div>
							</div>
						</div>

						@if($model->hasCV())
							<div class="col-md-12">
								<iframe src="{{route('applicants_download_cv', ['id' => $model->id])}}" class="pdf_viewer"></iframe>
							</div>
						@endif
					</div>
					<div class="col-md-3">
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Aktív')}}*</label>
								<select name="is_active" class="form-control select2">
									<option value="1" @if(old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Igen')}}</option>
									<option value="0" @if(!old('is_active', $model->is_active)) selected="selected" @endif>{{trans('Nem')}}</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Home office igény')}}* ({{trans('nap/hét')}})</label>
								<select name="home_office" class="form-control select2">
									@for($i = 0; $i <= 5; $i++)
										<option value="{{$i}}" @if(old('home_office', $model->home_office) === $i) selected="selected" @endif>{{$i}}</option>
									@endfor
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Intézte')}}</label>
								<input type="text" name="monogram" value="{{old('monogram', $model->monogram)}}"  class="form-control" />
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>{{trans('Önéletrajz')}} (PDF)</label>
								<input type="file" class="form-control" name="cv_file" accept="application/pdf" />
							</div>
						</div>

						@if($model->hasCV())
							<div class="col-md-12">
								<div class="form-group">
									<label>{{trans('Feltöltve')}}</label>
									<p>
										<a href="{{route('applicants_download_cv', ['id' => $model->id])}}" target="_blank">{{$model->cv_file}}</a>
									</p>
									<p>
										<input type="checkbox" name="delete_cv_file" /> {{trans('Feltöltött file törlése')}}
									</p>
								</div>
							</div>
						@endif
					</div>
				</div>

				<div class="clearfix"></div>
			</div>

			<div class="box-footer">
				<a href="{{url(route('applicants_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
				<button type="submit" class="btn btn-primary pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection