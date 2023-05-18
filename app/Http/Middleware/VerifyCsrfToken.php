<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
	protected $except = [
		'adminer',
		'search_management/save_data',
		'work_management/save_data',
		'applicant_management/set-is-marked',
	];
}
