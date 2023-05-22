@extends('index')
@section('content_header')
    <h1>{{trans('Felhasználó')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
    <form method="post">
        {{csrf_field()}}
        @include('layout.messages')
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{trans('Név')}}</label>
                            <input type="text" name="name" class="form-control" value="{{old('name', $model->name)}}" />
                        </div>
                        <div class="form-group">
                            <label>{{trans('Monogram')}}</label>
                            <input type="text" name="monogram" class="form-control" value="{{old('monogram', $model->monogram)}}" />
                        </div>
                        <div class="form-group">
                            <label>{{trans('E-mail cím')}}</label>
                            <input type="email" class="form-control" name="email" value="{{old('email', $model->email)}}" />
                        </div>
                        <div class="form-group">
                            <label>{{trans('Jelszó')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>{{trans('Jelszó megerősítés')}}</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>{{trans('Aktív')}}</label>
                            <select class="form-control select2" name="active">
                                <option value="1" @if(old('active', $model->active) == 1) selected="selected" @endif>{{trans('Igen')}}</option>
                                <option value="0" @if(old('active', $model->active) == 0) selected="selected" @endif>{{trans('Nem')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{trans('Téma')}}</label>
                            <select name="theme_id" class="form-control select2">
                                <option value="0">{{trans('Alapértelmezett beállítások')}}</option>
                                @foreach(\App\Models\Theme::getDropdownItems($model->theme_id) as $item)
                                    <option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" name="fix_applicants" value="1" @if($model->fix_applicants) checked="checked" @endif /> {{trans('Jelöltek fix')}}</label>
                        </div>
                    </div>

                    <div class="col-md-8">
                        @if(hasRole('admin_roles'))
                            <div class="form-group">
                                <label>{{trans('Jogosultságok')}}</label>
                                <select name="roles[]" class="form-control select2" multiple>
                                    @foreach ($roles as $id => $role)
                                        <option value="{{$id}}" @if($role['enabled']) selected="selected" @endif>{{$role['title']}}</option>
                                    @endforeach
                                </select>
                                <div class="hint">{{trans('A Bejelentkezés és Adatbázis jogosultságok kiválasztása szükséges')}}</div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label>{{trans('Szűrés: pozíciók')}}</label>
                            <select name="job_positions[]" class="form-control select2" multiple>
                                @foreach(\App\Models\JobPosition::getCompanyDropdownItems() as $item)
                                    <option value="{{$item->id}}"
                                            @if(in_array($item->id, $jobPositionIds)) selected="selected" @endif
                                    >{{$item->company->name}} - {{$item->title}}</option>
                                @endforeach
                            </select>
                            <div class="hint">{{trans('Ha nincs egy elem sem kiválasztva, a Keresés modulban az összes cég és pozíció megjelenik.')}}</div>
                        </div>

                        <div class="form-group">
                            <label>{{trans('Szűrés: jelölt csoportok')}}</label>
                            <select name="applicant_groups[]" class="form-control select2" multiple>
                                @foreach(\App\Models\ApplicantGroup::getDropdownItems($applicantGroupIds) as $item)
                                    <option value="{{$item['value']}}" @if($item['selected']) selected="selected" @endif>{{$item['title']}}</option>
                                @endforeach
                            </select>
                            <div class="hint">{{trans('Ha nincs egy elem sem kiválasztva, az Adatbázis modulban az összes jelölt csoport megjelenik.')}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('users_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
                <button type="submit" class="btn btn-primary pull-right">{{trans('Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection