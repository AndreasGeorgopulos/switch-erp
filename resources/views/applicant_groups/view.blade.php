@extends('index')
@section('content_header')
	<h1>{{trans('Jelölt csoport')}}: {{$model->name}} [{{$model->id}}]</h1>
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
				<div class="col-sm-4">{{trans('Jelöltek')}}</div>
				<div class="col-sm-8">
					<ul>
						@foreach($model->applicants()->orderBy('name', 'asc')->get() as $applicant)
							<li><a href="{{route('applicants_view', ['id' => $applicant->id])}}">{{$applicant->name}}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>

		<div class="box-footer">
			<a href="{{url(route('applicant_groups_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
			<a href="{{url(route('applicant_groups_edit', ['id' => $model->id]))}}" class="btn btn-info pull-right">{{trans('Szerkesztés')}}</a>
		</div>
	</div>
@endsection