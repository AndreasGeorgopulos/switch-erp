<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Switch IT ERP',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>SWITCH IT</b> ERP',

    'logo_mini' => '<b>A</b>LT',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'switch-blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => true,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/',
    'logout_url' => 'logout',
    'logout_method' => null,
    'login_url' => 'login',
    'register_url' => '/register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */
	
	'menu' => [
		'FŐMENÜ',
		[
			'text' => 'Menedzsment',
			'route' => 'applicant_management_index',
			'role' => 'login',
			'icon' => 'user',
			'active' => ['admin'],
		],
		[
			'text' => 'Profilom',
			'route' => 'users_profile',
			'role' => 'login',
			'icon' => 'user-o',
			'active' => ['users_profile'],
		],
		[
			'text'    => 'Adminsztráció',
			'icon'    => 'cog',
			'submenu' => [
				[
					'text' => 'Jelöltek',
					'route' => 'applicants_list',
					'role' => 'admin_applicants',
					'active' => ['applicants/*'],
				],
				[
					'text' => 'Jelölt csoportok',
					'route' => 'applicant_groups_list',
					'role' => 'admin_applicant_groups',
					'active' => ['applicant_groups/*'],
				],
				[
					'text' => 'Technológiák, készségek',
					'route' => 'skills_list',
					'role' => 'admin_skills',
					'active' => ['skills/*'],
				],
				[
					'text' => 'Cégek',
					'route' => 'companies_list',
					'role' => 'admin_companies',
					'active' => ['companies/*'],
				],
				[
					'text' => 'Pozíciók',
					'route' => 'job_positions_list',
					'role' => 'admin_job_positions',
					'active' => ['job_positions/*'],
				],
				[
					'text' => 'Felhasználók',
					'route' => 'users_list',
					'role' => 'admin_users',
					'active' => ['users/*'],
				],
				[
					'text' => 'Jogosultságok',
					'route' => 'roles_list',
					'role' => 'admin_roles',
					'active' => ['roles/*'],
				],
			],
		],
		/*[
			'text' => 'Fordítások',
			'route' => 'translation_getindex',
			'role' => 'translates',
			'icon' => 'language',
			'active' => ['translation/*'],
		],
		'NYELV VÁLASZTÁS',*/
		
	],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
		'wysihtml5' => true,
    ],'paginator' => [
		'default_length' => 50,
		'lengths' => [10, 25, 50, 100]
	]
	

];
