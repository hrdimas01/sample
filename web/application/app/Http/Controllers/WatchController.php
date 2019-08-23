<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Mahasiswa;
use App\Http\Models\MahasiswaFoto;

class WatchController extends Controller
{

  //   public function fotoMahasiswa(Request $request)
  //   {
		// $parent		= $request->get("prt");
  //       $source		= $request->get("src");
		// $id_file	= $request->get("un");
		// $category	= $request->get("ctg");

		// $image 		= ['.jpg', '.jpeg', '.png'];

		// $file = myStorage();

		// $cek_id_file = false;
		// $cek_parent = false;

		// $get_by_id = MahasiswaFoto::get_data($id_file, false, false);

		// if(!empty($get_by_id)){
		// 	$cek_id_file = true;

		// 	$cek_parent = (md5($get_by_id->id_mahasiswa.encText()) == $parent)? true : false;
		// }

		
		// if($cek_parent == true && $cek_id_file == true && !empty($source) && !empty($category)){
		// 	$file .= ('/mahasiswa/'.$get_by_id->id_mahasiswa.'/'.$source);
		// }

		// // echo $source;
		// // echo '<br>';
		// // echo $category;
		// // echo '<br>';
		// // echo md5($get_by_id->id_mahasiswa.encText()).'<br>';
		// // echo $file;

		// if(file_exists($file) && !is_dir($file)){
		// 	$type	= 'image';
			
		// 	$ext = pathinfo($file, PATHINFO_EXTENSION);
		// 	$ext = strtolower($ext);

		// 	if(in_array(strtolower($ext),$image)){
		// 		header('Content-Description: File Transfer');
		// 		header('Content-Type: application/octet-stream');
		// 		header('Content-Disposition: attachment; filename='.basename($file));
		// 		header('Content-Transfer-Encoding: binary');
		// 		header('Expires: 0');
		// 		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		// 		header('Pragma: public');
		// 		header('Content-Length: ' . filesize($file));
		// 		ob_clean();
		// 		flush();
		// 		readfile($file);
		// 		exit;
		// 	} else {
		// 		header('Content-Type:' . finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $file ));
		// 		header('Content-Length: ' . filesize($file));
		// 		readfile($file);
		// 	}
		// } else {
		// 	return $this->pageNotFound();
		// }
  //   }

    public function showFile($nama, Request $request)
	{
		$parent		= $request->get("prt");
		$source		= $request->get("src");
		$unique_id	= $request->get("un");
		$category	= $request->get("ctg");

		$image 		= ['.jpg', '.jpeg', '.png'];

		$file = myBasePath().myStorage();

		$filename = urldecode($nama);
		
		if(!empty($category) && !empty($source) && !empty($unique_id)){
			if($category == 'mahasiswa'){
				$get_mahasiswa = MahasiswaFoto::get_data($unique_id, false, false);

				if(!empty($get_mahasiswa) && ($parent == encText($get_mahasiswa->id_mahasiswa.'mahasiswa', true)) && $filename == $get_mahasiswa->nama_file){
					$file .= ($category.'/'.$get_mahasiswa->id_mahasiswa.'/'.$source);
				}
			}
		}

		$file = protectPath($file);

		if(file_exists($file) && !is_dir($file)){
			$type	= 'image';
			
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$ext = strtolower($ext);

			if(in_array(strtolower($ext),$image)){
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
			} else {
				header('Content-Type:' . finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $file ));
				header('Content-Length: ' . filesize($file));
				readfile($file);
			}
		} else {
			return $this->pageNotFound();
		}
	}

  //   public function default(Request $request)
  //   {
  //       $source		= $request->get("src");
  //       $category	= $request->get("type");

		// $image 		= ['.jpg', '.jpeg', '.png'];

		// $file		= 'assets/extends/';
		
		// if(!empty($source) && !empty($category)){
		// 	$file .= ($category.'/'.$source);
		// }

		// if(file_exists($file) && !is_dir($file)){
		// 	$type	= 'image';
			
		// 	$ext = pathinfo($file, PATHINFO_EXTENSION);
		// 	$ext = strtolower($ext);

		// 	if(in_array(strtolower($ext),$image)){
		// 		header('Content-Description: File Transfer');
		// 		header('Content-Type: application/octet-stream');
		// 		header('Content-Disposition: attachment; filename='.basename($file));
		// 		header('Content-Transfer-Encoding: binary');
		// 		header('Expires: 0');
		// 		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		// 		header('Pragma: public');
		// 		header('Content-Length: ' . filesize($file));
		// 		ob_clean();
		// 		flush();
		// 		readfile($file);
		// 		exit;
		// 	} else {
		// 		header('Content-Type:' . finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $file ));
		// 		header('Content-Length: ' . filesize($file));
		// 		readfile($file);
		// 	}
		// } else {
		// 	return $this->pageNotFound();
		// }
  //   }
}