var tableData, myDropzone, fileCounter=0,
tableTarget = '#table1',
ajaxUrl = baseUrl+'/mahasiswa/',
ajaxSource = ajaxUrl+'json_grid',
laddaButton, laddaUploadButton
;

$(document).ready(function() {
	load_table();
	init_dropzone();
	swicthUploadMethod();

	protectNumber('#nim, #hp', 15);
	protectString('#nama', 150);

	$('#tanggal_lahir').datepicker({
		format : 'dd/mm/yyyy',
		endDate: new Date((date.getFullYear() - 14), date.getMonth(), date.getDate())
	});

	if(typeof tableData !== 'undefined'){
		tableData.on('draw.dt', function() {
			$('[data-toggle=tooltip]').tooltip();
		});
	}

	$('#btn_save').on('click', function(e){
		e.preventDefault();
		laddaButton = Ladda.create(this);
		laddaButton.start();
		simpan();
	});

	$('#btn_upload').on('click', function(e){
		e.preventDefault();
		laddaUploadButton = Ladda.create(this);
		laddaUploadButton.start();
		upload();
	});

	$('.input-mahasiswa').on("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$("#btn_save").click();
		}
	});

	$('.upload_method').on('change', function () {
		swicthUploadMethod();
	});
});

function load_table() {
	tableData = $(tableTarget).DataTable({
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bStateSave": false,
		"bDestroy": true,
		"processing": true,
		"serverSide": true,
		"ajax":{
			url: ajaxSource,
			type: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			error: function(response) {
				var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
				window.onbeforeunload = false;
				$('.btn_close_modal').removeClass('hide');
				$('.se-pre-con').hide();            

				if(response['status'] == 401 || response['status'] == 419){
					location.reload();
				}else{
					if(response['status'] != 404 && response['status'] != 500 ){
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
					}

					swal(head, message, type);
				}
			}
		},
		"sPaginationType": "full_numbers",
		"aoColumns": [
		{ "mData": "id_mahasiswa" },
		{ "mData": "nim" },
		{ "mData": "nama" },
		{ "mData": "alamat" },
		{ "mData": "tanggal_lahir" },
		{ "mData": "hp" },
		{ "mData": "aktif" },
		{ "mData": "id_mahasiswa" }
		],
		"aaSorting": [[1, 'asc']],
		"lengthMenu": [ 10, 25, 50, 75, 100 ],
		"pageLength": 10,
		"aoColumnDefs": [
		{
			"aTargets": [0],
			"mData":"id_mahasiswa",
			"mRender": function (data, type, full, draw) {
				var row = draw.row;
				var start = draw.settings._iDisplayStart;
				var length = draw.settings._iDisplayLength;

				var counter = (start  + 1 + row);

				return counter;
			}
		},
		{
			"aTargets": [6],
			"mData":"aktif",
			"mRender": function (data, type, full) {
				let checked ='';
				if(full.aktif == true){
					checked = 'checked="checked"';
				}

				let switchBtn = '<span class="m-switch m-switch--icon m-switch--primary"><label><input type="checkbox" '+checked+' name="aktif" id="aktif-'+full.id_mahasiswa+'" onchange="switch_status(\''+full.id_mahasiswa+'\')"><span></span></label></span>';

				return switchBtn;
			}
		},
		{
			"aTargets": [7],
			"mData":"id_mahasiswa",
			"mRender": function (data, type, full) {
				var btn_action = '\
				<button type="button" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" onclick="edit(\''+full.id_mahasiswa+'\')" data-toggle="tooltip" title="Edit">\
				<i class="fa fa-edit"></i>\
				</button>\
				<button type="button" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x m-btn--pill m-btn--air" onclick="modal_foto(\''+full.id_mahasiswa+'\')" data-toggle="tooltip" title="Foto">\
				<i class="fa fa-camera"></i>\
				</button>\
				';

				return btn_action;
			}
		}
		],
		"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
			$(nHead).children('th:nth-child(1), th:nth-child(3), th:nth-child(4)').addClass('text-center');
		},
		"fnFooterCallback": function( nFoot, aData, iStart, iEnd, aiDisplay ) {
			$(nFoot).children('th:nth-child(1), th:nth-child(3), th:nth-child(4)').addClass('text-center');
		},
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			$(nRow).children('td:nth-child(1),td:nth-child(3),td:nth-child(4),td:nth-child(5)').addClass('text-center');
		}
	});

	$(tableTarget).closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
		minimumResultsForSearch: -1
	});
}

function tambah() {
	resetForm();
	$('#id_mahasiswa').val('');
	$('#action').val('add');
	$('#btn_save').html('Tambah Data');
	$('#modal_form .modal-title').html('Tambah Data mahasiswa');
	$('#modal_form .modal-info').html('Isilah form dibawah ini untuk menambahkan data terkait master mahasiswa.');
	$('#modal_form').modal('show');

	$('#modal_form').modal({backdrop:'static', keyboard:false}, 'show');
}

