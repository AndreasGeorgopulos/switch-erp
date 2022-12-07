<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_length">
            <label>{{trans('Elemek száma oldalanként')}}:
                <select name="length" class="form-control input-sm">
                    @foreach (config('adminlte.paginator.lengths') as $length)
                        <option value="{{$length}}" @if($length == $list->perPage()) selected="selected" @endif>{{$length}}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="input-group pull-right">
            <input type="text" name="searchtext" class="form-control input-sm" placeholder="{{trans('Keresés')}}..." value="{{$searchtext}}" />
            <span class="input-group-btn">
                <button type="submit" name="searchtext" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
</div>