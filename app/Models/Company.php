<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;

/**
 * Company model
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-28
 *
 * @property int $id
 * @property string $name
 * @property double $success_award
 * @property string $payment_deadline
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $contract_file
 * @property string $contract_file_mime_type
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Company extends Model implements IModelRules, IModelDeletable
{
	use SoftDeletes;

	const STORAGE_PATH = 'app/public/contracts';

	protected $table = 'companies';

	protected $fillable = [
		'name',
		'success_award',
		'payment_deadline',
		'contact_name',
		'contact_email',
		'contact_phone',
		'is_active',
	];

	protected $casts = [
		'is_active' => 'boolean',
	];

	/**
	 * @return HasMany
	 */
	public function job_positions(): HasMany
	{
		return $this->hasMany(JobPosition::class, 'company_id', 'id');
	}

	/**
	 * @return bool
	 */
	public function hasContract(): bool
	{
		$path = storage_path( static::STORAGE_PATH ) . '/' . $this->contract_file;
		if ( empty( $this->contract_file ) || !file_exists( $path ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @return string|null
	 */
	public function getContractPath(): ?string
	{
		return $this->hasContract() ? ( storage_path( static::STORAGE_PATH ) . '/' . $this->contract_file ) : null;
	}

	/**
	 * @param UploadedFile $file
	 * @return void
	 * @throws Exception
	 */
	public function uploadContract( UploadedFile $file )
	{
		$path = storage_path( static::STORAGE_PATH );
		if ( !file_exists( $path) ) {
			mkdir( $path, 0775, true );
		}

		$this->contract_file = $this->id . '-' . $file->getClientOriginalName();
		$this->contract_file_mime_type = $file->getClientMimeType();

		$file->move( $path, $this->contract_file );
		if ( !file_exists( $path . '/' . $this->contract_file ) ) {
			throw new Exception( trans('A szerződés feltöltése sikertelen. Kérjük, ellenőrizze a file írási jogosultságokat!') );
		}
		chmod($path . '/' . $this->contract_file, 0775);
		$this->save();
	}

	/**
	 * @return void
	 */
	public function deleteContract()
	{
		if ( $path = $this->getContractPath() ) {
			unlink( $path );
		}
		$this->contract_file = null;
		$this->contract_file_mime_type = null;
		$this->save();
	}

	/**
	 * @return array[]
	 */
	public static function rules(): array
	{
		return [
			'name' => [
				'required',
				'max:100',
			],
			'success_award' => [
				'required',
				'numeric',
			],
			'payment_deadline' => [
				'required',
				'numeric',
			],
			'contact_name' => [
				'required',
				'max:100',
			],
			'contact_email' => [
				'required',
				'email',
			],
			'contact_phone' => [
				'required',
				'regex:' . config('app.input_formats.phone_number'),
			],
			'is_active' => [
				'boolean',
			],
		];
	}

	/**
	 * @return array
	 */
	public static function niceNames(): array
	{
		return [
			'name' => trans( 'Név' ),
			'success_award' => trans( 'Sikerdíj mértéke' ),
			'payment_deadline' => trans( 'Fizetési határidő' ),
			'contact_name' => trans( 'Kapcsolattartó' ),
			'contact_email' => trans( 'E-mail' ),
			'contact_phone' => trans( 'Telefon' ),
		];
	}

	/**
	 * @param int|null $selected
	 * @param bool $onlyHasJobPositions
	 * @return array|array[]
	 */
	public static function getDropdownItems( int $selected = null, bool $onlyHasJobPositions = false ): array
	{
		$models = static::select(['id', 'name'])
			->where(function ($q) use($onlyHasJobPositions) {
				$q->where('is_active', 1);
			})
			->orderBy('name', 'asc')
			->get()
			->toArray();

		return array_map(function ($item) use($selected) {
			return [
				'value' => $item['id'],
				'title' => $item['name'],
				'selected' => $item['id'] == $selected,
			];
		}, $models);
	}

	/**
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		return (bool) !$this->job_positions()->count();
	}

	/**
	 * @return bool|null
	 * @throws Exception
	 */
	public function delete(): ?bool
	{
		if (!$this->isDeletable()) {
			return false;
		}
		return parent::delete();
	}
}