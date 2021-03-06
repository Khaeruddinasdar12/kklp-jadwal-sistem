@extends('layouts.template')

@section('title')
Manage Jadwal
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
</div>
<!-- /.content-header -->
<section class="content">
	<div class="row">
		<div class="col-12">

			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><i class="fa fa-calendar-week"></i> List Jadwal</h2>
					<button data-toggle='modal' data-target='#modal-add-jadwal' title='Tambah Jadwal' class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"> Tambah Jadwal</i></button>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_jadwal" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama</th>
									<th>Ruangan</th>
									<th>Waktu</th>
									<th>Departemen</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>  
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->

<!-- Modal Tambah Jadwal -->
<div class="modal fade bd-example-modal-lg" id="modal-add-jadwal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-calendar-minus"></i> Tambah Jadwal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="add-jadwal" action="{{route('jadwal.store')}}">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Acara</label>
						<input type="text" name="nama" class="form-control">
					</div>
					<div class="form-group">
						<label>Ruangan</label>
						<input type="text" name="ruangan" class="form-control">
					</div>
					<div class="form-group">
						<label>Departemen</label>
						@foreach($dpt as $dt) 
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="departemen[]" value="{{$dt->id}}">
							<label class="form-check-label">
								{{$dt->nama}}
							</label>
						</div>
						@endforeach
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<label>Tanggal</label>
							<input type="date" name="waktu" class="form-control" min="<?php echo date('Y-m-d'); ?>">
						</div>
						<div class="col-md-3">
							<label>Jam</label>
							<select name="jam" class="form-control">
								@for ($i = 0; $i < 24; $i++)
								<option value="{{$i}}" >{{$i}}</option>
								@endfor
							</select>
						</div>
						<div class="col-md-3">
							<label>Menit</label>
							<select name="menit" class="form-control">
								@for ($i = 0; $i < 60; $i++)
								<option value="{{$i}}" >{{$i}}</option>
								@endfor
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea name="deskripsi" class="form-control" rows="4"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary btn-sm">Tutup</button>
					<button type="submit" class="btn btn-primary btn-sm">Submit</button>
				</div>
			</form>
		</div>
	</form>
</div>
</div>
<!-- End Modal Tambah Jadwal -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">

	$('#add-jadwal').submit(function(e){ // tambah jadwal
		e.preventDefault();

		var request = new FormData(this);
		var endpoint= '{{route("jadwal.store")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
            // dataType: "json",
            success:function(data){
            	$('#add-jadwal')[0].reset();
            	$('#modal-add-jadwal').modal('hide');
            	$('#tabel_jadwal').DataTable().ajax.reload();
            	berhasil(data.status, data.pesan);
            },
            error: function(xhr, status, error){
            	var error = xhr.responseJSON; 
            	if ($.isEmptyObject(error) == false) {
            		$.each(error.errors, function(key, value) {
            			gagal(key, value);
            		});
            	}
            } 
          }); 
	});

function hapus_data() { // menghapus jadwal
	$(document).on('click', '#del_id', function(){
		Swal.fire({
			title: 'Anda Yakin ?',
			text: "Anda tidak dapat mengembalikan data yang telah di hapus!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Lanjutkan Hapus!',
			timer: 6500
		}).then((result) => {
			if (result.value) {
				var me = $(this),
				url = me.attr('href'),
				token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url: url,
					method: "POST",
					data : {
						'_method' : 'DELETE',
						'_token'  : token
					},
					success:function(data){
						$('#tabel_jadwal').DataTable().ajax.reload();
						berhasil(data.status, data.pesan);
					},
					error: function(xhr, status, error){
						var error = xhr.responseJSON; 
						if ($.isEmptyObject(error) == false) {
							$.each(error.errors, function(key, value) {
								gagal(key, value);
							});
						}
					} 
				});
			}
		});
	});
}

function selesai() { // ubah status jadwal menjadi selesai
	$(document).on('click', '#jadwal_id', function(){
		Swal.fire({
			title: 'Anda Yakin ?',
			text: "Anda tidak dapat mengembalikan jadwal yang telah diselesaikan.",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Lanjutkan!',
			timer: 6500
		}).then((result) => {
			if (result.value) {
				var me = $(this),
				url = me.attr('href'),
				token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url: url,
					method: "POST",
					data : {
						'_method' : 'PUT',
						'_token'  : token
					},
					success:function(data){
						$('#tabel_jadwal').DataTable().ajax.reload();
						berhasil(data.status, data.pesan);
					},
					error: function(xhr, status, error){
						var error = xhr.responseJSON; 
						if ($.isEmptyObject(error) == false) {
							$.each(error.errors, function(key, value) {
								gagal(key, value);
							});
						}
					} 
				});
			}
		});
	});
}

tabel = $(document).ready(function(){
	$('#tabel_jadwal').DataTable({
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.jadwal")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nama" },
              { "data": "ruangan" },
              { "data": "waktu" },
              { "data": "departemen" },
              { "data": "status" },
              { "data": "action" },
              ]
            });
});

function berhasil(status, pesan) {
	Swal.fire({
		type: status,
		title: pesan,
		showConfirmButton: true,
		button: "Ok"
	})
}

function gagal(key, pesan) {
	Swal.fire({
		type: 'error',
		title:  key + ' : ' + pesan,
		showConfirmButton: true,
		timer: 25500,
		button: "Ok"
	})
}
</script>
@endsection