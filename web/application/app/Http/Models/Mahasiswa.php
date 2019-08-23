<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Model
{
    use SoftDeletes;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'mhs_id';
    // public $connection = 'pgsql';
    // public $incrementing = false;

    protected $fillable = [
        'mhs_nim',
        'mhs_nama',
        'mhs_alamat',
        'mhs_tanggal_lahir',
        'mhs_hp',
        'mhs_aktif',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'created_by','updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

    public static function get_data($id_mahasiswa = false, $md5=true, $aktif=false, $field=false, $sort=false)
    {
        $result = DB::table(DB::raw('mahasiswa'))
        ->select(DB::raw( (($md5 == true)? "MD5(CONCAT(mhs_id, '".encText('mahasiswa')."'))" : "mhs_id" )." AS id_mahasiswa, mhs_nim AS nim, mhs_nama AS nama, mhs_alamat AS alamat, mhs_tanggal_lahir AS tanggal_lahir,  mhs_hp AS hp, mhs_aktif AS aktif"))
        ->whereNull('deleted_at');

        if($aktif == true){
            $result = $result->where('mhs_aktif', '=', $aktif);
        }

        if($field == true && $sort == true){
            $result = $result->orderBy($field, $sort);
        }

        if($id_mahasiswa == true){
            $result = $result->where(DB::raw("MD5(CONCAT(mhs_id, '".encText('mahasiswa')."'))"), $id_mahasiswa)->first();
        }else{
            $result  = $result->get();
        }
        
        return $result;
    }

    public static function json_grid($start, $length, $search='', $count=false, $sort, $field, $condition)
    {
        $query_tgl_lahir = helpDateQuery('mhs_tanggal_lahir', 'mi', 'pgsql');
        
        $result = DB::table(DB::raw('mahasiswa'))
        ->select(DB::raw("MD5(CONCAT(mhs_id, '".encText('mahasiswa')."')) AS id_mahasiswa, mhs_nim AS nim, mhs_nama AS nama, mhs_alamat AS alamat, ".$query_tgl_lahir." AS tanggal_lahir, mhs_hp AS hp, mhs_aktif AS aktif"))
        ->whereNull('deleted_at');

        if(!empty($search)){
            $result = $result->where(function($where) use($search, $query_tgl_lahir){
                $where->where('mhs_nim', 'ILIKE', '%'.$search.'%')
                ->orWhere('mhs_nama', 'ILIKE', '%'.$search.'%')
                ->orWhere('mhs_alamat', 'ILIKE', '%'.$search.'%')
                ->orWhere('mhs_hp', 'ILIKE', '%'.$search.'%')
                ->orWhere(DB::raw($query_tgl_lahir), 'ILIKE', '%'.$search.'%');
            });
        }

        if($condition == true){
            $result = $result->where('mhs_aktif', '=', $condition);
        }

        if($count == true){
            $result = $result->count();
        }else{
            $result  = $result->offset($start)->limit($length)->orderBy($field, $sort)->get();
        }

        return $result;
    }
}