<?php

namespace App\Models;

/**
 *
 */
interface IModelSortable
{
	/**
	 * @param int $applicantGroupId
	 * @return void
	 */
	public function setNextSortValue(int $applicantGroupId);
}