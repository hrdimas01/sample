@extends('layout')
@section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-content">
		<div class="row">
			<div class="col-md-12">
				<!--begin::Portlet-->
				<div class="m-portlet">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Mahasiswa
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<button type="button" class="btn btn-log m-btn m-btn--icon m-btn--pill" onclick="tambah()">
										<span>
											<i class="la la-plus"></i>
											<span>
												Tambah Data
											</span>
										</span>
									</button>
								</li>
							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<table class="table table-hover table-checkable table-custom-striped" id="table1" style="width: 100%;">
							<thead>
								<tr>
									<th data-orderable="false">No</th>
									<th>NIM</th>
									<th>Nama</th>
									<th>Alamat</th>
									<th>Tanggal Lahir</th>
									<th>HP</th>
									<th>Aktif</th>
									<th class="text-center" style="width: 75px;" data-orderable="false">#</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<!--end::Portlet-->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Data Mahasiswa</h5>
				<button type="button" class="close btn_close_modal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form1" action="" method="post" onsubmit="return false;">
					<input type="hidden" name="action" id="action" value="add">
					<input type="hidden" name="id_mahasiswa" id="id_mahasiswa" value="">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group m-form__group">
								<label>NIM Mahasiswa</label>
								<input type="text" class="form-control m-input input-mahasiswa" name="nim" id="nim" placeholder="Masukkan NIM Mahasiswa" autocomplete="off">
							</div>
							<div class="form-group m-form__group">
								<label>Nama Mahasiswa</label>
								<input type="text" class="form-control m-input input-mahasiswa" name="nama" id="nama" placeholder="Masukkan Nama Mahasiswa" autocomplete="off">
							</div>
							<div class="form-group m-form__group">
								<label>Alamat Mahasiswa</label>
								<input type="text" class="form-control m-input input-mahasiswa" name="alamat" id="alamat" placeholder="Masukkan Alamat Mahasiswa" autocomplete="off">
							</div>
							<div class="form-group m-form__group">
								<label>Tanggal Lahir</label>
								<input type="text" class="form-control m-input input-mahasiswa" name="tanggal_lahir" id="tanggal_lahir" placeholder="Masukkan Tanggal Lahir" readonly="" autocomplete="off">
							</div>
							<div class="form-group m-form__group">
								<label>HP Mahasiswa</label>
								<input type="text" class="form-control m-input input-mahasiswa" name="hp" id="hp" placeholder="Masukkan HP Mahasiswa" autocomplete="off">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary uppercase btn_close_modal" data-dismiss="modal">tutup</button>
				<button type="button" class="btn btn-success uppercase ladda-button" data-style="zoom-in" id="btn_save">SIMPAN</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Form Upload Foto Mahasiswa</h5>
				<button type="button" class="close btn_close_modal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="m-form__group form-group">
							<label for="">
								Pilih tipe form upload
							</label>
							<div class="m-radio-inline">
								<label class="m-radio">
									<input type="radio" name="upload_method" class="upload_method" value="1">
									Native
									<span></span>
								</label>
								<label class="m-radio">
									<input type="radio" name="upload_method" class="upload_method" value="2">
									Dropzone
									<span></span>
								</label>

							</div>
						</div>
					</div>
					<input type="hidden" name="foto_id_mahasiswa" id="foto_id_mahasiswa" value="">
					<div class="col-md-12 field-upload" id="field-native">
						<form id="form2" action="" method="post" onsubmit="return false;" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group m-form__group">
										<input type="file" class="custom-file-input" name="file" id="file" accept=".jpg,.jpeg,.png" onchange="cekFileGambar(this, this.value)">
										<label class="custom-file-label" for="file">
											Pilih file
										</label>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-12 field-upload" id="field-dropzone">
						<div class="m-dropzone dropzone m-dropzone--primary dz-clickable" action="" id="dropzone_foto">
							<div class="m-dropzone__msg dz-message needsclick">
								<h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
								<span class="m-dropzone__msg-desc">
									Only jpg, jpeg and png format with maximum size 2MB are allowed.
								</span>
							</div>
						</div>
					</div>
				</div>

				<hr>

				<!-- <div class="row">
					<div class=""></div>
					<h4>List File</h4>
				</div> -->

				<div class="row" id="list-file"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary uppercase btn_close_modal" data-dismiss="modal">tutup</button>
				<button type="button" class="btn btn-success uppercase ladda-button" data-style="zoom-in" id="btn_upload">SIMPAN</button>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.item-file{
		padding: 5px;
	}

	.img-file{
		width: 100%;
	}
</style>
<script type="text/javascript">
	setMenu('#menu-mahasiswa');
</script>
<script type="text/javascript" src="{{aset_extends('js/page/mahasiswa-grid.js')}}"></script>

@endsection()