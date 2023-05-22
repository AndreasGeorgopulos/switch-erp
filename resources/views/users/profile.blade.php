@extends('index')
@section('content_header')
	<h1>{{trans('Felhasználó')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
	<form method="post">
		{{csrf_field()}}
		@include('layout.messages')
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>{{trans('Név')}}</label>
							<br />
							<b>{{$model->name}}</b>
						</div>
						<div class="form-group">
							<label>{{trans('Monogram')}}</label>
							<br />
							<b>{{$model->monogram}}</b>
						</div>
						<div class="form-group">
							<label>{{trans('E-mail cím')}}</label>
							<br />
							<b>{{$model->email}}</b>
						</div>
						<div class="form-group">
							<label>{{trans('Új jelszó')}}</label>
							<input type="password" class="form-control" name="password" placeholder="" />
						</div>
						<div class="form-group">
							<label>{{trans('Új jelszó megerősítése')}}</label>
							<input type="password" class="form-control" name="password_confirmation" placeholder="" />
						</div>
					</div>

					<div class="col-md-8">
						<div class="form-group">
							<label>{{trans('Szűrés: pozíciók')}}</label>
							<select name="job_positions[]" class="form-control select2" multiple>
								@foreach(\App\Models\JobPosition::getCompanyDropdownItems() as $item)
									<option value="{{$item->id}}"
									        @if(in_array($item->id, $jobPositionIds)) selected="selected" @endif
									>{{$item->company->name}} - {{$item->title}}</option>
								@endforeach
							</select>
							<div class="hint">{{trans('Ha nincs egy elem sem kiválasztva, a Keresés modulban az összes cég és pozíció megjelenik.')}}</div>
						</div>

						<div class="form-group">
							<label>{{trans('Szűrés: jelölt csoportok')}}</label>
							<select name="applicant_groups[]" class="form-control select2" multiple>
								@foreach(\App\Models\ApplicantGroup::getDropdownItems($applicantGroupIds) as $item)
									<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
								@endforeach
							</select>
							<div class="hint">{{trans('Ha nincs egy elem sem kiválasztva, az Adatbázis modulban az összes jelölt csoport megjelenik.')}}</div>
						</div>

						<div class="form-group">
							<label>{{trans('Téma')}}</label>
							<select name="theme_id" class="form-control select2">
								<option>{{trans('Alapértelmezett beállítások')}}</option>
								@foreach(\App\Models\Theme::getDropdownItems($model->theme_id) as $item)
									<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right">{{trans('Mentés')}}</button>
			</div>
		</div>
	</form>
@endsection