<?php

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
	private $data = [
		'filename' => 'sales.csv',
		'columnIndexes' => [
			'company_name' => 1,
	        'callback_date' => 3,
	        'contact' => 4,
	        'position' => 5,
	        'phone' => 6,
	        'email' => 10,
	        'information' => 8,
	        'last_contact_date' => 7,
	        'web' => 9,
		],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    if (!($fp = fopen(database_path('seeds/data/') . $this->data['filename'], 'r'))) {
		    return;
	    }

	    $i = 0;
	    while($row = fgetcsv($fp, 0, ';')) {
		    if (!$i++ || empty($row[$this->data['columnIndexes']['company_name']])) {
			    continue;
		    }

			$model = new Sale();
			foreach ($this->data['columnIndexes'] as $field => $index) {
				$model->$field = !empty(trim($row[$index])) ? $row[$index] : null;
			}
			$model->save();
	    }

		fclose($fp);
    }
}
