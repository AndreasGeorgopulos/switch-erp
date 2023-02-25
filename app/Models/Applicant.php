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
 * @property string $monogram
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
		'monogram',
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

	public function save(array $options = [])
	{
		$this->salary = str_replace('.', '', $this->salary);
		return parent::save($options); // TODO: Change the autogenerated stub
	}

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

	public function companies()
	{
		return $this->belongsToMany(JobPosition::class, 'applicant_companies', 'applicant_id', 'job_position_id');
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
			'monogram' => [
				'max:4',
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
			'monogram' => trans( 'Intézte' ),
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
			['value' => 0, 'name' => trans('Nincs'), 'selected' => $selected == 0],
			['value' => 1, 'name' => trans('Passzív'), 'selected' => $selected == 1],
			['value' => 2, 'name' => trans('Írás-olvasás'), 'selected' => $selected == 2],
			['value' => 3, 'name' => trans('Társalgási'), 'selected' => $selected == 3],
			['value' => 4, 'name' => trans('Tárgyalási'), 'selected' => $selected == 4],
			['value' => 5, 'name' => trans('Anyanyelvű'), 'selected' => $selected == 5],
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
	 * @param null $applicant_group_id
	 * @return array|array[]
	 */
	public static function getSkillDropdownOptions($selectedIds = [], $applicant_group_id = null)
	{
		$models = Skill::select(['id', 'name'])
			->whereHas('applicants', function ($q) use($applicant_group_id) {
				$q->whereHas('groups', function ($q) use($applicant_group_id) {
					$q->where('id', $applicant_group_id);
				});
			})
			->where('is_active', 1)
			->orderBy('name', 'asc')
			->get()
			->toArray();

		return array_map(function ($skill) use ($selectedIds) {
			return [
				'id' => $skill['id'],
				'name' => $skill['name'],
				'selected' => in_array($skill['id'], $selectedIds),
			];
		}, $models);
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
			trans('Online kurzus'),
			trans('Bootcamp'),
			trans('OKJ'),
			trans('Főiskola'),
			trans('Egyetem'),
		];
	}

	public static function getNameDropdownOptions($selectedGroupId)
	{
		return static::select(['id', 'name'])->join('applicant_applicant_group', 'applicant_applicant_group.applicant_id', '=', 'applicants.id', 'inner')->where(function ($q) use($selectedGroupId) {
			$q->where('is_active', true);
			$q->where('applicant_applicant_group.applicant_group_id', '=', $selectedGroupId);
		})->orderBy('name', 'asc')->get()->toArray();

		/*return static::with('groups')->where(function ($q) use($selectedGroupId) {
			$q->where('is_active', true);
			//$q;
		})->whereHas('groups', function ($q) use($selectedGroupId) {
			$q->where('applicant_groups.id', '=', $selectedGroupId);
		})->orderBy('name', 'asc')->get()->toArray();*/
	}
}
