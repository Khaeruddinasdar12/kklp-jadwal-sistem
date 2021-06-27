@extends('layouts.template')

@section('title')
Manage Admin
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
					<h2 class="card-title"><i class="fa fa-users"></i> List Admin</h2>
					<button data-toggle='modal' data-target='#modal-add-admin' title='Tambah Admin' class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"> Tambah Admin</i></button>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama</th>
									<th>Email</th>
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
<div class="modal fade bd-example-modal-lg" id="modal-add-admin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user-plus"></i> Tambah Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="add-admin">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="nama" class="form-control">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="text" name="password" class="form-control">
					</div>
					<div class="form-group">
						<label>Konfirmasi Password</label>
						<input type="password" name="password_confirmation" class="form-control">
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

	$('#add-admin').submit(function(e){ // tambah admin
		e.preventDefault();

		var request = new FormData(this);
		var endpoint= '{{route("admin.store")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
            // dataType: "json",
            success:function(data){
            	$('#add-admin')[0].reset();
            	$('#modal-add-admin').modal('hide');
            	$('#tabel_admin').DataTable().ajax.reload();
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

	tabel = $(document).ready(function(){
		$('#tabel_admin').DataTable({
			"processing": true,
			"serverSide": true,
			"deferRender": true,
			"ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.admin")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "name" },
              { "data": "email" },
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