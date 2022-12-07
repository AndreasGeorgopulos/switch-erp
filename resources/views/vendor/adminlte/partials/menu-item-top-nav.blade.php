@if (is_array($item))
	<?php
	$can = true;
	if (isset($item['role']) && !Auth::user()->roles()->where('key', $item['role'])->first()) {
		if (!Auth::user()->roles()->where('key', 'superadmin')->first()) {
			$can = false;
		}
	}
	?>
    @if ($can)
        <li class="{{ $item['top_nav_class'] }}">
            <a href="{{ !empty($item['route']) ? url(route($item['route'])) : '#' }}"
               @if (isset($item['submenu'])) class="dropdown-toggle" data-toggle="dropdown" @endif
               @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
            >
                <i class="fa fa-fw fa-{{ $item['icon'] or 'circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
                {{ trans($item['text']) }}
                @if (isset($item['label']))
                    <span class="label label-{{ $item['label_color'] or 'primary' }}">{{ $item['label'] }}</span>
                @elseif (isset($item['submenu']))
                    <span class="caret"></span>
                @endif
            </a>
            @if (isset($item['submenu']))
                <ul class="dropdown-menu" role="menu">
                    @foreach($item['submenu'] as $subitem)
						<?php
						$can = true;
						if (isset($subitem['role']) && !Auth::user()->roles()->where('key', $subitem['role'])->first()) {
							if (!Auth::user()->roles()->where('key', 'superadmin')->first()) {
								$can = false;
							}
						}
						?>
                        @if ($can)
                            @if (is_string($subitem))
                                @if($subitem == '-')
                                    <li role="separator" class="divider"></li>
                                @else
                                    <li class="dropdown-header">{{ $subitem }}</li>
                                @endif
                            @else
                            <li class="{{ $subitem['top_nav_class'] }}">
                                <a href="{{ !empty($item['route']) ? url(route($item['route'])) : '#' }}">
                                    <i class="fa fa-{{ $subitem['icon'] or 'circle-o' }} {{ isset($subitem['icon_color']) ? 'text-' . $subitem['icon_color'] : '' }}"></i>
                                    {{ trans($subitem['text']) }}
                                    @if (isset($subitem['label']))
                                        <span class="label label-{{ $subitem['label_color'] or 'primary' }}">{{ $subitem['label'] }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endif
