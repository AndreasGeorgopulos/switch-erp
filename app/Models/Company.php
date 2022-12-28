<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
 * @property string $contract_file
 * @property string $contract_file_mime_type
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Company extends Model implements IModelRules
{
	use SoftDeletes;

	const STORAGE_PATH = 'app/public/contracts';

	protected $table = 'companies';

	protected $fillable = ['name', 'is_active'];

	protected $casts = [
		'is_active' => 'boolean',
	];

	/**
	 * @return bool
	 */
	public function hasContract()
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
	public function getContractPath()
	{
		return $this->hasContract() ? ( storage_path( static::STORAGE_PATH ) . '/' . $this->contract_file ) : null;
	}

	/**
	 * @param UploadedFile $file
	 * @return void
	 * @throws Exception
	 */
	public function uploadContract(UploadedFile $file )
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
	public static function rules()
	{
		return [
			'name' => [
				'required',
				'max:100',
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
		];
	}

	/**
	 * @param int $selected
	 * @return array|array[]
	 */
	public static function getDropdownItems($selected = null)
	{
		return array_map(function ($item) use($selected) {
			return [
				'value' => $item->id,
				'name' => $item->name,
				'selected' => $item->id == $selected,
			];
		}, static::select(['id', 'name'])->where('is_active', 1)->get());
	}
}
