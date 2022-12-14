@extends('index')
@section('content_header')
	<h1>{{trans('Jelölt')}}: {{$model->name}} [{{$model->id}}]</h1>
@stop

@section('content')
	<div class="box">
		<div class="box-body">
			<div class="row">
				<div class="col-sm-4">{{trans('ID')}}</div>
				<div class="col-sm-8">{{$model->id}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Létrehozva')}}</div>
				<div class="col-sm-8">{{$model->created_at}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Utolsó módosítás')}}</div>
				<div class="col-sm-8">{{$model->updated_at}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Név')}}</div>
				<div class="col-sm-8">{{$model->name}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('E-mail cím')}}</div>
				<div class="col-sm-8">{{$model->email}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Telefon')}}</div>
				<div class="col-sm-8">{{$model->phone}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Linked In')}}</div>
				<div class="col-sm-8">{{$model->linked_in}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Angol szóban')}}</div>
				<div class="col-sm-8">{{$model->in_english}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Információ a fejlesztőről')}}</div>
				<div class="col-sm-8">{{$model->description}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Tapasztalat')}}</div>
				<div class="col-sm-8">{{$model->experience_year}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Utolsó kapcsolat')}}</div>
				<div class="col-sm-8">{{$model->last_contact_date}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Visszahívás')}}</div>
				<div class="col-sm-8">{{$model->last_callback_date}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Cégeknek átküldve')}}</div>
				<div class="col-sm-8">{{$model->forwarded_to_companies}}</div>
			</div>


			<div class="row">
				<div class="col-sm-4">{{trans('Végzettség')}}</div>
				<div class="col-sm-8">{{$model->graduation}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Fizetési igény')}}</div>
				<div class="col-sm-8">{{$model->salary}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Felmondási idő')}}</div>
				<div class="col-sm-8">{{$model->notice_period}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Alkalmazott')}}/{{trans('Alvállalkozó')}}</div>
				<div class="col-sm-8">{{$model->is_subcontractor ? trans('Alvállalkozó') : trans('Alkalmazott')}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Projektek')}}</div>
				<div class="col-sm-8">{{$model->projects}}</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Jegyzet')}}</div>
				<div class="col-sm-8">{{$model->projects}}</div>
			</div>

			<div class="row">
				<div class="col-sm-4">{{trans('Csoport(ok)')}}</div>
				<div class="col-sm-8">
					<ul>
						@foreach($model->groups()->orderBy('name', 'asc')->get() as $group)
							<li><a href="{{route('applicant_groups_view', ['id' => $group->id])}}">{{$group->name}}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">{{trans('Technológiák, készségek')}}</div>
				<div class="col-sm-8">
					<ul>
						@foreach($model->skills()->orderBy('name', 'asc')->get() as $skill)
							<li><a href="{{route('skills_view', ['id' => $skill->id])}}">{{$skill->name}}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>

		<div class="box-footer">
			<a href="{{url(route('applicants_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
			<a href="{{url(route('applicants_edit', ['id' => $model->id]))}}" class="btn btn-info pull-right">{{trans('Szerkesztés')}}</a>
		</div>
	</div>
@endsection