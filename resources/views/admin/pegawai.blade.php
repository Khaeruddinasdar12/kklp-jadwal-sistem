@extends('layouts.template')

@section('title')
Manage Pegawai
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
					<h2 class="card-title"><i class="fa fa-users"></i> List Pegawai</h2>
					<button data-toggle='modal' data-target='#modal-add-pegawai' title='Tambah Pegawai' class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"> Tambah Pegawai</i></button>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_pegawai" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nip</th>
									<th>Nama</th>
									<th>Departemen</th>
									<th>Email</th>
									<th>No HP</th>
									<th>Alamat</th>
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


<!-- Modal Tambah Pegawai -->
<div class="modal fade bd-example-modal-lg" id="modal-add-pegawai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user-plus"></i> Tambah Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="add-pegawai">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label>NIP</label>
						<input type="text" name="nip" class="form-control">
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="nama" class="form-control">
					</div>
					<div class="form-group">
						<label>Departemen</label>
						<select class="form-control" name="departemen">
							<option value="">pilih departemen</option>
							@foreach($data as $dt)
							<option value="{{$dt->id}}">{{$dt->nama}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control">
					</div>
					<div class="form-group">
						<label>No HP</label>
						<input type="text" name="nohp" class="form-control">
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea name="alamat" class="form-control" rows="4"></textarea>
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
<!-- End Modal Tambah Pegawai -->


<!-- Modal Tambah Pegawai -->
<div class="modal fade bd-example-modal-lg" id="modal-edit-pegawai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user-plus"></i> Edit Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="edit-pegawai">
				@csrf
				<div class="modal-body">
					<input type="hidden" name="hidden_id" id="edit-pegawai-id">
					<div class="form-group">
						<label>NIP</label>
						<input type="text" name="nip" id="nip" class="form-control">
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="nama" id="nama" class="form-control">
					</div>
					<div class="form-group">
						<label>Departemen</label>
						<select class="form-control" id="departemen" name="departemen">
							<option value="">pilih departemen</option>
							@foreach($data as $dt)
							<option value="{{$dt->id}}">{{$dt->nama}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" id="email" class="form-control">
					</div>
					<div class="form-group">
						<label>No HP</label>
						<input type="text" name="nohp" id="nohp" class="form-control">
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea name="alamat" id="alamat" class="form-control" rows="4"></textarea>
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
<!-- End Modal Tambah Pegawai -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
	$('#modal-edit-pegawai').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) 
		var id = button.data('id')
		var nip = button.data('nip')  
		var nama = button.data('nama')
		var email = button.data('email')
		var nohp = button.data('nohp')   
		var alamat = button.data('alamat') 
		var departemen = button.data('departemen')

		var modal = $(this)
		modal.find('.modal-body #edit-pegawai-id').val(id)
		modal.find('.modal-body #nip').val(nip)
		modal.find('.modal-body #nama').val(nama)
		modal.find('.modal-body #email').val(email)
		modal.find('.modal-body #nohp').val(nohp)
		modal.find('.modal-body #alamat').val(alamat)
		modal.find('.modal-body #departemen').val(departemen)
	})

	$('#add-pegawai').submit(function(e){ // tambah pegawai
		e.preventDefault();

		var request = new FormData(this);
		var endpoint= '{{route("pegawai.store")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
            // dataType: "json",
            success:function(data){
            	$('#add-pegawai')[0].reset();
            	$('#modal-add-pegawai').modal('hide');
            	$('#tabel_pegawai').DataTable().ajax.reload();
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
						$('#tabel_pegawai').DataTable().ajax.reload();
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
	$('#tabel_pegawai').DataTable({
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.pegawai")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nip" },
              { "data": "nama" },
              { "data": "departemen.nama" },
              { "data": "email" },
              { "data": "nohp" },
              { "data": "alamat" },
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