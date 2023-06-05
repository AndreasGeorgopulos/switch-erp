<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Theme extends Model implements IModelRules, IModelDeletable
{
	use SoftDeletes;

    protected $table = 'themes';

	/**
	 * @return HasMany
	 */
	public function users(): HasMany
	{
		return $this->hasMany(User::class, 'theme_id', 'id');
	}

	/**
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		return !(bool) $this->users()->count();
	}

	/**
	 * @return string
	 */
	public function generateCss(): string
	{
		$css = '';
		$data = unserialize($this->data);
		if (empty($data)) {
			return '';
		}

		foreach ($data as $selector => $items) {
			$css .= $selector . '{';
			foreach ($items as $property => $value) {
				$css .= $property . ':' . $value . ' !important;';
			}
			$css .= '}';
		}

		return $css;
	}

	/**
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'name' => 'required|string|min:3|max:255',
		];
	}

	/**
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'name' => trans('Megnevezés'),
		];
	}

	/**
	 * @param $selected
	 * @return array
	 */
	public static function getDropdownItems($selected = null): array
	{
		$models = static::select(['id', 'name'])
			->where(function ($q) {
				$q->where('is_active', 1);
			})
			->orderBy('name')
			->get()
			->toArray();

		return array_map(function ($item) use($selected) {
			return [
				'value' => $item['id'],
				'title' => $item['name'],
				'selected' => (bool) ($item['id'] == $selected),
			];
		}, $models);
	}

	/**
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [];
	}
}
