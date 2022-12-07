@extends('index')
@section('content_header')
    <h1>{{trans('Felhasználó')}}: @if($model->id) {{$model->name}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
    <form method="post">
        {{csrf_field()}}
        @include('layout.messages')
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach ($tabs as $index => $tab)
                        <li class="@if(!$index) active @endif"><a href="#{{$tab['href']}}" data-toggle="tab" aria-expanded="true">{{$tab['title']}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($tabs as $index => $tab)
                        <div class="tab-pane @if(!$index) active @endif" id="{{$tab['href']}}">
                            @include($tab['include'])
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('users_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection