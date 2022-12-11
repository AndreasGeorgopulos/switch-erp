<?php

namespace App\Http\Controllers;

use App\Http\Requests\IFormRequest;
use Illuminate\Http\Request;

/**
 * Interface of administration controllers
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
interface ICrudController
{
	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function index( Request $request );

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function view( int $id );

	/**
	 * @param Request $request
	 * @param int $id
	 * @return mixed
	 */
	public function edit( Request $request, int $id = 0 );

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function delete( int $id );
}