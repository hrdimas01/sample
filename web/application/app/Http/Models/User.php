<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'usr_id';
    protected $connection = 'pgsql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usr_username',
        'usr_name',
        'usr_email',
        'usr_password',
        'usr_role',
        'usr_aktif',
        'usr_token_permission',
        'usr_token_limits',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'usr_password', 'remember_token', 'created_at', 'created_by','updated_at', 'updated_by', 'deleted_at', 'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function getAuthPassword()
    {
        return $this->usr_password;
    }

    public function save_data($data, $id='')
    {
        if(empty($id)){
            if($this->timestamps == true){
                $data['created_at'] = date('Y-m-d H:i:s');
            }
            
            if($this->incrementing == false or is_array($this->primaryKey)){
                DB::table($this->table)->insert($data);
                $current_id = true;
            }else{
                $current_id = DB::table($this->table)->insertGetId($data, $this->primaryKey);
            }
        }else{
            $current_id = $id;

            if($this->timestamps == true){
                $data['updated_at'] = date('Y-m-d H:i:s');
            }

            if(is_array($id)){
                DB::table($this->table)->where(function($condition) use($id){
                    foreach ($id as $key => $value) {
                        $condition->where($key, $value);
                    }
                })->update($data);
            }else{
                DB::table($this->table)->where($this->primaryKey, $id)->update($data);
            }
        }

        return $current_id;
    }
}
