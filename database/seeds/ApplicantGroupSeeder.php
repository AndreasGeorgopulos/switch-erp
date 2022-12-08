<?php

use App\Models\ApplicantGroup;
use Illuminate\Database\Seeder;

class ApplicantGroupSeeder extends Seeder
{
	private $groups = [
		1 => 'Adatbázis fejlesztők',
		2 => 'Adatbázis üzemeltetők',
		3 => 'Adattárház fejlesztők',
		4 => 'Alvállalkozók',
		5 => 'Android-iOS fejlesztők',
		6 => 'Asszisztensek',
		7 => 'Átküldött JAVA jelöltek',
		8 => 'Biztonság',
		9 => 'C# fejlesztők',
		10 => 'C++ fejlesztők',
		11 => 'Content manager, feltöltő, social media manager',
		12 => 'Delphi',
		13 => 'Devops',
		14 => 'Ellenőr-vizsgáló',
		15 => 'Építőmérnökök',
		16 => 'Etikus Hacker',
		17 => 'Frontendesek',
		18 => 'Hálózati mérnök',
		19 => 'Hegesztő',
		20 => 'Hegesztőmérnökök',
		21 => 'HR-esek',
		22 => 'IT vezetők',
		23 => 'Java',
		24 => 'Jogászok',
		25 => 'Könyvelők',
		26 => 'Lakatosok',
		27 => 'Machine learning',
		28 => 'Marketingesek',
		29 => 'Minőségirányítási szakemberek',
		30 => 'Németül beszélők',
		31 => 'Node.js fejlesztők',
		33 => 'Oktatásszervezők',
		34 => 'Oracle üzemeltetők',
		35 => 'Osztályvezetők',
		36 => 'PHP fejlesztők',
		37 => 'PowerBuilder',
		38 => 'Projektmenedzser',
		39 => 'Python',
		40 => 'RPA',
		41 => 'Ruby',
		42 => 'Sales',
		43 => 'Scrum master',
		44 => 'SharePoint',
		45 => 'Support',
		46 => 'Technikus, villanyszerelő',
		47 => 'Tesztelők',
		48 => 'Üzleti elemzők',
		49 => 'Vezető fejlesztők, architectek',
		50 => 'Villanyszerelők',
		51 => 'Windows-Linux rendszergazdák, rendszermérnökök',
		52 => 'WordPress fejlesztők',
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		foreach ( $this->groups as $id => $name ) {
			if ( $model = ApplicantGroup::find( $id ) ) {
				continue;
			}
			$model = new ApplicantGroup();
			$model->id = $id;
			$model->name = $name;
			$model->is_active = true;
			$model->save();
		}
    }
}
