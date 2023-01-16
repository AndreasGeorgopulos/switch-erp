@php($routeName = Route::getFacadeRoot()->current()->getName())

<ul class="nav nav-tabs" id="management-tabs">
	<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'applicant_management')) active @endif">
		<a href="{{url( route( 'applicant_management_index' ) )}}" class="nav-link">{{trans('Adatbázis')}}</a>
	</li>
	<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'search_management')) active @endif">
		<a href="{{url( route( 'search_management_index' ) )}}" class="nav-link">{{trans('Keresés')}}</a>
	</li>
	<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'contract_management')) active @endif">
		<a href="{{url( route( 'contract_management_index' ) )}}" class="nav-link">{{trans('Szerződések')}}</a>
	</li>
	<li class="nav-item disabled">
		<a href="#" class="nav-link">{{trans('Sales')}}</a>
	</li>
</ul>

@include('../layout/messages')