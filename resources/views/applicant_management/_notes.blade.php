<div id="applicant-note-area">
	<input type="hidden" class="applicant-id" value="{{$model->id}}" />

	<label>{{trans('Jegyzet')}}</label>

	<div class="area-add-btn text-center">
		<button type="button" class="btn btn-primary btn-sm add-btn">
			<i class="fa fa-plus"></i>
		</button>
	</div>

	<div class="area-form">
		{{csrf_field()}}
		<div class="form-group">
			<label>{{trans('Cég')}}</label>
			<br/>
			<select class="form-control select2 select-company">
				<option value="0"></option>
				@foreach(\App\Models\Company::getDropdownItems(null, true) as $item)
					<option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>{{trans('Pozíció')}}</label>
			<select class="form-control select2 select-job-position"></select>
		</div>
		<div class="form-group">
			<label>{{trans('Jegyzet')}}</label>
			<textarea name="description" class="form-control textarea-note" rows="9">{{old('note', $model->note)}}</textarea>
		</div>
		<div class="form-group">
			<label>{{trans('Írta')}}</label>
			<input name="monogram" class="form-control" value="{{old('note', $model->note)}}" />
		</div>

		<div class="text-center">
			<button type="button" class="btn btn-success btn-sm ok-btn">
				<i class="fa fa-check"></i>
			</button>
			<button type="button" class="btn btn-default btn-sm cancel-btn">
				<i class="fa fa-trash"></i>
			</button>
		</div>
	</div>

	<hr />

	<div class="area-list">

	</div>
</div>


