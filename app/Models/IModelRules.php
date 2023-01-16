<?php

namespace App\Models;

interface IModelRules
{
	/**
	 * @return array
	 */
	public static function rules(): array;

	/**
	 * @return array
	 */
	public static function niceNames(): array;
}