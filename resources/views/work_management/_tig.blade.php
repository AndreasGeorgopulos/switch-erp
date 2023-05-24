@php
$params = ['applicant_id' => $m->applicant_id, 'job_position_id' => $m->job_position_id];
$actionDownload = url(route('work_management_download_tig', $params));
$actionDelete = url(route('work_management_delete_tig', $params));
$actionUpload = url(route('work_management_upload_tig', $params));
@endphp

@if($m->hasTIG())
	<a href="{{$actionDownload}}" class="btn btn-success btn-sm" target="_blank">
		<i class="fa fa-download"></i>
	</a>
	<a href="{{$actionDelete}}" class="btn btn-danger btn-sm btn-delete-tig">
		<i class="fa fa-minus"></i>
	</a>
@else
	<button class="btn btn-primary btn-sm btn-upload-tig" data-action="{{$actionUpload}}">
		<i class="fa fa-upload"></i>
	</button>
@endif