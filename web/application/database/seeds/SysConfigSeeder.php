<?php

use Illuminate\Database\Seeder;

class SysConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$current_time = date('Y-m-d H:i:s');
    	$arr_config = [
    		[
    			'config_name'	=> 'default_password',
    			'config_value'	=> 'admin1927'
    		],
            [
                'config_name'   => 'thumbnail_dimension',
                'config_value'  => '250x250#500x500'
            ]
    	];

    	foreach ($arr_config as $key => $value) {
    		$query = "INSERT INTO sys_config (config_name, config_value, created_by, created_at) VALUES ('".$value['config_name']."', '".$value['config_value']."', 0, '{$current_time}') ON CONFLICT (config_name) DO UPDATE SET config_value = '".$value['config_value']."', updated_by = 0, updated_at = '{$current_time}';";

    		DB::connection()->getPdo()->exec($query);
	    }
    }
}
