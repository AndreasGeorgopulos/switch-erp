<div class="tab-pane" id="acl_data">
    <p>{{trans('Válassza ki azokat az acl-eket, amelyek ehhez a jogosultsághoz tartoznak.')}}</p>
    <div class="form-group" style="height: 200px; overflow: auto;">
        @foreach ($routes as $acl => $enabled)
        <div class="checkbox">
            <label>
                <input type="checkbox" name="role_acls[]" value="{{$acl}}" @if($enabled) checked="checked" @endif>
                {{trans($acl)}}
            </label>
        </div>
    @endforeach
    </div>
    <div class="clearfix"></div>
</div>