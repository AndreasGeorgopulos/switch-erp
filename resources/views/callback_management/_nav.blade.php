@php
	$currentRouteName = Route::getFacadeRoot()->current()->getName();
	$buttonLinks = [
		[
			'route' => 'callback_management_index_applicant',
			'title' => trans('Jelöltek'),
		],
		[
			'route' => 'callback_management_index_sales',
			'title' => trans('Sales'),
		],
	];
@endphp

@foreach($buttonLinks as $link)
	<a href="{{url(route($link['route']))}}" class="btn @if($currentRouteName == $link['route']) btn-primary @else btn-default @endif">{{$link['title']}}</a>
@endforeach