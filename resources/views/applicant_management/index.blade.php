@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@stop

@section('content')
	<div class="row">
		<div class="col-sm-2">

			<ul class="nav" id="applicant-skill-sidebar">
			@foreach($applicantGroups as $group)
				<li class="nav-item @if($selectedGroup !== null && $group->id == $selectedGroup->id) active @endif">
					<a href="{{url(route('applicant_management_index', ['selectedGroup' => $group->id]))}}" class="nav-link">{{$group->name}}</a>
				</li>
			@endforeach
			</ul>

			<select id="hidden_select_skills" class="hidden">
				@foreach(\App\Models\Applicant::getSkillDropdownOptions() as $item)
					<option @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
				@endforeach
			</select>
			<select id="hidden_select_in_english" class="hidden">
				@foreach(\App\Models\Applicant::getInEnglishDropdownOptions() as $item)
					<option value="{{$item['value']}}" @if($item['selected'] === true) selected="selected" @endif>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-sm-10">
			@if($selectedGroup !== null)
				<form method="post" action="{{route('applicant_management_save_rows', ['$selectedGroup' => $selectedGroup])}}">
					{{csrf_field()}}
					<table class="table table-bordered table-striped dataTable" id="applicant-table">
						<thead>
						<tr role="row">
							<th>{{trans('Név')}}</th>
							<th>{{trans('Tapasztalat')}}</th>
							<th>{{trans('Angol')}}</th>
							<th>{{trans('Technológia')}}</th>
							<th>{{trans('E-mail')}}</th>
							<th>{{trans('LinkedIn')}}</th>
							<th>{{trans('Önéletrajz')}}</th>
						</tr>
						</thead>

						<tbody>
						@foreach($selectedGroup->applicants as $applicant)
							<tr>
								<td>{{$applicant->name}}</td>
								<td>{{$applicant->experience_year}}</td>
								<td>
									@if($applicant->in_english == 1){{trans('Alapfok')}}
									@elseif($applicant->in_english == 2){{trans('Középfok')}}
									@elseif($applicant->in_english == 3){{trans('Felsőfok')}}
									@endif
								</td>
								<td>{{$applicant->skills->pluck('name')->implode(', ')}}</td>
								<td>{{$applicant->email}}</td>
								<td class="text-center">
									@if(!empty($applicant->linked_in))
										<a href="{{$applicant->linked_in}}" target="_blank"><i class="fa fa-linkedin"></i></a>
									@else
										<i class="fa fa-can"></i>
									@endif
								</td>
								<td class="text-center">
									<a href="{{url(route('applicant_management_edit', ['id' => $applicant->id, 'selectedGroup' => $selectedGroup]))}}">
										<i class="fa @if($applicant->hasCv()) fa-edit @else fa-plus @endif"></i>
									</a>
								</td>
							</tr>
						@endforeach
						</tbody>

						<tfoot>
						<tr>
							<td colspan="5">
								<button type="button" class="btn btn-default btn-sm btn-new">
									<i class="fa fa-plus"></i> {{trans('Új jelölt hozzáadása')}}
								</button>
							</td>
							<td colspan="2" class="text-right hidden save-buttonbar">
								<button type="submit" class="btn btn-success btn-sm btn-save">
									<i class="fa fa-save"></i> {{trans('Mentés')}}
								</button>
								<button type="button" class="btn btn-default btn-sm btn-cancel">
									<i class="fa fa-close"></i> {{trans('Mégsem')}}
								</button>
							</td>
						</tr>
						</tfoot>
					</table>
				</form>
			@endif
		</div>
	</div>
@stop