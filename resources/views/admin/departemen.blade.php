@extends('layouts.template')

@section('title')
Manage Departemen
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
					<h2 class="card-title"><i class="fa fa-tag"></i> List Departemen</h2>
					<button data-toggle='modal' data-target='#modal-add-departemen' title='Tambah Departemen' class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"> Tambah Departemen</i></button>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_departemen" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama</th>
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


<!-- Modal Tambah Departemen -->
<div class="modal fade bd-example-modal-lg" id="modal-add-departemen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-tag"></i> Tambah Departemen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="add-departemen">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Departemen</label>
						<input type="text" name="nama" class="form-control">
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
<!-- End Modal Tambah Departemen -->


<!-- Modal Edit Departemen -->
<div class="modal fade bd-example-modal" id="modal-edit-departemen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="post" id="edit-departemen">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Departemen </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hidden_id" id="edit-departemen-id">
					<div class="form-group">
						<label>Nama Departemen</label>
						<input type="text" class="form-control" name="nama" id="nama-departemen">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary btn-sm">Edit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Modal Edit Departemen -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
	$('#modal-edit-departemen').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) 
		var id = button.data('id') 
		var nama = button.data('nama')

		var modal = $(this)
		modal.find('.modal-body #edit-departemen-id').val(id)
		modal.find('.modal-body #nama-departemen').val(nama)
		// modal.find('.modal-body #lokasi').val(lokasi)
	})

	$('#add-departemen').submit(function(e){ // tambah pegawai
		e.preventDefault();

		var request = new FormData(this);
		var endpoint= '{{route("departemen.store")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
            // dataType: "json",
            success:function(data){
            	$('#add-departemen')[0].reset();
            	$('#modal-add-departemen').modal('hide');
            	$('#tabel_departemen').DataTable().ajax.reload();
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


	$('#edit-departemen').submit(function(e){ //edit jurusan
		e.preventDefault();
		var request = new FormData(this);
		var endpoint= '{{route("departemen.update")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
            // dataType: "json",
            success:function(data){
            	if(data.status == 'error') {

            	} else {
            		$('#edit-departemen')[0].reset();
            		$('#tabel_departemen').DataTable().ajax.reload();
            		$('#modal-edit-departemen').modal('hide');
            	}
            	
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


function hapus_data() { // menghapus jurusan
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
						if(data.status == 'error') {

						} else {
							$('#tabel_departemen').DataTable().ajax.reload();
						}
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
	$('#tabel_departemen').DataTable({
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.departemen")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nama" },
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