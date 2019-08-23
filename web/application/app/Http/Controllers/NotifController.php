<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Surat;
use App\Http\Models\User;
use App\Http\Models\UserToken;
use App\Http\Models\Notifikasi;

class NotifController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $responseCode = 403;
        $responseStatus = '';
        $responseMessage = '';
        $responseData = [];
        $responseNote = [];

        $rules['start'] = 'required|integer|min:0';
        $rules['perpage'] = 'required|integer|min:1';

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $responseCode = 400;
            $responseStatus = 'Missing Param';
            $responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
            $responseData['error_log'] = $validator->errors();
        }else{
            $m_notifikasi = new Notifikasi();
            $access_token = $request->header('access-token')? $request->header('access-token') : $request->input('access_token');
            $user = User::get_by_access_token($access_token);

            $start = $request->input('start');
            $perpage = $request->input('perpage');
            $search = $request->input('search');

            $pattern = '/[^a-zA-Z0-9 !@#$%^&*\/\.\,\(\)-_:;?\+=]/u';
            $search = preg_replace($pattern, '', $search);

            $sort = 'DESC';
            $field = 'ntf_id';

            $total = $m_notifikasi->json_grid($start, $perpage, $search, true, $sort, $field, $user->id_user);
            $notifikasi = $m_notifikasi->json_grid($start, $perpage, $search, false, $sort, $field, $user->id_user);
            
            $total_unread = $m_notifikasi->json_grid($start, $perpage, $search, true, $sort, $field, $user->id_user, false, 'f');

            $responseCode = 200;
            $responseData['notifikasi'] = $notifikasi;
            $responseData['unread'] = $total_unread;

            $pagination = ['row' => count($notifikasi), 'rowStart' => ( (count($notifikasi) > 0)? ($start + 1) : 0), 'rowEnd' => ($start + count($notifikasi))];
            $responseData['meta'] = ['start' => $start, 'perpage' => $perpage, 'search' => $search, 'total' => $total, 'pagination' => $pagination];
        }

        $response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus, $responseNote);
        return response()->json($response, $responseCode);
    }

    public function setToRead(Request $request)
    {
        $responseCode = 403;
        $responseStatus = '';
        $responseMessage = '';
        $responseData = [];
        $responseNote = [];

        $id_notifikasi = $request->input('id_notifikasi');
        $access_token = $request->header('access-token')? $request->header('access-token') : $request->input('access_token');
        $user = User::get_by_access_token($access_token);

        if(!empty($id_notifikasi)){
            $get_notifikasi = Notifikasi::get_data($id_notifikasi, false);
            if(!empty($get_notifikasi) && $get_notifikasi->id_receiver == $user->id_user){
                Notifikasi::where('ntf_id', $get_notifikasi->id_notifikasi)->update(['ntf_read' => true, 'ntf_read_at' => date('Y-m-d H:i:s')]);
                $responseCode = 200;
            }else{
                $responseCode = 400;
                $responseMessage = 'Data tidak ditemukan';
            }
        }else{
            Notifikasi::where('ntf_receiver_id', $user->id_user)->update(['ntf_read' => true, 'ntf_read_at' => date('Y-m-d H:i:s')]);
            $responseCode = 200;
        }
        

        $response = helpResponse($responseCode, $responseData, $responseMessage, $responseStatus, $responseNote);
        return response()->json($response, $responseCode);
    }

    public static function send_notification($sender, $receiver, $message, $category=false, $unique_id=false, $action='notif')
    {
        $arr_receiver = is_array($receiver)? $receiver : array($receiver);
        $response   = [];
        $temp       = [];
        $title      = app_info('name');
        $time       = date('Y-m-d H:i:s');

        foreach ($arr_receiver as $key => $value) {
            if(!empty($value) && !in_array($value, $temp)){
                $temp[] = $value;

                $m_notif = new Notifikasi();

                $m_notif->ntf_sender_id = $sender;
                $m_notif->ntf_receiver_id = $value;
                $m_notif->ntf_action = $action;
                $m_notif->ntf_message = $message;
                $m_notif->ntf_category = $category;
                $m_notif->ntf_unique_id = $unique_id;
                $m_notif->save();

                $id = $m_notif->ntf_id;

                $get_token = UserToken::get_data(false, $value, true);
                foreach ($get_token as $key => $data) {
                    $device_token = array($data->device_token);

                    $firebase_data =  array(
                        "title"     => $title,
                        "message"   => $message,
                        "time"      => $time,
                        "id"        => encText($id.'notif', true),
                        "action"    => $action,
                        "category"  => $category,
                        "unique_id"  => $unique_id,
                    );

                    $proses = send_firebase($device_token, $firebase_data);
                    $proses = json_decode($proses);

                    if(!empty($proses) && $proses->success > 0){
                        $m_notif->ntf_sent = true;
                        $m_notif->ntf_sent_at = $time;
                        $m_notif->save();
                    }

                    $response[] = ['data' => $firebase_data, 'proses' => $proses];
                }
            }
        }

        return $response;        
    }
}
