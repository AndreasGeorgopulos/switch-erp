<?php

return [
	'groups' => [
		[
			'title' => 'Fejléc',
			'items' => [
				[
					'title' => 'Háttérszín',
					'css_selector' => '.main-header .navbar, .main-header .navbar-custom-menu, .main-header .dropdown, .main-header .dropdown li, .main-header .dropdown li a, .main-header .dropdown-menu',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#0010E5',
				],
				[
					'title' => 'Betűszín',
					'css_selector' => '.main-header .navbar a, .main-header .navbar-custom-menu a',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#FFFFFF',
				],
			],
		],
		[
			'title' => 'Munkaterület',
			'items' => [
				[
					'title' => 'Alapértelmezett háttérszín',
					'css_selector' => '.content-wrapper, .content-wrapper .box, .content-wrapper a, .content-wrapper table th,  .content-wrapper table td',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#ECF0F5',
				],
				[
					'title' => 'Alapértelmezett betűszín',
					'css_selector' => '.content-wrapper, .content-wrapper .box, .content-wrapper a, .content-wrapper table th,  .content-wrapper table td',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
				[
					'title' => 'Beviteli mezők háttérszíne',
					'css_selector' => '.content-wrapper input, .content-wrapper select, .content-wrapper textarea',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#FFFFFF',
				],
				[
					'title' => 'Beviteli mezők betűszíne',
					'css_selector' => '.content-wrapper input, .content-wrapper select, .content-wrapper textarea',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
				[
					'title' => 'Footer toolbar-ok háttérszíne',
					'css_selector' => '.content-wrapper .box-footer, .content-wrapper .foot-toolbar',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#ECF0F5',
				],
				[
					'title' => 'Footer toolbar-ok betűszíne',
					'css_selector' => '.content-wrapper .box-footer, .content-wrapper .foot-toolbar',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
				[
					'title' => 'Visszahívás figyelmeztető háttérszíne',
					'css_selector' => '.alert-call-flicker, li.alert-call-flicker a',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#FFFF8F',
				],
				[
					'title' => 'Visszahívás figyelmeztető betűszíne',
					'css_selector' => '.alert-call-flicker, li.alert-call-flicker a',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
			],
		],
		[
			'title' => 'Táblázatok',
			'items' => [
				[
					'title' => 'Fejléc háttérszíne',
					'css_selector' => '.table-striped thead tr th',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#ECF0F5',
				],
				[
					'title' => 'Fejléc betűszíne',
					'css_selector' => '.table-striped thead tr th',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
				[
					'title' => 'Fejléc keretszíne',
					'css_selector' => '.table-striped thead tr th',
					'property' => 'border-color',
					'input_type' => 'color',
					'default_value' => '#F4F4F4',
				],
				[
					'title' => 'Páros sorok háttérszíne',
					'css_selector' => '.table-striped tbody tr:nth-of-type(even) td',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#F9F9F9',
				],
				[
					'title' => 'Páros sorok betűszíne',
					'css_selector' => '.table-striped tbody tr:nth-of-type(even) td',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
				[
					'title' => 'Páratlan sorok háttérszíne',
					'css_selector' => '.table-striped tbody tr:nth-of-type(odd) td',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#FFFFFF',
				],
				[
					'title' => 'Páratlan sorok betűszíne',
					'css_selector' => '.table-striped tbody tr:nth-of-type(odd) td',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
				[
					'title' => 'Keretszín',
					'css_selector' => '.table-striped tbody tr td',
					'property' => 'border-color',
					'input_type' => 'color',
					'default_value' => '#F4F4F4',
				],
			],
		],
		[
			'title' => 'Bootstrap default gombok (általános jellegű gombok, alapértelmezett szürke)',
			'items' => [
				[
					'title' => 'Háttérszín',
					'css_selector' => '.content-wrapper .btn.btn-default',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#E7E7E7',
				],
				[
					'title' => 'Betűszín',
					'css_selector' => '.content-wrapper .btn.btn-default',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
			],
		],
		[
			'title' => 'Bootstrap primary gombok (mentés gombok, alapértelmezett kék)',
			'items' => [
				[
					'title' => 'Háttérszín',
					'css_selector' => '.content-wrapper .btn.btn-primary',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#367FA9',
				],
				[
					'title' => 'Betűszín',
					'css_selector' => '.content-wrapper .btn.btn-primary',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#ffffff',
				],
			],
		],
		[
			'title' => 'Bootstrap success gombok (mentés gombok, alapértelmezett zöld)',
			'items' => [
				[
					'title' => 'Háttérszín',
					'css_selector' => '.content-wrapper .btn.btn-success',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#008D4C',
				],
				[
					'title' => 'Betűszín',
					'css_selector' => '.content-wrapper .btn.btn-success',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#ffffff',
				],
			],
		],
		[
			'title' => 'Bootstrap secondary gombok (cv gombok, alapértelmezett átlátszó)',
			'items' => [
				[
					'title' => 'Háttérszín',
					'css_selector' => '.content-wrapper .btn.btn-secondary',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#ffffff',
				],
				[
					'title' => 'Betűszín',
					'css_selector' => '.content-wrapper .btn.btn-secondary',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#000000',
				],
			],
		],
		[
			'title' => 'Bootstrap danger gombok (törlés gombok, alapértelmezett piros)',
			'items' => [
				[
					'title' => 'Háttérszín',
					'css_selector' => '.content-wrapper .btn.btn-danger',
					'property' => 'background-color',
					'input_type' => 'color',
					'default_value' => '#DD4B39',
				],
				[
					'title' => 'Betűszín',
					'css_selector' => '.content-wrapper .btn.btn-danger',
					'property' => 'color',
					'input_type' => 'color',
					'default_value' => '#ffffff',
				],
			],
		],
	],
];