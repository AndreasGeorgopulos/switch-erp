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
			</div>

			@if($model->hasContract())
				<hr />
				<iframe src="{{route('companies_download_contract', ['id' => $model->id])}}" class="cv_viewer" width="100%" height="700"></iframe>
			@endif
		</div>

		<div class="box-footer">
			<a href="{{url(route('companies_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
			<a href="{{url(route('companies_edit', ['id' => $model->id]))}}" class="btn btn-info pull-right">{{trans('Szerkesztés')}}</a>
		</div>
	</div>
@endsection