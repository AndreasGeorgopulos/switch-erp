<?php

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
	private $skills = [
		1 => 'PHP',
		2 => 'MySql',
		3 => 'Javascript',
		4 => 'Laravel',
		5 => 'Symfony',
		6 => 'Yii',
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    foreach ( $this->skills as $id => $name ) {
		    if ( $model = Skill::find( $id ) ) {
			    continue;
		    }
		    $model = new Skill();
		    $model->id = $id;
		    $model->name = $name;
		    $model->is_active = true;
		    $model->save();
	    }
    }
}
