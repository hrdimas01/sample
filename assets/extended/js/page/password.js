var ajaxUrlPassword = baseUrl+'/password/',
laddaButtonPassword;

$(document).ready(function() {
    $('#btn_save_password').on('click', function(e){
        e.preventDefault();
        laddaButtonPassword = Ladda.create(this);
        laddaButtonPassword.start();
        $('#id_user').val(idUser);
        simpan_password();
    });

    $('.input-password').on("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            $("#btn_save_password").click();
        }
    });
});

function modal_password() {
    reset_form_password();
    $('#id_user').val(idUser);
    $('#btn_save_password').html('Simpan');
    $('#modal_password').modal({backdrop:'static', keyboard:false}, 'show');
}

function simpan_password() {
    // var file = new FormData($("#form1")[0]);
    var data = $("#formPassword").serializeArray();
    $.ajax({
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajaxUrlPassword+"json_save",
        data:data,
        // contentType: false,
        // cache: false,
        // processData:false,
        beforeSend: function() {
            preventLeaving();
            $('.btn_close_modal').addClass('hide');
            $('.se-pre-con').show();
        },
        success:function(response){
            laddaButtonPassword.stop();
            window.onbeforeunload = false;
            $('.btn_close_modal').removeClass('hide');
            $('.se-pre-con').hide();

            var obj = response;

            if(obj.status == "OK"){
                swal('Ok', obj.message, 'success');
                $('#modal_password').modal('hide');
            } else {
                swal('Pemberitahuan', obj.message, 'warning');
            }

        },
        error: function(response) {
            var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
            laddaButtonPassword.stop();
            window.onbeforeunload = false;
            $('.btn_close_modal').removeClass('hide');
            $('.se-pre-con').hide();            

            if(response['status'] != 404 && response['status'] != 401 && response['status'] != 500 ){
                var obj = JSON.parse(response['responseText']);

                if(!$.isEmptyObject(obj.message)){
                    if(obj.code > 400){
                        head = 'Maaf';
                        message = obj.message;
                        type = 'error';
                    }else{
                        head = 'Pemberitahuan';
                        message = obj.message;
                        type = 'warning';
                    }
                }
            }else if(response['status'] == 401){
                location.reload();
            }

            swal(head, message, type);
        }
    });
}

function reset_form_password(method='') {
    $('#pasword_lama').val('');
    $('#pasword_lama').change();
    $('#password_baru').val('');
    $('#password_baru').change();
    $('#conf_password_baru').val('');
    $('#conf_password_baru').change();
}