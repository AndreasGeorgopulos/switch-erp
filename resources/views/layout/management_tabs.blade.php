@php($routeName = Route::getFacadeRoot()->current()->getName())

<ul class="nav nav-tabs" id="management-tabs">
	@if(hasRole('database_module'))
		<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'applicant_management')) active @endif">
			<a href="{{url( route( 'applicant_management_index' ) )}}" class="nav-link">{{trans('Jelöltek')}}</a>
		</li>
	@endif

	@if(hasRole('search_module'))
		<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'search_management')) active @endif">
			<a href="{{url( route( 'search_management_index' ) )}}" class="nav-link">{{trans('Pozíciók')}}</a>
		</li>
	@endif

	@if(hasRole('work_module'))
		<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'work_management')) active @endif">
			<a href="{{url( route( 'work_management_index' ) )}}" class="nav-link">{{trans('Elhelyezések')}}</a>
		</li>
	@endif

	@if(hasRole('contract_module'))
		<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'contract_management')) active @endif">
			<a href="{{url( route( 'contract_management_index' ) )}}" class="nav-link">{{trans('Partnereink')}}</a>
		</li>
	@endif

	@if(hasRole('sales_module'))
		<li class="nav-item @if(\Illuminate\Support\Str::startsWith($routeName, 'sales_management')) active @endif">
			<a href="{{url( route( 'sales_management_index' ) )}}" class="nav-link">{{trans('Sales')}}</a>
		</li>
	@endif

	@if(hasRole('callback_module'))
		@php
		$classes = ['nav-item'];
		if (\App\Models\Applicant::hasCallbackSales() || \App\Models\Sale::hasCallbackSales()) {
			$classes[] = 'alert-call-flicker';
		} elseif (\Illuminate\Support\Str::startsWith($routeName, 'callback_management')) {
			$classes[] = 'active';
		}
		@endphp
		<li class="{{implode(' ', $classes)}}">
			<a href="{{url( route( 'callback_management_index' ) )}}" class="nav-link">{{trans('Visszahívások')}}</a>
		</li>
	@endif
</ul>