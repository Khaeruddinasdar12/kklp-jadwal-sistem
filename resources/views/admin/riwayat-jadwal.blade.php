@extends('layouts.template')

@section('title')
Manage Jadwal - Riwayat Jadwal
@endsection

@section('css')<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
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
					<h2 class="card-title"><i class="fa fa-calendar-week"></i> List Riwayat Jadwal</h2>
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
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script type="text/javascript">
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
                "url":  '{{route("table.riwayat.jadwal")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nama" },
              { "data": "ruangan" },
              { "data": "waktu" },
              { "data": "departemen" },
              { "data": "status" },
              ]
            });
});
</script>
@endsection