function edit(id_mahasiswa='') {
	resetForm();
	$('#id_mahasiswa').val(id_mahasiswa);
	$('#action').val('edit');
	$('#btn_save').html('Simpan Data');
	$('#modal_form .modal-title').html('Edit Data mahasiswa');
	$('#modal_form .modal-info').html('Isilah form dibawah ini untuk mengubah data master mahasiswa sesuai kebutuhan.');

	$.ajax({
		type:"GET",
		url: ajaxUrl+"json_get/"+id_mahasiswa,
		beforeSend: function() {
			preventLeaving();
			$('.btn_close_modal').addClass('hide');
			$('.se-pre-con').show();
		},
		success:function(response){
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();

			var obj = response;

			if(obj.status == "OK"){
				$('#nim').val(obj.data.mahasiswa['nim']);
				$('#nama').val(obj.data.mahasiswa['nama']);
				$('#alamat').val(obj.data.mahasiswa['alamat']);
				$('#hp').val(obj.data.mahasiswa['hp']);
				$('#tanggal_lahir').datepicker('setDate', helpDateFormat(obj.data.mahasiswa['tanggal_lahir'], 'mi'));

				$('#modal_form').modal({backdrop:'static', keyboard:false}, 'show');
			} else {
				swal('Pemberitahuan', obj.message, 'warning');
			}

		},
		error: function(response) {
			var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();

			if(response['status'] == 401 || response['status'] == 419){
				location.reload();
			}else{
				if(response['status'] != 404 && response['status'] != 500 ){
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
				}

				swal(head, message, type);
			}
		}
	});
}

function simpan() {
    // var file = new FormData($("#form1")[0]);
    var data = $("#form1").serializeArray();
    $.ajax({
    	type:"POST",
    	headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
    	url: ajaxUrl+"json_save",
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
        	laddaButton.stop();
        	window.onbeforeunload = false;
        	$('.btn_close_modal').removeClass('hide');
        	$('.se-pre-con').hide();

        	var obj = response;

        	if(obj.status == "OK"){
        		tableData.ajax.reload();
        		swal('Ok', obj.message, 'success');
        		$('#modal_form').modal('hide');
        	} else {
        		swal('Pemberitahuan', obj.message, 'warning');
        	}

        },
        error: function(response) {
        	var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
        	window.onbeforeunload = false;
        	$('.se-pre-con').hide();
        	$('.btn_close_modal').removeClass('hide');
        	laddaButton.stop();

        	if(response['status'] == 401 || response['status'] == 419){
        		location.reload();
        	}else{
        		let error_log = '';
        		if(response['status'] != 404 && response['status'] != 401 && response['status'] != 500 ){
        			var obj = JSON.parse(response['responseText']);

        			if(!$.isEmptyObject(obj.data.error_log)){
        				error_log = obj.data.error_log;
        			}

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
        		}

        		if(error_log != ''){
        			let listError = '<ul style="text-align:left;">';
        			for (var key in error_log) {

        				for (var i = 0; i < error_log[key].length; i++) {
        					listError += '<li>'+error_log[key][i]+'</li>';
        				}

        			}
        			listError += '</ul>';

        			let detail_error = '<div class="m-accordion m-accordion--default m-accordion--solid m-accordion--section  m-accordion--toggle-arrow" style="margin-top:5px;margin-bottom:-15px;" id="swal-error-log" role="tablist">\
        			<div class="m-accordion__item">\
        			<div class="m-accordion__item-head collapsed" role="tab" id="swal-error-log_item_1_head" data-toggle="collapse" href="#swal-error-log_item_1_body" aria-expanded="false">\
        			<span class="m-accordion__item-title">Detail error</span>\
        			<span class="m-accordion__item-mode"></span>\
        			</div>\
        			<div class="m-accordion__item-body collapse" id="swal-error-log_item_1_body" role="tabpanel" aria-labelledby="swal-error-log_item_1_head" data-parent="#swal-error-log" style="">\
        			<div class="m-accordion__item-content">'+listError+'</div>\
        			</div>\
        			</div>\
        			</div>';

        			message += detail_error;

        			swal(head, message, type);
        		}else{
        			swal(head, message, type);
        		}
        	}
        }
    });
}

