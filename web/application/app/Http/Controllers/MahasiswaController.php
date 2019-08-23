<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Mahasiswa;
use App\Http\Models\SysConfig;
use App\Http\Models\MahasiswaFoto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use DB;
use Image;


class MahasiswaController extends Controller
{
	public function index()
	{
		$data['title'] = 'Mahasiswa';
		$data['menu_active'] = 'mahasiswa';
		return view('mahasiswa/grid',$data);
	}

	public function show($id_mahasiswa, Mahasiswa $m_mahasiswa, Request $request)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		if(!$request->ajax()){
			return $this->accessForbidden();
		}else{
			$get_mahasiswa = $m_mahasiswa->get_data($id_mahasiswa);

			if(!empty($get_mahasiswa)){
				$responseCode = 200;
				$responseMessage = 'Data tersedia.';
				$responseData['mahasiswa'] = $get_mahasiswa;
			}else{
				$responseData['mahasiswa'] = [];
				$responseStatus = 'No Data Available';
				$responseMessage = 'Data tidak tersedia';
			}

			$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
			return response()->json($response, $responseCode);
		}
	}

	public function store(Request $request, Mahasiswa $m_mahasiswa)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		$rules['nim'] = 'required';
		$rules['nama'] = 'required';
		$rules['alamat'] = 'required';
		$rules['tanggal_lahir'] = 'required';
		$rules['hp'] = 'required';
		$rules['action'] = 'required';

		$action = $request->input('action');

		if($action == 'edit'){
			$rules['id_mahasiswa'] = 'required';
		}

		$validator = Validator::make($request->all(), $rules, $this->validationMessage());

		if($validator->fails()){
			$responseCode = 400;
			$responseStatus = 'Missing Param';
			$responseMessage = 'Silahkan isi form dengan benar terlebih dahulu!';
			$responseData['error_log'] = $validator->errors();
		}elseif (!$request->ajax()) {
			return $this->accessForbidden();
		}else{

			$id_mahasiswa = $request->input('id_mahasiswa');
			$mhs_nim = $request->input('nim');
			$mhs_nama = $request->input('nama');
			$mhs_alamat = $request->input('alamat');
			$tanggal_lahir = $request->input('tanggal_lahir');
			$mhs_hp = $request->input('hp');

			$tanggal_lahir = explode('/', $tanggal_lahir);
			$mhs_tanggal_lahir = $tanggal_lahir[2].'-'.$tanggal_lahir[1].'-'.$tanggal_lahir[0];

			if($this->cek_nim($mhs_nim, $id_mahasiswa) == false){
				$responseCode = 400;
				$responseMessage = 'NIM sudah digunakan';
			}else{
				if(!empty($id_mahasiswa)){
					$get_mahasiswa = Mahasiswa::get_data($id_mahasiswa, false);
					if(!empty($get_mahasiswa)){
						$m_mahasiswa = Mahasiswa::find($get_mahasiswa->id_mahasiswa);
						$m_mahasiswa->updated_by = $this->userdata('id_user');
					}
				}else{
					$m_mahasiswa->created_by = $this->userdata('id_user');
				}

				$m_mahasiswa->mhs_nama = $mhs_nama;
				$m_mahasiswa->mhs_nim = $mhs_nim;
				$m_mahasiswa->mhs_alamat = $mhs_alamat;
				$m_mahasiswa->mhs_tanggal_lahir = $mhs_tanggal_lahir;
				$m_mahasiswa->mhs_hp = $mhs_hp;

				$m_mahasiswa->save();

				$responseCode = 200;
				$responseMessage = 'Data berhasil disimpan';
			}
		}

		$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
		return response()->json($response, $responseCode);
	}

	public function setAktif(Request $request, Mahasiswa $m_mahasiswa)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		
		$rules['id_mahasiswa'] = 'required';

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails()){
			$responseCode = 400;
			$responseStatus = 'Missing Param';
			$responseMessage = 'Silahkan isi form dengan benar terlebih dahulu!';
			$responseData['error_log'] = $validator->errors();
		}elseif (!$request->ajax()) {
			return $this->accessForbidden();
		}else{
			$id_mahasiswa = $request->input('id_mahasiswa');
			$mhs_aktif = $request->input('aktif');

			$get_mahasiswa = Mahasiswa::get_data($id_mahasiswa, false);
			if(!empty($get_mahasiswa)){
				$m_mahasiswa = Mahasiswa::find($get_mahasiswa->id_mahasiswa);
				$m_mahasiswa->mhs_aktif = $mhs_aktif;

				$m_mahasiswa->save();

				$responseCode = 200;
				$responseMessage = 'Status berhasil '. (($mhs_aktif == 't')? 'diaktifkan' : 'di-nonaktifkan');
				// $responseMessage = 'Status berhasil diperbarui';
			}else{
				$responseCode = 400;
				$responseMessage = 'Data tidak tersedia';
			}
		}

		$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
		return response()->json($response, $responseCode);
	}

	public function json(Request $request)
	{
		$responseCode = 200;
		$responseStatus = 'OK';
		$responseMessage = 'Data tersedia';
		$responseData = [];

		if(!$request->ajax()){
			return $this->accessForbidden();
		}else{

			$m_mahasiswa = new Mahasiswa();

			$numbcol = $request->get('order');
			$columns = $request->get('columns');

			$echo = $request->get('draw');
			$start = $request->get('start');
			$perpage = $request->get('length');

			$search = $request->get('search');
			$search = $search['value'];
			$pattern = '/[^a-zA-Z0-9 !@#$%^&*\/\.\,\(\)-_:;?\+=]/u';
			$search = preg_replace($pattern, '', $search);

			$sort = $numbcol[0]['dir'];
			$field = $columns[$numbcol[0]['column']]['data'];
			
			$condition = ($request->get('aktif')? $request->get('aktif') : false);

			$page = ($start / $perpage) + 1;

			if($page >= 0){
				$result = $m_mahasiswa->json_grid($start, $perpage, $search, false, $sort, $field, $condition);
				$total = $m_mahasiswa->json_grid($start, $perpage, $search, true, $sort, $field, $condition);
			}else{
				$result = $m_mahasiswa::orderBy($field, $sort)->get();
				$total = $m_mahasiswa::all()->count();
			}

			$responseData = array("sEcho"=>$echo,"iTotalRecords"=>$total,"iTotalDisplayRecords"=>$total,"aaData"=>$result);
			
			return response()->json($responseData, $responseCode);
		}
	}

	public function load_active(Request $request, Mahasiswa $m_mahasiswa)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		if(!$request->ajax()){
			return $this->accessForbidden();
		}else{
			$get_mahasiswa = $m_mahasiswa->get_data(false, true, 'mhs_nama', 'asc');

			if(!empty($get_mahasiswa)){
				$responseCode = 200;
				$responseMessage = 'Data tersedia.';
				$responseData['mahasiswa'] = $get_mahasiswa;
			}else{
				$responseData['mahasiswa'] = [];
				$responseStatus = 'No Data Available';
				$responseMessage = 'Data Mahasiswa tidak tersedia';
			}

			$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
			return response()->json($response, $responseCode);
		}
	}

	public function uploadFoto($id_mahasiswa, Request $request)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		$get_mahasiswa = Mahasiswa::get_data($id_mahasiswa, false);
		if(!empty($get_mahasiswa)){
			$file = $request->file('file');
			if(!empty($file)){

				$fake_filename = rand_str(15).'.'.$file->getClientOriginalExtension();
				$filename = $file->getClientOriginalName();
				// $filename = help_filename($fake_filename, '-');

				$destinationPath = myStorage('mahasiswa/'.$get_mahasiswa->id_mahasiswa.'/');

				helpCreateDirectory($destinationPath);

				$file->move($destinationPath, $fake_filename);

				$get_by_mahasiswa = MahasiswaFoto::whereNull('deleted_at')->where('mhf_mhs_id', $get_mahasiswa->id_mahasiswa)->first();
				$oldFile = '';

				if(empty($get_by_mahasiswa)){
					$m_mahasiswa_file = new MahasiswaFoto();
				}else{
					$m_mahasiswa_file = MahasiswaFoto::find($get_by_mahasiswa->mhf_id);
					if(!empty($m_mahasiswa_file->mhf_path_file)){
						if(file_exists($destinationPath.$m_mahasiswa_file->mhf_path_file) && !is_dir($destinationPath.$m_mahasiswa_file->mhf_path_file)){
							$oldFile = $m_mahasiswa_file->mhf_path_file;
							unlink($destinationPath.$m_mahasiswa_file->mhf_path_file);
						}
					}
				}

                // start:create thumbnail
				$arr_allowed_thumbnail = ['jpg', 'png', 'jpeg'];
				$fileExt = pathinfo($destinationPath.'/'.$fake_filename, PATHINFO_EXTENSION);

				if(in_array(strtolower($fileExt), $arr_allowed_thumbnail)){
					$thumbnailImage = Image::make($destinationPath.'/'.$fake_filename);

					$get_dimensi = SysConfig::get_data('thumbnail_dimension');
					$arr_dimensi = explode('#', $get_dimensi->value);

					$fileInfo = pathinfo($destinationPath.'/'.$fake_filename);

					for ($i=0; $i < count($arr_dimensi) ; $i++) {
						$dimensi = explode( 'x', $arr_dimensi[$i]);
						$newWidth = $dimensi[0];
						$newHeight = $dimensi[1];

						$newFilename = 'thumbnail-'.$newWidth.'x'.$newHeight.'_'.$fileInfo['filename'];
						$extension = $fileInfo['extension'];

						$oldThumbnail = $destinationPath.'/thumbnail-'.$newWidth.'x'.$newHeight.'_'.$oldFile;
						if(!empty($oldFile) && file_exists($oldThumbnail) && !is_dir($oldThumbnail)){
							unlink($oldThumbnail);
						}

                    //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY 
						$canvas = Image::canvas($newWidth, $newHeight, '#FFFFFF');
                    //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY 
                    //DENGAN MEMPERTAHANKAN RATIO
						$resizeImage  = Image::make($destinationPath.'/'.$fake_filename)->resize($newWidth, $newHeight, function($constraint) {
							$constraint->aspectRatio();
						});

                    //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
						$canvas->insert($resizeImage, 'center');
                    //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
						$canvas->save($destinationPath.'/thumbnail-'.$newWidth.'x'.$newHeight.'_'.$fake_filename);
					}
				}
                // end:create thumbnail

				$m_mahasiswa_file->mhf_mhs_id = $get_mahasiswa->id_mahasiswa;
				$m_mahasiswa_file->mhf_nama_file = $filename;
				$m_mahasiswa_file->mhf_path_file = $fake_filename;
				$m_mahasiswa_file->save();

				$responseCode = 200;
				$responseData['file'] = $m_mahasiswa_file;
			}else{
				$responseCode = 400;
				$responseStatus = 'Missing Param';
				$responseMessage = 'Silahkan isi form dengan benar terlebih dahulu!';
			}
		}else{
			$responseCode = 400;
			$responseStatus = 'Missing Param';
			$responseMessage = 'Data tidak tersedia';
		}

		$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
		return response()->json($response, $responseCode);
	}

	public function listFoto($id_mahasiswa, Mahasiswa $m_mahasiswa, Request $request)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		if(!$request->ajax()){
			return $this->accessForbidden();
		}else{
			$get_mahasiswa = $m_mahasiswa->get_data($id_mahasiswa);

			if(!empty($get_mahasiswa)){
				$responseCode = 200;
				$responseMessage = 'Data tersedia.';
				$responseData['mahasiswa'] = $get_mahasiswa;
				$responseData['file'] = MahasiswaFoto::get_data(false, $id_mahasiswa);
			}else{
				$responseData['mahasiswa'] = [];
				$responseStatus = 'No Data Available';
				$responseMessage = 'Data tidak tersedia';
			}

			$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
			return response()->json($response, $responseCode);
		}
	}

	public function deleteFoto(Request $request)
	{
		$responseCode = 403;
		$responseStatus = '';
		$responseMessage = '';
		$responseData = [];

		$rules['id_file'] = 'required';

		$action = $request->input('action');

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails()){
			$responseCode = 400;
			$responseStatus = 'Missing Param';
			$responseMessage = 'Silahkan isi form dengan benar terlebih dahulu!';
			$responseData['error_log'] = $validator->errors();
		}elseif (!$request->ajax()) {
			return $this->accessForbidden();
		}else{
			$responseCode = 400;
			$responseMessage = 'File Tidak Tersedia';

			$id_file = $request->input('id_file');

			$cek_file = MahasiswaFoto::get_data($id_file, false, false);

			if(!empty($cek_file)){
				$m_mahasiswa_foto = MahasiswaFoto::find($cek_file->id_file);

				$destinationPath = myStorage('mahasiswa/'.$cek_file->id_mahasiswa.'/');

				$targetFile = $destinationPath.$cek_file->path_file;

				if(file_exists($targetFile) && !is_dir($targetFile)){
					unlink($targetFile);
				}

				$get_dimensi = SysConfig::get_data('thumbnail_dimension');
				$arr_dimensi = explode('#', $get_dimensi->value);

				for ($i=0; $i < count($arr_dimensi) ; $i++) {
					$dimensi = explode('x', $arr_dimensi[$i]);
					$newWidth = $dimensi[0];
					$newHeight = $dimensi[1];

					$oldThumbnail = $destinationPath.'/thumbnail-'.$newWidth.'x'.$newHeight.'_'.$cek_file->path_file;
					if(file_exists($oldThumbnail) && !is_dir($oldThumbnail)){
						unlink($oldThumbnail);
					}
				}

				$m_mahasiswa_foto->forceDelete();

				$responseCode = 200;
				$responseMessage = 'File berhasil dihapus';
			}
		}

		$response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus);
		return response()->json($response, $responseCode);
	}

	private function cek_nim($nim, $id_mahasiswa=null)
	{
		$m_mahasiswa = new Mahasiswa();
		$result = false;

		$cek = $m_mahasiswa::where('mhs_nim', $nim)->first();

		if(!empty($id_mahasiswa)){
			if(!empty($cek) and $id_mahasiswa != md5(($cek['mhs_id'].encText()))){
				$result = false;
			}else{
				$result = true;
			}
		}else{
			if(!empty($cek)){
				$result = false;
			}else{
				$result = true;
			}
		}

		return $result;
	}
}