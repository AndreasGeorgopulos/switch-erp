<?php

namespace App\Models;

/**
 *
 */
interface IModelEditable
{
	/**
	 * @return bool
	 */
	public function isEditable(): bool;
}