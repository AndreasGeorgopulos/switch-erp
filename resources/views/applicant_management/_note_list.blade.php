<div class="applicant-note-list">
@foreach($result as $item)
	<div class="row">
		@if($item['job_position_title'] !== null)
			<div class="col-sm-3">Cég:</div>
			<div class="col-sm-9">{{$item['company']}}</div>
			<div class="col-sm-3">Pozíció:</div>
			<div class="col-sm-9">{{$item['job_position_title']}}</div>
		@endif
		<div class="col-sm-3">Jegyzet:</div>
		<div class="col-sm-12">{{$item['description']}}</div>
		<div class="clearfix"></div>
		<div class="col-sm-3">Dátum:</div>
		<div>{{$item['send_date']}}</div>
		<div class="col-sm-3">Írta:</div>
		<div>{{$item['monogram']}}</div>
	</div>
	<div class="text-center">
		<button type="button" data-href="{{url(route('applicant_management_delete_note', ['id' => $item['id']]))}}"
			class="btn btn-sm btn-danger btn-delete-note">
			<i class="fa fa-minus"></i>
		</button>
	</div>
	<hr />
@endforeach
</div>