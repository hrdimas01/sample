<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pass = bcrypt("secret");
        $current_time = date('Y-m-d H:i:s');

        $arr_data = [
            [
                'usr_id' => 1,
                'usr_username' => "admin",
                'usr_name' => "Administrator",
                'usr_password' => $pass,
                'usr_email' => "admin@gmail.com",
                'usr_role' => "1",
                'created_at' => $current_time,
                'created_by' => "0",
            ]
        ];
        

        foreach ($arr_data as $key => $value) {
            
            $query = 'INSERT INTO "user" (usr_id, usr_username, usr_name, usr_password, usr_email, usr_role, created_by, created_at) VALUES ('.$value['usr_id'].', \''.$value['usr_username'].'\', \''.$value['usr_name'].'\', \''.$value['usr_password'].'\', \''.$value['usr_email'].'\', \''.$value['usr_role'].'\', 0, \''.$current_time.'\') ON CONFLICT (usr_id) DO UPDATE SET usr_username = \''.$value['usr_username'].'\', usr_name = \''.$value['usr_name'].'\', usr_password = \''.$value['usr_password'].'\', usr_email = \''.$value['usr_email'].'\', usr_role = \''.$value['usr_role'].'\', updated_by = 0, updated_at = \''.$current_time.'\';';

            DB::connection()->getPdo()->exec($query);
        }
    }
}
