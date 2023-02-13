<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;

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
 * @property int $salary
 * @property int $notice_period
 * @property bool $home_office
 * @property string $note
 * @property string $report
 * @property string $cv_file
 * @property string $cv_file_mime_type
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Applicant extends Model implements IModelRules
{
    use SoftDeletes;

	const STORAGE_PATH = 'app/public/cv';

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
		'salary',
		'notice_period',
		'home_office',
		'note',
		'report',
		'is_active',
	];

	protected $casts = [
		'home_office' => 'boolean',
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

	/**
	 * @return BelongsToMany
	 */
	public function skills()
	{
		return $this->belongsToMany( Skill::class );
	}

	/**
	 * @return BelongsToMany
	 */
	public function job_positions()
	{
		return $this->belongsToMany( JobPosition::class );
	}

	/**
	 * @return HasOne
	 */
	public function user()
	{
		return $this->hasOne( User::class );
	}

	/**
	 * @return bool
	 */
	public function hasCV()
	{
		$path = storage_path( static::STORAGE_PATH ) . '/' . $this->cv_file;
		if ( empty( $this->cv_file ) || !file_exists( $path ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @return string|null
	 */
	public function getCVPath()
	{
		return $this->hasCV() ? ( storage_path( static::STORAGE_PATH ) . '/' . $this->cv_file ) : null;
	}

	/**
	 * @param UploadedFile $file
	 * @return void
	 * @throws Exception
	 */
	public function uploadCV(UploadedFile $file )
	{
		$path = storage_path( static::STORAGE_PATH );
		if ( !file_exists( $path) ) {
			mkdir( $path, 0775, true );
		}

		$this->cv_file = $this->id . '-' . $file->getClientOriginalName();
		$this->cv_file_mime_type = $file->getClientMimeType();

		$file->move( $path, $this->cv_file );
		if ( !file_exists( $path . '/' . $this->cv_file ) ) {
			throw new Exception( trans('Az önéletrajz feltöltése sikertelen. Kérjük, ellenőrizze a file írási jogosultságokat!') );
		}
		chmod($path . '/' . $this->cv_file, 0775);
		$this->save();
	}

	/**
	 * @return void
	 */
	public function deleteCV()
	{
		if ( $path = $this->getCVPath() ) {
			unlink( $path );
		}
		$this->cv_file = null;
		$this->cv_file_mime_type = null;
		$this->save();
	}

	/**
	 * @return \string[][]
	 */
	public static function rules() :array
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
				'regex:' . config('app.input_formats.phone_number'),
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
	public static function niceNames() :array
	{
		return [
			'name' => trans( 'Név' ),
			'email' => trans( 'E-mail cím' ),
			'phone' => trans( 'Telefon' ),
			'linked_in' => trans( 'Linked In' ),
			'experience_year' => trans( 'Tapasztalat' ),
			'last_contact_date' => trans( 'Utolsó kapcsolat' ),
			'last_callback_date' => trans( 'Visszahívás' ),
		];
	}

	/**
	 * Dropdown options of english language level
	 *
	 * @param int $selected
	 * @return array[]
	 */
	public static function getInEnglishDropdownOptions($selected = null)
	{
		return [
			['value' => 0, 'name' => '', 'selected' => $selected == 0],
			['value' => 4, 'name' => trans('Passzív'), 'selected' => $selected == 4],
			['value' => 1, 'name' => trans('Alapfok'), 'selected' => $selected == 1],
			['value' => 2, 'name' => trans('Középfok'), 'selected' => $selected == 2],
			['value' => 3, 'name' => trans('Felsőfok'), 'selected' => $selected == 3],
		];
	}

	/**
	 * Dropdown options of subcontractor status
	 *
	 * @param int $selected
	 * @return array[]
	 */
	public static function getIsSubcontractorDropdownOptions($selected = null)
	{
		return [
			['value' => 0, 'name' => trans('Alkalmazott'), 'selected' => $selected == 0],
			['value' => 1, 'name' => trans('Alvállalkozó'), 'selected' => $selected == 1],
		];
	}

	/**
	 * Dropdown options of skills
	 *
	 * @param array $selectedIds
	 * @return array|array[]
	 */
	public static function getSkillDropdownOptions($selectedIds = [])
	{
		return array_map(function ($skill) use ($selectedIds) {
			return [
				'name' => $skill['name'],
				'selected' => in_array($skill['id'], $selectedIds),
			];
		}, Skill::select(['id', 'name'])->where('is_active', 1)->get()->toArray());
	}

	/**
	 * Dropdown options of graduations
	 *
	 * @return array
	 */
	public static function getGraduationDropdownOptions()
	{
		return [
			trans('Nincs'),
			trans('OKJ'),
			trans('Főiskola'),
			trans('Egyetem'),
		];
	}
}
