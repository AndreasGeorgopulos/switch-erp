@if (session('form_warning_message'))
    <?php $arr = session('form_warning_message'); ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> {{$arr[0]}}</h4>
        <p>{{$arr[1]}}</p>
        @if (isset($errors) && count($errors->all()))
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif

@if (session('form_success_message'))
	<?php $arr = session('form_success_message'); ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{$arr[0]}}</h4>
        <p>{{$arr[1]}}</p>
    </div>
@endif

@if (session('form_info_message'))
	<?php $arr = session('form_info_message'); ?>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> {{$arr[0]}}</h4>
        <p>{{$arr[1]}}</p>
    </div>
@endif

@if (session('form_danger_message'))
	<?php $arr = session('form_danger_message'); ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> {{$arr[0]}}</h4>
        <p>{{$arr[1]}}</p>
    </div>
@endif