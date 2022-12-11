<?php

namespace App\Http\Controllers;

use App\Http\Requests\IFormRequest;
use Illuminate\Http\Request;

interface ICrudController
{
	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function index ( Request $request );

	/**
	 * @param Request $request
	 * @param int $id
	 * @return mixed
	 */
	public function edit ( Request $request, int $id = 0 );

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function delete ( int $id );
}