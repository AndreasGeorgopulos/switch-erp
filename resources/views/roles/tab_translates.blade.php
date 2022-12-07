@foreach (config('app.languages') as $lang)
	<?php $translate = $model->translates()->where('language_code', $lang)->first(); ?>
    <div class="tab-pane" id="{{$lang}}_data">
        <div class="col-md-12">
            <h2></h2>
            <div class="form-group">
                <label>{{trans('Név')}}</label>
                <input type="text" name="translate[{{$lang}}][name]" class="form-control" value="{{old('key', !empty($translate->name) ? $translate->name : '')}}" />
            </div>
            <div class="form-group">
                <label>{{trans('Leírás')}}</label>
                <textarea name="translate[{{$lang}}][description]" class="form-control">{{old('key', !empty($translate->description) ? $translate->description : '')}}</textarea>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endforeach