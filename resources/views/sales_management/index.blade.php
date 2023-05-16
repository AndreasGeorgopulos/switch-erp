@extends('index')

@section('content_header')
	@include('../layout/management_tabs')
@endsection

@section('content')
	<div class="sales-management">
		<div class="row">
			<div class="col-sm-12 table-area">
				<form method="post" action="{{route('sales_management_add')}}">
					{{csrf_field()}}

					<table class="table table-bordered table-striped dataTable" id="new-sales-table">
						<thead class="hidden">
						<tr>
							<th>{{trans('Cégnév')}}</th>
							<th>{{trans('Visszahívás dátuma')}}</th>
							<th>{{trans('Kapcsolat')}}</th>
							<th>{{trans('Pozíció')}}</th>
							<th>{{trans('Telefonszám')}}</th>
							<th>{{trans('E-mail')}}</th>
							<th>{{trans('Információ')}}</th>
							<th>{{trans('Utolsó kapcsolat')}}</th>
							<th>{{trans('Weboldal')}}</th>
							<th>{{trans('Intézte')}}</th>
						</tr>
						</thead>
						<tbody></tbody>
						<tfoot>
						<tr>
							<td colspan="9">
								<button type="button" class="btn btn-default btn-sm btn-new">
									<i class="fa fa-plus"></i> {{trans('Új cég hozzáadása')}}
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

				<table class="table table-bordered table-striped dataTable" id="data-sales-table">
					<thead>
						<tr role="row">
							<th></th>
							<th>
								{{trans('Név')}}
								<button class="btn btn-default btn-xs pull-right btn-table-filter-open">
									<i class="fa fa-search"></i>
								</button>
								<button class="btn btn-default btn-xs pull-right btn-table-filter-close hidden">
									<i class="fa fa-close"></i>
								</button>
							</th>
							<th>{{trans('Státusz')}}</th>
							<th>{{trans('Visszahívás dátuma')}}</th>
							<th>{{trans('Kapcsolat')}}</th>
							<th>{{trans('Pozíció')}}</th>
							<th>{{trans('Telefonszám')}}</th>
							<th>{{trans('E-mail')}}</th>
							<th>{{trans('Információ')}}</th>
							<th>{{trans('Utolsó kapcsolat')}}</th>
							<th>{{trans('Weboldal')}}</th>
							<th>{{trans('Intézte')}}</th>
							<th>{{trans('Törlés')}}</th>
						</tr>
						<tr role="row" class="filter-row hidden">
							<th></th>
							<th>
								<select name="company_name" class="form-control search-input w-400">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('company_name', $getParams['company_name']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<select name="status" class="form-control select2 search-input w-200">
									<option></option>
									@foreach(\App\Models\Sale::getStatusDropdownOptions($getParams['status']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<input type="date"
								       name="callback_date"
								       value="{{$getParams['callback_date']}}"
								       class="form-control search-input w-150"
								       max="2999-12-31" />
							</th>
							<th>
								<select name="contact" class="form-control select2 search-input w-200">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('contact', $getParams['contact']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<select name="position" class="form-control select2 search-input w-200">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('position', $getParams['position']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<select name="phone" class="form-control select2 search-input w-200">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('phone', $getParams['phone']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<select name="email" class="form-control select2 search-input w-300">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('email', $getParams['email']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<input type="text"
								       name="information"
								       value="{{$getParams['information']}}"
								       class="form-control search-input w-500" />
							</th>
							<th>
								<input type="date"
								       name="last_contact_date"
								       value="{{$getParams['last_contact_date']}}"
								       class="form-control search-input w-150"
								       max="2999-12-31" />
							</th>
							<th>
								<select name="web" class="form-control select2 search-input w-300">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('web', $getParams['web']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th>
								<select name="monogram" class="form-control select2 search-input w-300">
									<option></option>
									@foreach(\App\Models\Sale::getFilterDropdownOptions('monogram', $getParams['monogram']) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
					@foreach($sales as $model)
						<tr id="{{$model->id}}" data-sort="{{$model->id}}">
							<td class="dragHandle text-center"><i class="fa fa-reorder"></i></td>
							<td>
								<input type="text"
								       name="company_name"
								       class="form-control input-sm"
								       value="{{$model->company_name}}"
								       data-value="{{$model->company_name}}" />
							</td>
							<td>
								<select name="status"
								        class="form-control input-sm"
								        data-value="{{$model->status}}">
									<option></option>
									@foreach(\App\Models\Sale::getStatusDropdownOptions($model->status) as $item)
										<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<input type="date"
								       name="callback_date"
								       class="form-control input-sm"
								       value="{{$model->callback_date != '0000-00-00' ? $model->callback_date : null}}"
								       data-value="{{$model->callback_date != '0000-00-00' ? $model->callback_date : null}}" />
							</td>
							<td>
								<input type="text"
								       name="contact"
								       class="form-control input-sm"
								       value="{{$model->contact}}"
								       data-value="{{$model->contact}}" />
							</td>
							<td>
								<input type="text"
								       name="position"
								       class="form-control input-sm"
								       value="{{$model->position}}"
								       data-value="{{$model->position}}" />
							</td>
							<td>
								<input type="text"
								       name="phone"
								       class="form-control input-sm"
								       value="{{$model->phone}}"
								       data-value="{{$model->phone}}" />
							</td>
							<td>
								<input type="text"
								       name="email"
								       class="form-control input-sm"
								       value="{{$model->email}}"
								       data-value="{{$model->email}}" />
							</td>
							<td>
								<input type="text"
								       name="information"
								       class="form-control input-sm"
								       value="{{$model->information}}"
								       data-value="{{$model->information}}" />
							</td>
							<td>
								<input type="date"
								       name="last_contact_date"
								       class="form-control input-sm"
								       value="{{$model->last_contact_date != '0000-00-00' ? $model->last_contact_date : null}}"
								       data-value="{{$model->last_contact_date != '0000-00-00' ? $model->last_contact_date : null}}" />
							</td>
							<td>
								<input type="text"
								       name="web"
								       class="form-control input-sm"
								       value="{{$model->web}}"
								       data-value="{{$model->web}}" />
							</td>
							<td>
								<input type="text"
								       name="monogram"
								       class="form-control input-sm"
								       value="{{$model->monogram}}"
								       data-value="{{$model->monogram}}" />
							</td>
							<td class="text-center">
								<form method="post"
								      class="delete-sale"
								      action="{{url(route('sales_management_delete', ['id' => $model->id]))}}" >
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-sm btn-danger">
										<i class="fa fa-minus"></i>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>

				<div class="foot-toolbar">
					<button type="button" class="btn btn-default btn-scroll-left">
						<i class="fa fa-arrow-left"></i>
					</button>

					<button type="button" class="btn btn-success btn-reorder-save hidden">
						<i class="fa fa-save"></i> {{trans('Sorrend mentése')}}
					</button>

					<button type="button" class="btn btn-default btn-reorder-cancel hidden">
						<i class="fa fa-close"></i> {{trans('Elvetés')}}
					</button>

					<button type="button" class="btn btn-success btn-modify-save hidden">
						<i class="fa fa-save"></i> {{trans('Változások mentése')}}
					</button>

					<button type="button" class="btn btn-default btn-modify-cancel hidden">
						<i class="fa fa-close"></i> {{trans('Elvetés')}}
					</button>

					<button type="button" class="btn btn-default btn-scroll-right">
						<i class="fa fa-arrow-right"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
@endsection