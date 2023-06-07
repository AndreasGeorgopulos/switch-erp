<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Vacation model
 *
 * @property int $user_id
 * @property string $begin_date
 * @property string $end_date
 * @property string $notice
 * @property int $status
 */
class Vacation extends Model implements IModelDeletable, IModelRules, IModelEditable
{
	use SoftDeletes;

	const STATUS_REQUESTED = 1;
	const STATUS_APPROVED = 2;
	const STATUS_REJECTED = 3;

	protected $table = 'vacations';

	protected $fillable = ['begin_date', 'end_date', 'notice'];

	/**
	 * Define the "user" relationship.
	 *
	 * @return HasOne
	 */
	public function user(): HasOne
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	/**
	 * Get the difference in days between begin_date and end_date except weekend days.
	 *
	 * @return int
	 */
	public function getDiffDaysAttribute(): int
	{
		$beginDate = Carbon::parse($this->begin_date);
		$endDate = Carbon::parse($this->end_date)->addDay();

		$diffDays = $endDate->diffInDays($beginDate);

		$weekendDays = 0;
		for ($i = 0; $i < $diffDays; $i++) {
			$date = $beginDate->copy()->addDays($i);
			if ($date->isWeekend()) {
				$weekendDays++;
			}
		}

		return (int) $diffDays - $weekendDays;
	}

	/**
	 * Get the title for the vacation status.
	 *
	 * @return string
	 */
	public function getStatusTitleAttribute(): string
	{
		$statusTitles = [
			static::STATUS_REQUESTED => trans('Elbírálásra vár'),
			static::STATUS_APPROVED => trans('Elfogadva'),
			static::STATUS_REJECTED => trans('Elutasítva'),
		];

		return $statusTitles[$this->status] ?? '';
	}

	/**
	 * @return bool
	 */
	public function isEditable(): bool
	{
		$notExpired = $this->begin_date > Carbon::now()->format('Y-m-d');
		$isNotApproved = $this->status === self::STATUS_REQUESTED;

		return $notExpired && $isNotApproved;
	}

	/**
	 * Check if the vacation is deletable.
	 *
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		$notExpired = $this->begin_date > Carbon::now()->format('Y-m-d');
		$isNotApproved = $this->status !== self::STATUS_APPROVED;

		return $notExpired && $isNotApproved;
	}

	/**
	 * Get the validation rules for the model.
	 *
	 * @return array
	 */
	public static function rules(): array
	{
		return [
			'begin_date' => 'required|date|after:' . Carbon::now()->format('Y-m-d'),
			'end_date' => ['required', 'date', 'after_or_equal:begin_date'],
			'notice' => 'required|min:3|max:255',
		];
	}

	/**
	 * Get the attribute names for validation rules.
	 *
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'begin_date' => 'Begin vacation date',
			'end_date' => 'End vacation date',
			'notice' => 'Notice',
			'status' => 'Status',
		];
	}

	/**
	 * @return array
	 */
	public static function customMessages(): array
	{
		return [
			'begin_date.required' => trans('A szabadság kezdő dátumának megadása kötelező.'),
			'begin_date.date' => trans('A szabadság kezdő dátumának formátuma nem megfelelő.'),
			'begin_date.after' => trans('A szabadság kezdete legkorábban holnapkezdődhet.'),
			'end_date.required' => 'A szabadság befejező dátumának megadása kötelező.',
			'end_date.date' => 'A szabadság befejező dátumának formátuma nem megfelelő.',
			'end_date.after_or_equal' => 'A szabadság befejező dátumának azonosnak vagy későbbinek kell lennie, mint a megadott kezdő dátum.',
			'notice.required' => 'A megjegyzés rovat kitöltendő.',
			'notice.min' => 'A megjegyzés rovat minimum 3 karakter legyen.',
			'notice.max' => 'A megjegyzés rovat maximum 255 karakter lehet.',
		];
	}
}