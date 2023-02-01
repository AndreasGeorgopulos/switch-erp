@foreach($result as $item)
	<div class="row">
		<div class="col-sm-3">Cég:</div>
		<div class="col-sm-9">{{$item['company']}}</div>
		<div class="col-sm-3">Pozíció:</div>
		<div class="col-sm-9">{{$item['job_position_title']}}</div>
		<div class="col-sm-3">Jegyzet:</div>
		<div class="col-sm-12">{{$item['description']}}</div>
		<div class="clearfix"></div>
		<div class="col-sm-3">Dátum:</div>
		<div>{{$item['send_date']}}</div>
	</div>
	<div class="text-center">
		<button type="button" data-href="{{url(route('applicant_management_delete_note', ['applicant_id' => $item['applicant_id'], 'job_position_id' => $item['job_position_id']]))}}"
			class="btn btn-sm btn-danger btn-delete-note">
			<i class="fa fa-minus"></i>
		</button>
	</div>
	<hr />
@endforeach