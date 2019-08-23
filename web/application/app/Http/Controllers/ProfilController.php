<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Http\Models\User;

class ProfilController extends Controller
{
    public function update_password(Request $request)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		$rules['password_lama'] = 'required';
		$rules['password_baru'] = 'required';
		$rules['conf_password_baru'] = 'required';
		$rules['id_user'] = 'required';

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails()){
			$responseCode = 400;
			$responseStatus = 'Missing Param';
			$responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
			$responseData['error_log'] = $validator->errors();
		}elseif (!$request->ajax()) {
			return $this->accessForbidden();
		}else{
			$responseCode = 400;

			$id_user = $request->input('id_user');
			$password_lama = $request->input('password_lama');
			$password_baru = $request->input('password_baru');
			$conf_password_baru = $request->input('conf_password_baru');

			$m_user = User::find($id_user);

			if(!empty($m_user)){
				if (Hash::check($password_lama, $m_user->usr_password)) {
				    if($password_baru == $conf_password_baru){
				    	$m_user->usr_password = bcrypt($password_baru);
						$m_user->updated_by = session('userdata')['id_user'];
				    	$m_user->save();

						$responseCode = 200;
						$responseMessage = 'Password berhasil di-update';
				    }else{
						$responseMessage = 'Konfirmasi password baru tidak sama';
				    }
				}else{
					$responseMessage = 'Password Anda salah';
				}
			}else{
				$responseMessage = 'Data tidak tersedia';
			}
		}

		$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
		return response()->json($response, $responseCode);
	}
}