<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(){
    	date_default_timezone_set("Asia/Jakarta");
    }

    public $title = '';
    public $menu = '';
    public $submenu = '';

    public function pageNotFound()
    {
        return response()->view('errors.404', [], 404);
    }

    public function accessForbidden()
    {
    	return response()->view('errors.403', [], 403);
    }

    public function userdata($param='')
    {
        $result = false;
        $sesi = Auth::user();
        $sesi = json_encode($sesi);
        $sesi = json_decode($sesi);

        $user = [
            'id_user' => $sesi->usr_id,
            'nama' => $sesi->usr_name,
            'username' => $sesi->usr_username,
            'email' => $sesi->usr_email,
            'role' => $sesi->usr_role,
            'aktif' => $sesi->usr_aktif
        ];

        if(!empty($param)){
            $key = array($param);

            for ($i=0; $i < count($key); $i++) {
                if(array_key_exists($key[$i], $user)){
                    $temp_key = $key[$i];
                    $result = $user[$temp_key];
                }
            }
        }else{
            $result = $user;
        }

        $data = ['user' => $user, 'param' => $param, 'result' => $result];

        return $result;
    }

    public function validationMessage()
    {
        $error_message = [
            'required' => 'Form :attribute wajib diisi!',
            'numeric' => 'Nilai :attribute harus berupa angka!',
            'min' => 'Nilai minimal :attribute adalah :min!',
        ];

        return $error_message;
    }
}
