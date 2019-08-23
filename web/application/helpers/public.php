<?php
/**
 * Function helpResponse
 * Fungsi ini digunakan untuk mengambil response restful
 * @access public
 * @param (string) $code
 * @param (array) $data
 * @param (string) $msg
 * @param (string) $status
 * @return (array)
 */
function helpResponse($code, $data = NULL, $msg = '', $status = '', $note=NULL)
{
	switch($code){
		case '200':
		$s = 'OK';
		$m = 'Sukses';
		break;
		case '201':
		case '202':
		$s = 'Saved';
		$m = 'Data berhasil disimpan';
		break;
		case '204':
		$s = 'No Content';
		$m = 'Data tidak ditemukan';
		break;
		case '304':
		$s = 'Not Modified';
		$m = 'Data gagal disimpan';
		break;
		case '400':
		$s = 'Bad Request';
		$m = 'Fungsi tidak ditemukan';
		break;
		case '401':
		$s = 'Unauthorized';
		$m = 'Silahkan login terlebih dahulu';
		break;
		case '403':
		$s = 'Forbidden';
		$m = 'Sesi anda telah berakhir';
		break;
		case '404':
		$s = 'Not Found';
		$m = 'Halaman tidak ditemukan';
		break;
		case '414':
		$s = 'Request URI Too Long';
		$m = 'Data yang dikirim terlalu panjang';
		break;
		case '500':
		$s = 'Internal Server Error';
		$m = 'Maaf, terjadi kesalahan dalam mengolah data';
		break;
		case '502':
		$s = 'Bad Gateway';
		$m = 'Tidak dapat terhubung ke server';
		break;
		case '503':
		$s = 'Service Unavailable';
		$m = 'Server tidak dapat diakses';
		break;
		default:
		$s = 'Undefined';
		$m = 'Undefined';
		break;
	}
	
	$status = ($status != '') ? $status : $s;
	$msg = ($msg != '') ? $msg : $m;
	$result=array(
		"status"=>$status,
		"code"=>$code,
		"message"=>$msg,
		"data"=>$data,
		"note"=>$note
	);

	setHeader($code, $status);
	
	return $result;
}

function dump($var=""){
	if($var == ""){
		echo "No value to return.";
	} else {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}
function rand_str($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function helpCurrency($nominal='', $start='', $pemisah='.', $cent=true) {
	if(empty($nominal)){
		$hasil = '-';
	}else{
		$nominal = empty($nominal)? 0: $nominal;
		$angka_belakang =',00';
		$temp_rp = explode('.', $nominal);

		if(count($temp_rp) > 1){
			$nominal = $temp_rp[0];
			$angka_belakang = ','.$temp_rp[1];
		}

		if($cent == false){
			$angka_belakang = '';
		}

		$hasil = $start.number_format($nominal, 0, "", $pemisah) . $angka_belakang;
	}

	return $hasil;
}

function setHeader($code='200', $status='')
{
	header($_SERVER['SERVER_PROTOCOL'].' '.$code.' '.$status);
}

function helpToNum($data) {
	$alphabet = array( 'a', 'b', 'c', 'd', 'e',
		'f', 'g', 'h', 'i', 'j',
		'k', 'l', 'm', 'n', 'o',
		'p', 'q', 'r', 's', 't',
		'u', 'v', 'w', 'x', 'y',
		'z'
	);
	$alpha_flip = array_flip($alphabet);
	$return_value = -1;
	$length = strlen($data);
	for ($i = 0; $i < $length; $i++) {
		$return_value +=
		($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
	}
	return $return_value;
}

function toNum($data) {
	$alphabet = array( 'a', 'b', 'c', 'd', 'e',
		'f', 'g', 'h', 'i', 'j',
		'k', 'l', 'm', 'n', 'o',
		'p', 'q', 'r', 's', 't',
		'u', 'v', 'w', 'x', 'y',
		'z'
	);
	$alpha_flip = array_flip($alphabet);
	$return_value = -1;
	$length = strlen($data);
	for ($i = 0; $i < $length; $i++) {
		$return_value +=
		($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
	}
	return $return_value;
}

function toAlpha($data){
	$alphabet =   array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$alpha_flip = array_flip($alphabet);
	if($data <= 25){
		return $alphabet[$data];
	}
	elseif($data > 25){
		$dividend = ($data + 1);
		$alpha = '';
		$modulo;
		while ($dividend > 0){
			$modulo = ($dividend - 1) % 26;
			$alpha = $alphabet[$modulo] . $alpha;
			$dividend = floor((($dividend - $modulo) / 26));
		} 
		return $alpha;
	}
}

function helpRename($value='', $replace_with='')
{
	$pattern = '/[^a-zA-Z0-9 &.,-_]/u';
    $value = preg_replace($pattern, $replace_with, $value);

	return $value;
}

function help_forbidden_char($value='', $replace_with='')
{
	$forbidden_char = array('[', ']', '(', ')', '?', '\'', '′', '%');
	$value = str_replace($forbidden_char, $replace_with, $value);

	return $value;
}

function help_filename($value='', $replace_with='', $timestamp=true)
{
	$forbidden_char = array('[', ']', '(', ')', '?', '\'', '′', '%', ' ');
	$value = str_replace($forbidden_char, $replace_with, $value);
	$value = ($timestamp == true)? date('YmdHis').'_'.$value : $value;

	return $value;
}

function helpUsername($value='', $replace_with='', $lower=true)
{
	$pattern = '/[^a-zA-Z0-9.-_]/u';

	$arr_temp = explode(' ', $value);

	$result = preg_replace($pattern, $replace_with, $arr_temp[0]);
	$result = (strlen($result) >= 5)? $result : ( isset($arr_temp[1])? $result.preg_replace($pattern, $replace_with, $arr_temp[1]) : $result.rand_str(2, true));
	$result = ($lower == true)? strtolower($result) : $result;

	return $result;
}

function helpEmpty($value='', $replace_with='-', $null=false)
{
	if($null == false){
		$result = (empty($value) && $value != '0')? $replace_with : $value;
	}else{
		$result = (empty($value) && $value != '0')? '' : $value;
	}

	return $result;
}

function helpText($value, $tags=true, $zalgo=true){
	$result = $value;

	if($tags == true){
		$result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
	}

	if($zalgo == true){
		// $pattern = "~(?:[\p{M}]{1})([\p{M}])+?~uis";
		$pattern = "~[\p{M}]~uis";
		$result = preg_replace($pattern,"", $result);
	}

	return $result;
}