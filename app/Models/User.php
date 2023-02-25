<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    protected $fillable = ['name', 'email', 'active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
	public function job_positions()
	{
		return $this->belongsToMany(JobPosition::class);
	}

	/**
	 * @return BelongsToMany
	 */
	public function applicant_groups()
	{
		return $this->belongsToMany(ApplicantGroup::class);
	}

	/**
	 * @return array|array[]
	 */
	public static function getDropdownItems($selectedIds = [])
	{
		$models = static::select(['id', 'name'])
			->where('active', true)
			/*->whereHas('roles', function ($q) {
				$q->where('roles.key', '<>', 'superadmin');
			})*/
			->orderBy('name', 'asc')
			->get();

		return array_map(function ($item) use($selectedIds) {
			return [
				'value' => $item['id'],
				'title' => $item['name'],
				'selected' => (bool) (in_array($item['id'], $selectedIds)),
			];
		}, collect($models)->toArray());
	}
}
