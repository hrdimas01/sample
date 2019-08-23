<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MahasiswaFoto extends Model
{
	use SoftDeletes;
	protected $table = 'mahasiswa_foto';
	protected $primaryKey = 'mhf_id';
    // public $incrementing = false;

	protected $fillable = [
		'mhf_mhs_id',
		'mhf_nama_file',
		'mhf_keterangan_file',
		'mhf_path_file',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
		'deleted_at',
		'deleted_by'
	];

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_at', 'created_by','updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

	public static function get_data($id_file=false, $id_mahasiswa=false, $md5=true)
    {
        $result = DB::table(DB::raw('mahasiswa_foto'))
            ->select(DB::raw((($md5 == true)? "MD5(CONCAT(mhf_id, '".encText('mahasiswa_foto')."'))" : "mhf_id" ).' AS id_file, '.(($md5 == true)? "MD5(CONCAT(mhf_mhs_id, '".encText('mahasiswa')."'))" : "mhf_mhs_id" ).' AS id_mahasiswa, mhf_nama_file AS nama_file, mhf_keterangan_file AS keterangan_file, mhf_path_file AS path_file'));

        if($id_mahasiswa == true){
            $result = $result->where(DB::raw("MD5(CONCAT(mhf_mhs_id, '".encText('mahasiswa')."'))"), '=', $id_mahasiswa);
        }

        if($id_file == true){
            $result = $result->where(DB::raw("MD5(CONCAT(mhf_id, '".encText('mahasiswa_foto')."'))"), $id_file)->first();
        }else{
            $result  = $result->get();
        }
        
        return $result;
    }
}