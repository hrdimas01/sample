<?php

namespace App\Http\Models;

use App\Http\Models\E_Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Notifikasi extends E_Model
{
    use SoftDeletes;
    protected $table = 'notifikasi';
    protected $primaryKey = 'ntf_id';
    public $incrementing = true;

    protected $fillable = [
        'ntf_sender_id',
        'ntf_receiver_id',
        'ntf_action',
        'ntf_message',
        'ntf_category',
        'ntf_unique_id',
        'ntf_sent',
        'ntf_sent_at',
        'ntf_read',
        'ntf_read_at',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'created_by','updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

    public static function get_data($id_notifikasi = false, $md5=true, $field=false, $sort=false)
    {
        $encryptPrimary = encText('notifikasi');

        $result = DB::table(DB::raw('notifikasi ntf'))
        ->select(DB::raw("MD5(CONCAT(ntf_id, '".$encryptPrimary."')) AS id_notifikasi, ntf_sender_id AS id_sender, ntf_receiver_id AS id_receiver, ntf_action AS action, ntf_message AS message, ntf_category AS category, ntf_unique_id AS unique_id, ntf_sent AS sent, ntf_sent_at AS sent_at, ntf_read AS read, ntf_read_at AS read_at"));

        if($field == true && $sort == true){
            $result = $result->orderBy($field, $sort);
        }

        if($id_notifikasi == true){
            $result = $result->where(DB::raw("MD5(CONCAT(ntf_id, '".$encryptPrimary."'))"), $id_notifikasi)->first();
        }else{
            $result  = $result->get();
        }
        
        return $result;
    }

    public static function json_grid($start, $length, $search='', $count=false, $sort, $field, $id_receiver=false, $id_sender=false, $read=false)
    {
        $encryptPrimary = encText('notif');
        
        $result = DB::table(DB::raw('notifikasi ntf'))
        ->select(DB::raw("MD5(CONCAT(ntf_id, '".$encryptPrimary."')) AS id_notifikasi, ntf_sender_id AS id_sender, ntf_receiver_id AS id_receiver, ntf_action AS action, ntf_message AS message, ntf_category AS category, ntf_unique_id AS unique_id, ntf_sent AS sent, ntf_sent_at AS sent_at, ntf_read AS read, ntf_read_at AS read_at"));

        if(!empty($search)){
            $result = $result->where(function($where) use($search, $query_tanggal){
                $where->where('ntf_message', 'ILIKE', '%'.$search.'%');
            });
        }

        if($id_receiver == true){
            $result = $result->where('ntf_receiver_id', $id_receiver);
        }

        if($id_sender == true){
            $result = $result->where('ntf_sender_id', $id_sender);
        }

        if($read == true){
            $result = $result->where('ntf_read', $read);
        }

        if($count == true){
            $result = $result->count();
        }else{
            $result  = $result->offset($start)->limit($length)->orderBy($field, $sort)->get();
        }

        return $result;
    }
}