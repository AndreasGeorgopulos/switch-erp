<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Applicant management model
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $linked_in
 * @property string $description
 * @property int $experience_year
 * @property string $last_contact_date
 * @property string $last_callback_date
 * @property string $in_english
 * @property string $forwarded_to_companies
 * @property bool $is_subcontractor
 * @property string $graduation
 * @property string $projects
 * @property int $salary
 * @property int $notice_period
 * @property bool $home_office
 * @property string $note
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Applicant extends Model implements IModelRules
{
    use SoftDeletes;

	protected $table = 'applicants';

	protected $fillable = [
		'name',
		'email',
		'phone',
		'linked_in',
		'description',
		'experience_year',
		'last_contact_date',
		'last_callback_date',
		'in_english',
		'forwarded_to_companies',
		'is_subcontractor',
		'graduation',
		'projects',
		'salary',
		'notice_period',
		'home_office',
		'note',
		'is_active'
	];

	protected $casts = [
		'is_subcontractor' => 'boolean',
		'is_active' => 'boolean',
	];

	/**
	 * @return BelongsToMany
	 */
	public function groups()
	{
		return $this->belongsToMany( ApplicantGroup::class );
	}

	public function skills()
	{
		return $this->belongsToMany( Skill::class );
	}

	/**
	 * @return HasOne
	 */
	public function user()
	{
		return $this->hasOne( User::class );
	}

	/**
	 * @return \string[][]
	 */
	public static function rules()
	{
		return [
			'name' => [
				'required',
				'max:100',
			],
			'email' => [
				'required',
				'email',
			],
			'phone' => [
				'required',
				'max:30',
			],
			'linked_in' => [
				'max:255',
			],
			'description' => [
				'max:500',
			],
			'forwarded_to_companies' => [
				'max:500',
			],
			'in_english' => [
				'max:255',
			],
			'experience_year' => [
				'integer',
				'min:1970',
				'max:' . date('Y'),
			],
			'last_contact_date' => [
				'date',
			],
			'last_callback_date' => [
				'date',
			],
			'is_subcontractor' => [
				'boolean',
			],
			'home_office' => [
				'boolean',
			],
			'is_active' => [
				'boolean',
			],
		];
	}

	/**
	 * @return array
	 */
	public static function niceNames()
	{
		return [
			'name' => trans( 'Név' ),
			'email' => trans( 'E-mail cím' ),
			'phone' => trans( 'Telefon' ),
			'linked_in' => trans( 'Linked In' ),
		];
	}
}
