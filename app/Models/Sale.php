<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Sale model
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2023-03-10
 *
 * @property int $id
 * @property int $sort
 * @property string $company_name
 * @property int $status
 * @property string $callback_date
 * @property string $contact
 * @property string $position
 * @property string $phone
 * @property string $email
 * @property string $information
 * @property string $last_contact_date
 * @property string $web
 * @property string $monogram
 */
class Sale extends Model implements IModelRules
{
	use SoftDeletes;

	const STATUS_CONTRACT = 1;
	const STATUS_IN_PROGRESS = 2;
	const STATUS_CALLBACK = 3;
	const STATUS_FINDABLE = 4;
	const STATUS_NO_FIND = 5;

    protected $table = 'sales';

	protected $fillable = [
		'company_name',
		'status',
		'callback_date',
		'contact',
		'position',
		'phone',
		'email',
		'information',
		'last_contact_date',
		'web',
		'monogram',
	];

	/**
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'company_name' => 'required|max:255',
			'contact' => 'max:255|nullable',
			'position' => 'max:255|nullable',
			'phone' => 'max:255|nullable',
			'email' => 'email|nullable',
			'information' => 'max:255|nullable',
			'web' => 'max:255|nullable',
			'callback_date' => 'date|nullable',
			'last_contact_date' => 'date|nullable',
			'sort' => 'numeric|nullable',
			'status' => 'numeric|nullable',
			'monogram' => 'max:4|nullable',
		];
	}

	/**
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'company_name' => trans('Cégnév'),
			'contact' => trans('Kapcsolat'),
			'position' => trans('Pozíció'),
			'phone' => trans('Telefonszám'),
			'email' => trans('E-mail'),
			'information' => trans('Információ'),
			'web' => trans('Weboldal'),
			'callback_date' => trans('Visszahívás dátuma'),
			'last_contact_date' => trans('Utolsó kapcsolat'),
			'status' => trans('Státusz'),
			'monogram' => trans('Intézte'),
		];
	}

	/**
	 * @param int|null $selected
	 * @return array
	 */
	public static function getStatusDropdownOptions(?int $selected): array
	{
		return [
			['value' => self::STATUS_CONTRACT, 'title' => trans('Szerződve'), 'selected' => ((bool) ($selected === self::STATUS_CONTRACT))],
			['value' => self::STATUS_IN_PROGRESS, 'title' => trans('Folyamatban'), 'selected' => ((bool) ($selected === self::STATUS_IN_PROGRESS))],
			['value' => self::STATUS_CALLBACK, 'title' => trans('Visszahívni'), 'selected' => ((bool) ($selected === self::STATUS_CALLBACK))],
			['value' => self::STATUS_FINDABLE, 'title' => trans('Újra kereshető'), 'selected' => ((bool) ($selected === self::STATUS_FINDABLE))],
			['value' => self::STATUS_NO_FIND, 'title' => trans('Nem keressük'), 'selected' => ((bool) ($selected === self::STATUS_NO_FIND))],
		];
	}

	/**
	 * @param string $field
	 * @param $selected
	 * @return array
	 */
	public static function getFilterDropdownOptions(string $field, $selected = null): array
	{
		$models = static::select([$field])
			->groupBy($field)
			->orderBy($field, 'asc')
			->get()
			->toArray();

		return array_map(function ($item) use($field, $selected) {
			return [
				'value' => $item[$field],
				'title' => $item[$field],
				'selected' => (bool) ($item[$field] == $selected),
			];
		}, $models);
	}

	/**
	 * @return Sale[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
	 */
	public static function getCallbackSales()
	{
		return static::where(function ($q) {
				$q->where('callback_date', '<>', '');
				$q->whereNotNull('callback_date');

				if (!hasRole('superadmin') && $monogram = Auth::user()->monogram) {
					$q->where('monogram', $monogram);
				}
			})
			->orderBy('callback_date', 'asc')
			->get();
	}

	/**
	 * @param $date
	 * @return bool
	 */
	public static function hasCallbackSales($date = null): bool
	{
		if ($date === null) {
			$date = date('Y-m-d');
		}

		return (bool) static::getCallbackSales()
			->where('callback_date', $date)
			->count();
	}

	/**
	 * @return void
	 */
	public function setNextSortValue()
	{
		$this->sort = static::count() + 1;
	}

	/**
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [];
	}
}
