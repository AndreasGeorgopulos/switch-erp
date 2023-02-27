@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@endsection

@section('content')
	<div class="applicant-management">
		<div class="row">
			<div class="col-sm-2">

				<ul class="nav" id="applicant-skill-sidebar">
				@foreach($applicantGroups as $group)
					<li class="nav-item @if($selectedGroup !== null && $group->id == $selectedGroup->id) active @endif">
						<a href="{{url(route('applicant_management_index', ['selectedGroup' => $group->id]))}}" class="nav-link">
							{{$group->name}} @if($group->applicants->count()) <span class="badge pull-right">{{$group->applicants->count()}}</span> @endif
						</a>
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
			<div class="col-sm-10 table-area">
				@if($selectedGroup !== null)
					<h1 class="applicant-group-name">{{$selectedGroup->name}}</h1>

					<form method="post" action="{{route('applicant_management_save_rows', ['$selectedGroup' => $selectedGroup])}}">
						{{csrf_field()}}

						<table class="table table-bordered table-striped dataTable" id="new-applicant-table">
							<thead class="hidden">
							<tr>
								<th>{{trans('Név')}}</th>
								<th>{{trans('Tapasztalat')}}</th>
								<th>{{trans('Angol')}}</th>
								<th>{{trans('Technológia')}}</th>
								<th>{{trans('E-mail')}}</th>
								<th>{{trans('LinkedIn')}}</th>
							</tr>
							</thead>
							<tbody></tbody>
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

					<table class="table table-bordered table-striped dataTable" id="data-applicant-table">
						<thead>
						<tr role="row">
							<th>{{trans('Név')}}</th>
							<th>{{trans('Tapasztalat')}}</th>
							<th>{{trans('Angol')}}</th>
							<th>{{trans('Technológia')}}</th>
							<th>{{trans('Cég')}}</th>
							<th>{{trans('Információ')}}</th>
							<th>{{trans('Utolsó kapcsolat')}}</th>
							<th>{{trans('E-mail')}}</th>
							<th>{{trans('Telefon')}}</th>
							<th>{{trans('Intézte')}}</th>
							<th>{{trans('LinkedIn')}}</th>
							<th>{{trans('Önéletrajz')}}</th>
						</tr>
						<tr>
							<th>
								<select name="applicant" class="form-control search-input select2" style="width: 150px;">
									<option></option>
									@foreach(\App\Models\Applicant::getNameDropdownOptions($selectedGroup->id) as $item)
										<option value="{{$item['id']}}" @if($item['id'] == $getParams['applicant']) selected="selected" @endif>{{$item['name']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<input type="text" name="experience_year" class="form-control search-input" value="{{$getParams['experience_year']}}" style="width: 100px;" />
							</th>
							<th>
								<select name="in_english" class="form-control search-input select2" style="width: 110px;">
									@foreach(\App\Models\Applicant::getInEnglishDropdownOptions() as $item)
										<option value="{{$item['value']}}" @if($item['value'] == $getParams['in_english']) selected="selected" @endif>{{$item['name']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<select name="skill" class="form-control search-input select2" style="width: 210px;">
									<option></option>
									@foreach(\App\Models\Applicant::getSkillDropdownOptions([$getParams['skill']], $selectedGroup->id) as $item)
										<option value="{{$item['id']}}" @if($item['selected']) selected="selected" @endif>{{$item['name']}}</option>
									@endforeach
								</select>
							</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
						</thead>

						<tbody>
						@foreach($applicants as $applicant)
							@php
								$companies = [];
								foreach ($applicant->companies()->get() as $item) {
									if (in_array($item->company->name, $companies)) {
										continue;
									}
									$companies[] = $item->company->name;
								}
								$companies = collect($companies)->sortBy(0, SORT_REGULAR, true)->implode(', ');

								$inEnglishOption = collect(\App\Models\Applicant::getInEnglishDropdownOptions($applicant->in_english))->where('selected', true)->first();
								$inEnglishTitle = !empty($inEnglishOption) ? $inEnglishOption['name'] : '';
							@endphp
							<tr>
								<td>{{$applicant->name}}</td>
								<td>{{$applicant->experience_year}}</td>
								<td>{{$inEnglishTitle}}</td>
								<td>{{$applicant->skills->pluck('name')->implode(', ')}}</td>
								<td>{{$companies}}</td>
								<td>{{$applicant->description}}</td>
								<td>{{str_replace('-', '.', $applicant->last_contact_date)}}</td>
								<td>{{$applicant->email}}</td>
								<td>{{$applicant->phone}}</td>
								<td>{{$applicant->monogram}}</td>
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
					</table>
				@endif
			</div>
		</div>
	</div>
@stop
