<?php
function app_info($key=''){
	$app_info = [
		'title' => 'Kimhabib Laravel 5.5',
		'description' => 'Kimhabib Laravel 5.5 Template',
		'name' => 'Kimhabib Laravel 5.5',
		'shortname' => 'KLA',
		'icon' => '',
		'client' => [
			'shortname' => 'Template',
			'fullname' => 'Kimhabib',
			'city' => 'Kota Surabaya',
			'category' => 'Private'
		],
		'copyright' => [
			'year' => '2019',
			'text' => '&copy; 2019 Kimhabib'
		],
		'vendor' => [
			'company' => 'Kimhabib',
			'office' => 'Jl Pancawarna 9 No. 36 Perumnas Kota Baru Driyorejo, Gresik, Jawa Timur',
			'contact' => [
				'phone' => '+62 857-3386-9100',
				'email' => 'dimas.habib01@gmail.com',
				'instagram' => 'https://www.instagram.com/kimhabib_01/'
			],
			'site' => ''
		]
	];

	$error=0;
	if(empty($key)){
		$result = $app_info;
	}else{
		$result = false;
		$key = explode('.', $key);
		if(is_array($key)){
			$temp = $app_info;
			for ($i=0; $i < count($key); $i++) {
				$error++;
				if(is_array($temp) and count($temp) > 0){
					if(array_key_exists($key[$i], $temp)){
						$error--;
						$result = $temp[$key[$i]];
						$temp = $temp[$key[$i]];
					}
				}
			}
		}
	}

	if($error > 0){
		$result = false;
	}

	return $result;
}

function encText($value='', $md5=false)
{
	$result = $value.'-kimwq';

	return (($md5 == false)? $result : md5($result));
}

?>