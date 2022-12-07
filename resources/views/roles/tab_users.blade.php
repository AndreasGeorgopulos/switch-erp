<div class="tab-pane" id="user_data">
    <div class="form-group">
        <p>{{trans('Válassza ki ctrl+bal egérgomb segítségével azokat a felhasználókat, akik ehhez a jogosultsághoz tartoznak.')}}</p>
        <select multiple="true" name="role_users[]" class="form-control" style="height: 200px;">
            @foreach ($users as $u)
                <option value="{{$u->id}}" @if($u->roles()->where('role_id', $model->id)->first()) selected="selected" @endif>{{$u->name}} [{{$u->id}}]</option>
            @endforeach
        </select>
    </div>

    <div class="clearfix"></div>
</div>