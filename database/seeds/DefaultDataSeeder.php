<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->insert([
			'name' => 'Super administrator',
			'email' => 'superadmin@switchit.hu',
			'password' => bcrypt('aA123456'),
			'created_at' => date("Y-m-d H:i:s")
		]);

		DB::table('users')->insert([
			'name' => 'Administrator',
			'email' => 'admin@switchit.hu',
			'password' => bcrypt('aA123456'),
			'created_at' => date("Y-m-d H:i:s")
		]);
	
		DB::table('roles')->insert([
			'key' => 'superadmin',
		]);
	
		DB::table('role_translates')->insert([
			'role_id' => 1,
			'language_code' => 'hu',
			'name' => 'Super adminisztrátor',
			'description' => ''
		]);
	
		DB::table('role_translates')->insert([
			'role_id' => 1,
			'language_code' => 'en',
			'name' => 'Super administrator',
			'description' => ''
		]);
	
		DB::table('roles')->insert([
			'key' => 'login',
		]);
	
		DB::table('role_translates')->insert([
			'role_id' => 2,
			'language_code' => 'hu',
			'name' => 'Bejelentkezés',
			'description' => ''
		]);
	
		DB::table('role_translates')->insert([
			'role_id' => 2,
			'language_code' => 'en',
			'name' => 'Login',
			'description' => ''
		]);
		
	
		DB::table('role_user')->insert([
			'user_id' => 1,
			'role_id' => 1
		]);
	
		DB::table('role_user')->insert([
			'user_id' => 1,
			'role_id' => 2
		]);
		
	
		DB::table('lq_options')->insert(
			[
				'lq_key' => 'analytics',
				'lq_value' => '<script type="text/javascript"></script>'
			]
		);
	
		DB::table('lq_options')->insert(
			[
				'lq_key' => 'socials_facebook',
				'lq_value' => '#'
			]
		);
		DB::table('lq_options')->insert(
			[
				'lq_key' => 'socials_google',
				'lq_value' => '#'
			]
		);
		DB::table('lq_options')->insert(
			[
				'lq_key' => 'socials_instagram',
				'lq_value' => '#'
			]
		);
		DB::table('lq_options')->insert(
			[
				'lq_key' => 'socials_youtube',
				'lq_value' => '#'
			]
		);
    }
}
