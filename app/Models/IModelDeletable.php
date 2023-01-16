<?php

namespace App\Models;

/**
 *
 */
interface IModelDeletable
{
	/**
	 * @return bool
	 */
	public function isDeletable(): bool;
}