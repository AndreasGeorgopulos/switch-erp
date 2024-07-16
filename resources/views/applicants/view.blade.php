@extends('index')
@section('content_header')
	<h1>{{trans('Jelölt')}}: {{$model->name}} [{{$model->id}}]</h1>
@stop

@section('content')
	<div class="box">
		<div class="box-body">
			<div class="columns-count-3 model-view">
				<div class="row">
					<div class="col-sm-5">{{trans('ID')}}</div>
					<div class="col-sm-7">{{$model->id}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Létrehozva')}}</div>
					<div class="col-sm-7">{{$model->created_at}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Utolsó módosítás')}}</div>
					<div class="col-sm-7">{{$model->updated_at}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Név')}}</div>
					<div class="col-sm-7">{{$model->name}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('E-mail cím')}}</div>
					<div class="col-sm-7">{{$model->email}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Telefon')}}</div>
					<div class="col-sm-7">{{$model->phone}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Linked In')}}</div>
					<div class="col-sm-7">{{$model->linked_in}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Angol szóban')}}</div>
					<div class="col-sm-7">{{$model->in_english}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Információ a fejlesztőről')}}</div>
					<div class="col-sm-7">{{$model->description}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Tapasztalat')}}</div>
					<div class="col-sm-7">{{$model->experience_year}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Utolsó kapcsolat')}}</div>
					<div class="col-sm-7">{{$model->last_contact_date}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Visszahívás')}}</div>
					<div class="col-sm-7">{{$model->last_callback_date}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Cégeknek átküldve')}}</div>
					<div class="col-sm-7">{{$model->forwarded_to_companies}}</div>
				</div>


				<div class="row">
					<div class="col-sm-5">{{trans('Végzettség')}}</div>
					<div class="col-sm-7">{{$model->graduation}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Fizetési igénye (nettó)')}}</div>
					<div class="col-sm-7">{{$model->salary}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Felmondási idő')}}</div>
					<div class="col-sm-7">{{$model->notice_period}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Munkaviszony')}}</div>
					<div class="col-sm-7">
						@if(!is_null($model->employment_relationship))
							{{ \App\Models\Applicant::getEmploymentRelationshipDropdownOptions()[$model->employment_relationship]['name'] }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Home office igény')}}</div>
					<div class="col-sm-7">
						@if($model->home_office === null)-
						@elseif($model->home_office > 0){{$model->home_office}} {{trans('nap hetente')}}
						@else{{trans('Nincs')}}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Intézte')}}</div>
					<div class="col-sm-7">{{$model->monogram}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Jegyzet')}}</div>
					<div class="col-sm-7">{{$model->note}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Riport')}}</div>
					<div class="col-sm-7">{{$model->report}}</div>
				</div>

				<div class="row">
					<div class="col-sm-5">{{trans('Csoport(ok)')}}</div>
					<div class="col-sm-7">
						<ul>
							@foreach($model->groups()->orderBy('name', 'asc')->get() as $group)
								<li><a href="{{route('applicant_groups_view', ['id' => $group->id])}}">{{$group->name}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Technológiák, készségek')}}</div>
					<div class="col-sm-7">
						<ul>
							@foreach($model->skills()->orderBy('name', 'asc')->get() as $skill)
								<li><a href="{{route('skills_view', ['id' => $skill->id])}}">{{$skill->name}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

			@if($model->hasCV())
				<hr />
				<div class="row">
					<div class="col-sm-12">
						<iframe src="{{route('applicants_download_cv', ['id' => $model->id])}}" class="cv_viewer" width="100%" height="700" />
					</div>
				</div>
			@endif
		</div>

		<div class="box-footer">
			<a href="{{url(route('applicants_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
			<a href="{{url(route('applicants_edit', ['id' => $model->id]))}}" class="btn btn-primary pull-right">{{trans('Szerkesztés')}}</a>
		</div>
	</div>
@endsection