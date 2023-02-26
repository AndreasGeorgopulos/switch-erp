<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanApplicantDataSeeder extends Seeder
{
	private $statements = [
		'delete from applicants;',
		'delete from applicant_applicant_group;',
		'delete from applicant_companies;',
		'delete from applicant_groups;',
		'delete from applicant_group_user;',
		'delete from applicant_job_position;',
		'delete from applicant_skill;',
		'delete from companies;',
		'delete from skills;',
		'ALTER TABLE `applicant_groups` AUTO_INCREMENT=1;',
		'ALTER TABLE `applicants` AUTO_INCREMENT=1;',
		'ALTER TABLE `applicant_job_position` AUTO_INCREMENT=1;',
		'ALTER TABLE `companies` AUTO_INCREMENT=1;',
		'ALTER TABLE `skills` AUTO_INCREMENT=1;',
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		foreach ($this->statements as $statement) {
			DB::statement($statement);
		}
    }
}