function switch_status(id_mahasiswa='') {
	var aktif = $('#aktif-'+id_mahasiswa).prop('checked');

	if(aktif == true){
		aktif = 't';
	}else{
		aktif = 'f';
	}

	$.ajax({
		type:"POST",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: ajaxUrl+"json_set_status",
		data:{id_mahasiswa:id_mahasiswa, aktif:aktif},
		beforeSend: function() {
			preventLeaving();
			$('.btn_close_modal').addClass('hide');
			$('.se-pre-con').show();
		},
		success:function(response){
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();

			var obj = response;

			if(obj.status == "OK"){
				toastr.success(obj.message);
			} else {
				swal('Pemberitahuan', obj.message, 'warning');

				if(aktif == 't'){
					$('#aktif-'+id_mahasiswa).prop('checked', true);
				}else{
					$('#aktif-'+id_mahasiswa).prop('checked', false);
				}
			}

		},
		error: function(response) {
			var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();

			if(aktif == 't'){
				$('#aktif-'+id_mahasiswa).prop('checked', true);
			}else{
				$('#aktif-'+id_mahasiswa).prop('checked', false);
			}

			if(response['status'] == 401 || response['status'] == 419){
				location.reload();
			}else{
				if(response['status'] != 404 && response['status'] != 500 ){
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
				}

				swal(head, message, type);
			}
		}
	});
}

function resetForm(method='') {
	$('#id_mahasiswa').val('');
	$('#id_mahasiswa').change();
	$('#nama').val('');
	$('#nama').change();
	$('#nim').val('');
	$('#nim').change();
	$('#alamat').val('');
	$('#alamat').change();
	$('#hp').val('');
	$('#hp').change();
	$('#tanggal_lahir').datepicker('setDate', null);
}


function modal_foto(id_mahasiswa) {
	$('#foto_id_mahasiswa').val(id_mahasiswa);
	$('#foto_id_mahasiswa').change();

	$('#file').val('');
	$('#file').change();
	myDropzone.removeAllFiles(true);

	$('.field-upload').hide();
	$('.upload_method').prop('checked', false);
	$('.item-file').remove();

	$('#modal_foto').modal({backdrop:'static', keyboard:false}, 'show');
	loadFile(id_mahasiswa);
}

function loadFile(id_mahasiswa) {
	$.ajax({
		type:"GET",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: ajaxUrl+"json_load_file/"+id_mahasiswa,
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function() {
			preventLeaving();
			$('.btn_close_modal').addClass('hide');
			$('.se-pre-con').show();
			$('.form-control-danger').removeClass('form-control-danger');
		},
		success:function(response){
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();

			var obj = response;

			if(obj.status == "OK"){
				let template = '';
				for (var i = 0; i < obj.data.file.length; i++) {
					let rowData = obj.data.file[i];

					template += '<div class="col-md-6 item-file" id="item-file-'+rowData['id_file']+'">\
					<img class="img-file" src="'+baseUrl+'watch/'+rowData['nama_file']+'?un='+rowData['id_file']+'&prt='+rowData['id_mahasiswa']+'&ctg=mahasiswa&src=thumbnail-250x250_'+rowData['path_file']+'">\
					<button type="button" class="btn btn-danger" onclick="hapusFile(\''+rowData['id_file']+'\')">Hapus Foto</button>\
					</div>';	
				}

				$('#list-file').html(template);

			} else {
				swal('Pemberitahuan', obj.message, 'warning');
			}

		},
		error: function(response) {
			var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();            

			if(response['status'] == 401 || response['status'] == 419){
				location.reload();
			}else{
				if(response['status'] != 404 && response['status'] != 500 ){
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
				}

				swal(head, message, type);
			}
		}
	});
}

function hapusFile(id_file) {
	swal({
		title: "Konfirmasi?",
		text: "Apakah Anda yakin akan menghapus foto ini?",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn btn-danger m-btn m-btn--custom",
		confirmButtonText: "Ya, lanjutkan!",
		cancelButtonText: "Tidak, batalkan!"
	}).then(function(isConfirm) {
		if (isConfirm['value']) {
			$.ajax({
				type:"POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: ajaxUrl+"json_remove_file",
				data: {id_file:id_file},
				beforeSend: function() {
					preventLeaving();
					$('.btn_close_modal').addClass('hide');
					$('.se-pre-con').show();
				},
				success:function(response){
					window.onbeforeunload = false;
					$('.btn_close_modal').removeClass('hide');
					$('.se-pre-con').hide();

					var obj = response;

					if(obj.status == "OK"){
						$('#item-file-'+id_file).remove();
						$('[role=tooltip]').remove();
						swal('OK', obj.message, 'success');
					} else {
						swal('Pemberitahuan', obj.message, 'warning');
					}

				},
				error: function(response) {
					var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
					window.onbeforeunload = false;
					$('.btn_close_modal').removeClass('hide');
					$('.se-pre-con').hide();            

					if(response['status'] == 401 || response['status'] == 419){
						location.reload();
					}else{
						if(response['status'] != 404 && response['status'] != 500 ){
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
						}

						swal(head, message, type);
					}
				}
			});
		}
	});
}

