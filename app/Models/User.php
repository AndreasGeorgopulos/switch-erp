<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'active', 'monogram', 'vacation_days_per_year', 'add_for_new_job_position', 'deletable_from_job_position'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'add_for_new_job_position' => 'boolean',
        'deletable_from_job_position' => 'boolean',
    ];

	/**
	 * @return BelongsToMany
	 */
	public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

	/**
	 * @return BelongsToMany
	 */
	public function job_positions(): BelongsToMany
    {
		return $this->belongsToMany(JobPosition::class);
	}

	/**
	 * @return BelongsToMany
	 */
	public function applicant_groups(): BelongsToMany
    {
		return $this->belongsToMany(ApplicantGroup::class);
	}

	/**
	 * @return HasOne
	 */
	public function theme(): HasOne
	{
		return $this->hasOne(Theme::class, 'id', 'theme_id');
	}

	/**
	 * @return array|array[]
	 */
	public static function getDropdownItems($selectedIds = []): array
    {
		$models = static::select(['id', 'name', 'deletable_from_job_position'])
			->where('active', true)
			/*->whereHas('roles', function ($q) {
				$q->where('roles.key', '<>', 'superadmin');
			})*/
			->orderBy('name', 'asc')
			->get();

        return collect($models)->map(function ($item) use($selectedIds) {
            return [
                'value' => $item['id'],
                'title' => $item['name'],
                'selected' => (bool) (in_array($item['id'], $selectedIds)),
                'deletable_from_job_position' => $item['deletable_from_job_position'],
			];
        })->toArray();
	}

	/**
	 * @return HasMany
	 */
	public function vacations(): HasMany
	{
		return $this->hasMany(Vacation::class, 'user_id', 'id');
	}

	/**
	 * Attribute free_vacation_days
	 *
	 * @return int
	 */
	public function getFreeVacationDaysAttribute(): int
	{
		if (empty($this->vacation_days_per_year)) {
			return 0;
		}

		$days = $this->vacation_days_per_year;
		$vacationModels = $this->vacations()
			->where('status', '<>', Vacation::STATUS_REJECTED)
			->whereYear('begin_date', date('Y'))
			->get();

		$usedDays = $vacationModels->sum('diff_days');
		$days -= $usedDays;

		return $days;
	}

	/**
	 * Attribute used_vacation_days
	 *
	 * @return int
	 */
	public function getUsedVacationDaysAttribute(): int
	{
		if (empty($this->vacation_days_per_year)) {
			return 0;
		}

		return (int) ($this->vacation_days_per_year - $this->free_vacation_days);
	}
}
