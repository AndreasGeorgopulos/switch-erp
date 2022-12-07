@extends('index')
@section('content_header')
    <h1>{{trans('Tartalom')}}: @if($model->id) {{$model->title}} [{{$model->id}}] @else {{trans('Új')}} @endif</h1>
@stop

@section('content')
    <form method="post">
        {{csrf_field()}}
        @include('layout.messages')
        <div class="box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general_data" data-toggle="tab" aria-expanded="true">{{trans('Általános adatok')}}</a></li>

                    @foreach (config('app.languages') as $lang)
                        <li class=""><a href="#{{$lang}}_data" data-toggle="tab" aria-expanded="false">{{trans('' . $lang)}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @include('contents.tab_general')
                    @include('contents.tab_translates')
                </div>
            </div>

            <div class="box-footer">
                <a href="{{url(route('contents_list'))}}" class="btn btn-default">{{trans('Vissza')}}</a>
                <button type="submit" class="btn btn-info pull-right">{{trans('Mentés')}}</button>
            </div>
        </div>
    </form>
@endsection

@section('adminlte_js')
    <script type="text/javascript">
        $('textarea.wysig').wysihtml5();
    </script>
@endsection