function swicthUploadMethod() {
	$('.field-upload').hide();

	let $uploadMethod = $('.upload_method');

	for (var i = 0; i < $uploadMethod.length; i++) {
		let currentId = $uploadMethod[i];

		if($(currentId).val() == '1' && $(currentId).prop('checked') == true){
			$('#field-native').show();
		}else if($(currentId).val() == '2' && $(currentId).prop('checked') == true){
			$('#field-dropzone').show();
		}
	}
}

function init_dropzone() {
	myDropzone = new Dropzone("#dropzone_foto", {
		url: ajaxUrl+"upload_file",
		dictCancelUpload: "Cancel",
		maxFilesize: 2,
		parallelUploads: 1,
		maxFiles: 1,
		addRemoveLinks: true,
		acceptedFiles: '.jpg,.jpeg,.png',
        // acceptedFiles: 'image/*,application/pdf', 
        autoProcessQueue:false,
        init:function(){
        	this.on("error", function(file){
        		if (!file.accepted){
        			this.removeFile(file);
        			swal('Pemberitahuan', 'Silahkan periksa file Anda lagi', 'warning');
        		}else if(file.status == 'error'){
        			this.removeFile(file);
        			swal('Maaf', 'Terjadi kesalahan koneksi', 'error');
        		}
        	});

        	this.on('resetFiles', function(file) {
        		this.removeAllFiles();
        	});
        },
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
}

function upload() {
	let $uploadMethod = $('.upload_method');

	for (var i = 0; i < $uploadMethod.length; i++) {
		let currentId = $uploadMethod[i];

		if($(currentId).val() == '1' && $(currentId).prop('checked') == true){
			native_exec();
		}else if($(currentId).val() == '2' && $(currentId).prop('checked') == true){
			myDropzone.options.url = ajaxUrl+'json_upload/'+$('#foto_id_mahasiswa').val();
			dropzone_exec();
		}
	}
}

function native_exec() {
	var file = new FormData($("#form2")[0]);
	let id_mahasiswa = $('#foto_id_mahasiswa').val();
	$.ajax({
		type:"POST",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: ajaxUrl+"json_upload/"+id_mahasiswa,
		data:file,
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function() {
			preventLeaving();
			$('.btn_close_modal').addClass('hide');
			$('.se-pre-con').show();
			$('.form-control-danger').removeClass('form-control-danger');
		},
		success:function(response){
			laddaUploadButton.stop();
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();

			var obj = response;

			if(obj.status == "OK"){
				swal('Ok', obj.message, 'success');
				$('#file').val('');
				$('#file').change();
			} else {
				swal('Pemberitahuan', obj.message, 'warning');
			}

		},
		error: function(response) {
			var head = 'Maaf', message = 'Terjadi kesalahan koneksi', type = 'error';
			laddaUploadButton.stop();
			window.onbeforeunload = false;
			$('.btn_close_modal').removeClass('hide');
			$('.se-pre-con').hide();            

			if(response['status'] == 401 || response['status'] == 419){
				location.reload();
			}else{
				if(response['status'] != 404 && response['status'] != 500 ){
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
				}

				swal(head, message, type);
			}
		}
	});
}

function dropzone_exec() {
	$('.btn_close_modal').addClass('hide');
	$('.se-pre-con').show();
	$('.form-control-danger').removeClass('form-control-danger');

	if(typeof myDropzone != 'undefined'){
		if(!$.isEmptyObject(myDropzone.files)){
			fileCounter = myDropzone.files.length;
			myDropzone.processQueue();
			myDropzone.on("complete", function(file) {
				fileCounter--;
				if(file.status != 'success'){
					if(fileCounter == 0){
						window.onbeforeunload = false;
						$('.se-pre-con').hide();
						$('.btn_close_modal').removeClass('hide');
						laddaUploadButton.stop();
					}

					swal('Maaf', 'Terjadi kesalahan koneksi', 'error');
				}else{
					if(fileCounter == 0){
						window.onbeforeunload = false;
						$('.se-pre-con').hide();
						$('.btn_close_modal').removeClass('hide');
						$('#modal_foto').modal('hide');
						swal('Ok', 'Data berhasil disimpan', 'success');
						laddaUploadButton.stop();
					}
				}
				this.removeFile(file);
			});
		}else{
			window.onbeforeunload = false;
			$('.se-pre-con').hide();
			$('.btn_close_modal').removeClass('hide');
			$('#modal_foto').modal('hide');
			swal('Ok', 'Data berhasil disimpan', 'success');
			laddaUploadButton.stop();
		}
	}else{
		window.onbeforeunload = false;
		$('.se-pre-con').hide();
		$('.btn_close_modal').removeClass('hide');
		$('#modal_foto').modal('hide');
		swal('Ok', 'Data berhasil disimpan', 'success');
		laddaUploadButton.stop();
	}
}