<?php

namespace App\Models;

interface IModelRules
{
	/**
	 * @return array
	 */
	public static function rules();

	/**
	 * @return array
	 */
	public static function niceNames();
}