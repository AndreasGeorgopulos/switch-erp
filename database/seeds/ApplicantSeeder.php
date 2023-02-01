<?php

use App\Models\Applicant;
use App\Models\Company;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApplicantSeeder extends Seeder
{
	const EMAIL_PATTERN = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";

	private $data = [
		[
			'group_id' => 1,
			'filename' => '01_adatbazis_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 10,
				'email' => 11,
				'in_english' => 2,
				'experience_year' => 4,
				'linked_in' => 12,
				'description' => 8,
				'last_contact_date' => 5,
				'last_callback_date' => 7,
				'technologies' => 1,
				'companies' => 6,
			],
		],
		[
			'group_id' => 2,
			'filename' => '02_adatbazis_uzemeltetok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 8,
				'email' => 9,
				'in_english' => 2,
				'experience_year' => 3,
				'linked_in' => 10,
				'description' => 6,
				'last_contact_date' => 4,
				'last_callback_date' => 5,
				'technologies' => 1,
				'companies' => 5,
			],
		],
		[
			'group_id' => 3,
			'filename' => '03_adattarhaz_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 1,
				'email' => 2,
				'in_english' => 3,
				'experience_year' => 4,
				'linked_in' => 10,
				'description' => 8,
				'last_contact_date' => 6,
				'companies' => 7,
			],
		],
		[
			'group_id' => 5,
			'filename' => '05_android_ios_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 10,
				'email' => 11,
				'in_english' => 5,
				'experience_year' => 6,
				'linked_in' => 12,
				'description' => 8,
				'last_contact_date' => 2,
				'last_callback_date' => 5,
				'technologies' => 1,
				'companies' => 7,
			],
		],
		[
			'group_id' => 6,
			'filename' => '06_asszisztensek.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 8,
				'email' => 9,
				'in_english' => 2,
				'experience_year' => 3,
				'linked_in' => 10,
				'description' => 5,
				'last_contact_date' => 6,
				//'last_callback_date' => 5,
				'technologies' => 1,
				'companies' => 4,
			],
		],
		[
			'group_id' => 9,
			'filename' => '09_c_sharp_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 12,
				'email' => 13,
				'in_english' => 4,
				'experience_year' => 6,
				'linked_in' => 14,
				'description' => 10,
				'last_contact_date' => 8,
				//'last_callback_date' => 5,
				//'technologies' => 1,
				'companies' => 9,
			],
		],
		[
			'group_id' => 10,
			'filename' => '10_cpp_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 10,
				'email' => 11,
				'in_english' => 4,
				'experience_year' => 2,
				'linked_in' => 12,
				'description' => 8,
				'last_contact_date' => 6,
				//'last_callback_date' => 6,
				//'technologies' => 1,
				'companies' => 7,
			],
		],
		[
			'group_id' => 11,
			'filename' => '11_content_manager.csv',
			'columnIndexes' => [
				'name' => 0,
				//'phone' => 10,
				'email' => 8,
				'in_english' => 2,
				'experience_year' => 3,
				//'linked_in' => 12,
				'description' => 6,
				'last_contact_date' => 4,
				//'last_callback_date' => 6,
				//'technologies' => 1,
				'companies' => 5,
			],
		],
		[
			'group_id' => 12,
			'filename' => '12_delphi.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 6,
				'email' => 7,
				'in_english' => 2,
				'experience_year' => 3,
				'linked_in' => 9,
				'description' => 5,
				'last_contact_date' => 4,
				//'last_callback_date' => 6,
				'technologies' => 1,
				//'companies' => 5,
			],
		],
		[
			'group_id' => 13,
			'filename' => '13_devops.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 13,
				'email' => 14,
				'in_english' => 2,
				'experience_year' => 3,
				'linked_in' => 15,
				'description' => 12,
				'last_contact_date' => 10,
				//'last_callback_date' => 6,
				//'technologies' => 1,
				'companies' => 11,
			],
		],
		[
			'group_id' => 14,
			'filename' => '14_ellenor.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 6,
				'email' => 7,
				//'in_english' => 2,
				//'experience_year' => 3,
				//'linked_in' => 15,
				'description' => 4,
				'last_contact_date' => 2,
				//'last_callback_date' => 6,
				//'technologies' => 1,
				//'companies' => 11,
			],
		],
		[
			'group_id' => 15,
			'filename' => '15_epitomernok.csv',
			'columnIndexes' => [
				'name' => 2,
				'phone' => 7,
				'email' => 8,
				//'in_english' => 2,
				//'experience_year' => 3,
				//'linked_in' => 15,
				'description' => 5,
				'last_contact_date' => 0,
				'last_callback_date' => 1,
				//'technologies' => 1,
				//'companies' => 11,
			],
		],
		[
			'group_id' => 16,
			'filename' => '16_etikus_hacker.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 7,
				'email' => 8,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 9,
				'description' => 6,
				'last_contact_date' => 4,
				//'last_callback_date' => 1,
				//'technologies' => 1,
				'companies' => 5,
			],
		],
		[
			'group_id' => 17,
			'filename' => '17_frontend.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 9,
				'email' => 10,
				'in_english' => 2,
				'experience_year' => 3,
				'linked_in' => 11,
				'description' => 8,
				'last_contact_date' => 5,
				'technologies' => 1,
				'companies' => 6,
			],
		],
		[
			'group_id' => 18,
			'filename' => '18_halozat_mernokok.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 7,
				'email' => 8,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 9,
				'description' => 5,
				'last_contact_date' => 3,
				'companies' => 4,
			],
		],
		[
			'group_id' => 19,
			'filename' => '19_hegeszto.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 7,
				'email' => 6,
				'experience_year' => 1,
				'description' => 4,
				'last_contact_date' => 2,
				'companies' => 3,
			],
		],
		[
			'group_id' => 21,
			'filename' => '21_hr.csv',
			'columnIndexes' => [
				'name' => 0,
				'phone' => 8,
				'email' => 1,
				'in_english' => 2,
				'experience_year' => 3,
				'description' => 6,
				'last_contact_date' => 4,
				'companies' => 5,
			],
		],
		[
			'group_id' => 22,
			'filename' => '22_it_vezetok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 7,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 8,
				'description' => 5,
				'last_contact_date' => 3,
				'companies' => 4,
			],
		],
		/*[
			'group_id' => 23,
			'filename' => '23_java.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 7,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 8,
				'description' => 5,
				'last_contact_date' => 3,
				'companies' => 4,
			],
		],*/
		[
			'group_id' => 24,
			'filename' => '24_jogaszok.csv',
			'columnIndexes' => [
				'name' => 0,
				'in_english' => 2,
				'experience_year' => 3,
				'description' => 6,
				'last_contact_date' => 4,
				'companies' => 5,
			],
		],
		[
			'group_id' => 25,
			'filename' => '25_konyvelok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 1,
				'in_english' => 3,
				'experience_year' => 4,
				'description' => 7,
				'last_contact_date' => 5,
				'companies' => 6,
			],
		],
		[
			'group_id' => 26,
			'filename' => '26_lakatosok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 6,
				'phone' => 7,
				'experience_year' => 1,
				'description' => 4,
				'last_contact_date' => 2,
				'companies' => 3,
			],
		],
		[
			'group_id' => 27,
			'filename' => '27_machine_learning.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 8,
				'phone' => 7,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 9,
				'description' => 5,
				'last_contact_date' => 3,
				'companies' => 4,
			],
		],
		[
			'group_id' => 28,
			'filename' => '28_marketingesek.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 8,
				'phone' => 7,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 9,
				'description' => 5,
				'last_contact_date' => 3,
				'companies' => 4,
			],
		],
		[
			'group_id' => 29,
			'filename' => '29_minosegiranyitasi_szakemberek.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 8,
				'phone' => 7,
				'in_english' => 1,
				'experience_year' => 2,
				'linked_in' => 9,
				'description' => 5,
				'last_contact_date' => 3,
				'companies' => 4,
			],
		],
		[
			'group_id' => 31,
			'filename' => '31_nodejs_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'home_office' => 1,
				'email' => 9,
				'phone' => 8,
				'in_english' => 2,
				'experience_year' => 3,
				'description' => 6,
				'last_contact_date' => 4,
				'companies' => 5,
			],
		],
		[
			'group_id' => 33,
			'filename' => '33_oktatasszervezok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				'description' => 6,
				'last_contact_date' => 4,
				'companies' => 5,
				'report' => 10,
			],
		],
		[
			'group_id' => 34,
			'filename' => '34_oracle_uzemeltetok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 1,
				'in_english' => 2,
				'experience_year' => 3,
				'description' => 6,
				'last_contact_date' => 4,
				'companies' => 5,
				'linked_in' => 8,
			],
		],
		[
			'group_id' => 35,
			'filename' => '35_osztalyvezetok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				'in_english' => 1,
				'experience_year' => 2,
				'description' => 6,
				'last_contact_date' => 3,
				'last_callback_date' => 5,
				'companies' => 4,
			],
		],
		[
			'group_id' => 36,
			'filename' => '36_php_fejlesztok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				'linked_in' => 10,
				'in_english' => 1,
				'experience_year' => 2,
				'description' => 6,
				'last_contact_date' => 3,
				'last_callback_date' => 4,
				'companies' => 4,
			],
		],
		[
			'group_id' => 37,
			'filename' => '37_powerbuilder.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 7,
				'phone' => 6,
				//'linked_in' => 10,
				//'in_english' => 1,
				//'experience_year' => 2,
				'description' => 5,
				'last_contact_date' => 3,
				//'last_callback_date' => 4,
				'companies' => 4,
			],
		],
		[
			'group_id' => 38,
			'filename' => '38_projektmenedzser.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 1,
				'phone' => 2,
				'linked_in' => 10,
				'in_english' => 3,
				'experience_year' => 4,
				'description' => 8,
				'last_contact_date' => 5,
				'last_callback_date' => 6,
				'companies' => 7,
			],
		],
		[
			'group_id' => 39,
			'filename' => '39_python.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				'linked_in' => 10,
				//'in_english' => 3,
				//'experience_year' => 4,
				'description' => 6,
				'last_contact_date' => 3,
				'last_callback_date' => 5,
				'companies' => 7,
			],
		],
		[
			'group_id' => 40,
			'filename' => '40_rpa.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				'linked_in' => 10,
				//'in_english' => 3,
				//'experience_year' => 4,
				'description' => 6,
				'last_contact_date' => 3,
				'last_callback_date' => 5,
				//'companies' => 7,
			],
		],
		[
			'group_id' => 41,
			'filename' => '41_ruby.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 8,
				'phone' => 7,
				//'linked_in' => 10,
				//'in_english' => 1,
				'experience_year' => 2,
				//'description' => 6,
				'last_contact_date' => 3,
				//'last_callback_date' => 5,
				//'companies' => 7,
			],
		],
		[
			'group_id' => 42,
			'filename' => '42_sales.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 8,
				'phone' => 7,
				//'linked_in' => 10,
				'in_english' => 1,
				'experience_year' => 2,
				'description' => 6,
				'last_contact_date' => 3,
				//'last_callback_date' => 5,
				'companies' => 4,
			],
		],
		[
			'group_id' => 43,
			'filename' => '43_scrum_master.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 7,
				//'phone' => 7,
				//'linked_in' => 10,
				'in_english' => 2,
				'experience_year' => 3,
				//'description' => 6,
				'last_contact_date' => 6,
				//'last_callback_date' => 5,
				'companies' => 4,
				'technologies' => 2,
			],
		],
		[
			'group_id' => 44,
			'filename' => '44_sharepoint.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				//'linked_in' => 10,
				'in_english' => 1,
				'experience_year' => 2,
				'description' => 6,
				'last_contact_date' => 3,
				//'last_callback_date' => 5,
				//'companies' => 4,
				//'technologies' => 2,
			],
		],
		[
			'group_id' => 45,
			'filename' => '45_support.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 10,
				'phone' => 9,
				'linked_in' => 11,
				'in_english' => 1,
				'experience_year' => 2,
				'description' => 8,
				'last_contact_date' => 5,
				'last_callback_date' => 7,
				'companies' => 6,
				//'technologies' => 2,
			],
		],
		[
			'group_id' => 46,
			'filename' => '46_technikus_villanyszerelo.csv',
			'columnIndexes' => [
				'name' => 0,
				//'email' => 10,
				//'phone' => 9,
				//'linked_in' => 11,
				'in_english' => 1,
				'experience_year' => 2,
				'description' => 5,
				'last_contact_date' => 3,
				//'last_callback_date' => 7,
				'companies' => 4,
				//'technologies' => 2,
			],
		],
		[
			'group_id' => 47,
			'filename' => '47_tesztelok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 10,
				'phone' => 9,
				'linked_in' => 11,
				'in_english' => 3,
				'experience_year' => 4,
				'description' => 8,
				'last_contact_date' => 6,
				//'last_callback_date' => 7,
				'companies' => 7,
				'technologies' => 2,
			],
		],
		[
			'group_id' => 48,
			'filename' => '48_uzleti_elemzok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 12,
				'phone' => 11,
				'linked_in' => 13,
				'in_english' => 4,
				'experience_year' => 6,
				'description' => 9,
				'last_contact_date' => 7,
				//'last_callback_date' => 7,
				'companies' => 8,
				//'technologies' => 2,
			],
		],
		[
			'group_id' => 49,
			'filename' => '49_vezeto_fejlesztok_architectek.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 3,
				'phone' => 2,
				//'linked_in' => 13,
				'in_english' => 4,
				'experience_year' => 5,
				'description' => 8,
				'last_contact_date' => 6,
				//'last_callback_date' => 7,
				'companies' => 7,
				'technologies' => 1,
			],
		],
		[
			'group_id' => 50,
			'filename' => '50_villanyszerelok.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 7,
				'phone' => 8,
				//'linked_in' => 13,
				//'in_english' => 4,
				'experience_year' => 1,
				'description' => 5,
				'last_contact_date' => 2,
				'last_callback_date' => 3,
				'companies' => 4,
				//'technologies' => 1,
			],
		],
		[
			'group_id' => 51,
			'filename' => '51_rendszergazdak.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 11,
				'phone' => 10,
				'linked_in' => 12,
				'in_english' => 5,
				'experience_year' => 6,
				'description' => 9,
				'last_contact_date' => 7,
				//'last_callback_date' => 3,
				'companies' => 8,
				//'technologies' => 1,
			],
		],
		[
			'group_id' => 52,
			'filename' => '52_wordpress.csv',
			'columnIndexes' => [
				'name' => 0,
				'email' => 9,
				'phone' => 8,
				'linked_in' => 10,
				'in_english' => 2,
				'experience_year' => 3,
				'description' => 6,
				'last_contact_date' => 4,
				//'last_callback_date' => 3,
				'companies' => 5,
				//'technologies' => 1,
			],
		],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
	    foreach ($this->data as $data) {
		    $fp = fopen(storage_path('app/public/csv/') . $data['filename'], 'r');

		    $i = 0;
		    while($row = fgetcsv($fp, 0, ';')) {
			    if (!$i++) {
				    continue;
			    }

			    $technologies = null;
				$companies = null;

			    $applicantModel = new Applicant();
			    $applicantModel->is_active = 1;
			    foreach ($data['columnIndexes'] as $field => $columnIndex) {
				    $value = trim($row[$columnIndex]);

					if (in_array($field, ['last_contact_date', 'last_callback_date'])) {
						$time = strtotime(str_replace(['.'], ['-'], $row[$columnIndex]) . ' 00:00:00');
						$value = !empty($time) && !empty($row[$columnIndex]) ? date('Y-m-d', $time) : null;

					} elseif ($field == 'in_english') {
						$value = intval($row[$columnIndex]) ?: null;

					} elseif ($field == 'experience_year') {
						$value = intval($row[$columnIndex]) ?: null;
						if ($value !== null && $value < 1970) {
							$value = date('Y') - $value;
						}

					} elseif ($field == 'linked_in' && !empty($value) && !Str::startsWith($value, 'https://')) {
						$value = 'https://' . str_replace('http://', '', $value);

					} elseif ($field == 'email') {
						$value = $row[$columnIndex];
						if (!preg_match(self::EMAIL_PATTERN, $value)) {
							$value = '';
						}

					} elseif ($field == 'technologies') {
						$technologies = explode(',', $row[$columnIndex]);
						continue;

					} elseif ($field == 'companies') {
						$companies = explode(',', $row[$columnIndex]);
						$applicantModel->forwarded_to_companies = $row[$columnIndex];
						continue;

					}

				    $applicantModel->$field = $value;
				}

			    $applicantModel->save();
			    $applicantModel->groups()->sync([$data['group_id']]);

				if (!empty($technologies)) {
					$ids = [];
					foreach ($technologies as $name) {
						$name = ucwords(trim($name));
						if (empty($name)) {
							continue;
						}

						if (!($skillModel = Skill::where('name', $name)->first())) {
							$skillModel = new Skill();
							$skillModel->name = $name;
							$skillModel->is_active = 1;
							$skillModel->save();
						}
						$ids[] = $skillModel->id;
					}

					$applicantModel->skills()->sync($ids);
				}

			    if (!empty($companies)) {
				    foreach ($companies as $name) {
					    $name = ucwords(trim($name));
					    if (empty($name)) {
						    continue;
					    }

					    if (!(Company::where('name', $name)->first())) {
						    $companyModel = new Company();
						    $companyModel->name = $name;
						    $companyModel->is_active = 1;
						    $companyModel->save();
					    }
				    }
			    }
		    }

		    fclose($fp);
	    }
    }
}
