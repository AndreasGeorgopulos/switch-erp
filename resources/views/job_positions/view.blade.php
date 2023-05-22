@extends('index')
@section('content_header')
	<h1>{{trans('Pozíció')}}: {{$model->title}} [{{$model->id}}]</h1>
@stop

@section('content')
	<div class="box">
		<div class="box-body">
			<div class="model-view">
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
					<div class="col-sm-5">{{trans('Megnevezés')}}</div>
					<div class="col-sm-7">{{$model->title}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Cég')}}</div>
					<div class="col-sm-7">{{$model->company->name}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Technológiák')}}</div>
					<div class="col-sm-7">{{$model->skills()->orderBy('name', 'asc')->pluck('name')->implode(', ')}}</div>
				</div>
				<div class="row">
					<div class="col-sm-5">{{trans('Leírás')}}</div>
					<div class="col-sm-7">{!! $model->description !!}</div>
				</div>
			</div>
		</div>

		<div class="box-footer">
			<a href="{{url(route('job_positions_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
			<a href="{{url(route('job_positions_edit', ['id' => $model->id]))}}" class="btn btn-primary pull-right">{{trans('Szerkesztés')}}</a>
		</div>
	</div>
@endsection
