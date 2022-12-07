@foreach (config('app.languages') as $lang)
	<?php $translate = $model->translates()->where('language_code', $lang)->first(); ?>
    <div class="tab-pane" id="{{$lang}}_data">
        <div class="form-group col-md-6">
            <label>{{trans('Cím')}}</label>
            <input type="text" name="translate[{{$lang}}][meta_title]" class="form-control" value="{{old('meta_title', !empty($translate->meta_title) ? $translate->meta_title : '')}}" />
        </div>

        <div class="form-group col-md-6">
            <label>{{trans('Url slug')}}</label>
            <input type="text" name="translate[{{$lang}}][slug]" class="form-control" value="{{old('slug', !empty($translate->slug) ? $translate->slug : '')}}" />
        </div>

        <div class="form-group col-md-12">
            <label>{{trans('Bevezető szöveg')}}</label>
            <textarea name="translate[{{$lang}}][lead]" class="form-control wysig">{{old('lead', !empty($translate->lead) ? $translate->lead : '')}}</textarea>
        </div>

        <div class="form-group col-md-12">
            <label>{{trans('Szövegtörzs')}}</label>
            <textarea name="translate[{{$lang}}][body]" class="form-control wysig">{{old('body', !empty($translate->body) ? $translate->body : '')}}</textarea>
        </div>

        <div class="form-group col-md-6">
            <label>{{trans('Meta description')}}</label>
            <textarea name="translate[{{$lang}}][meta_description]" class="form-control">{{old('meta_description', !empty($translate->meta_description) ? $translate->meta_description : '')}}</textarea>
        </div>

        <div class="form-group col-md-6">
            <label>{{trans('Meta keywords')}}</label>
            <textarea name="translate[{{$lang}}][meta_keywords]" class="form-control">{{old('meta_keywords', !empty($translate->meta_keywords) ? $translate->meta_keywords : '')}}</textarea>
        </div>




        <div class="clearfix"></div>
    </div>
@endforeach