@extends('layouts.template')

@section('title') 
Edit Jadwal 
@endsection

@section('css')

<style type="text/css">
.alert-warning{
	color: #856404;
	background-color: #fff3cd;
	border-color: #ffeeba;
}

.alert-success {
	color: #155724;
	background-color: #d4edda;
	border-color: #c3e6cb; 
}

.alert-danger {
	color: #721c24;
	background-color: #f8d7da;
	border-color: #f5c6cb;
}
.alert-anchor {
	color: blue !important;
}
</style>
@endsection

@section('content')
<div class="content-header">
	<div class="container-fluid">
	</div>
</div>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-12">
				@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Berhasil Mengubah Jadwal !</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@elseif(session('error'))
				<div class="alert alert-danger">
					{{session('error')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if (count($errors) > 0)
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Whoops!</strong><br><br>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
					
				</div>
				@endif
				<div class="card card-secondary card-outline offset-md-0">
					<form method="post" enctype="multipart/form-data" action="{{route('jadwal.update', ['id' => $data[0]->id])}}">
						<div class="card-header">
							<h2 class="card-title"><i class="fa fa-calendar-minus"></i> Edit Jadwal</h2>
							<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Update</button>
						</div>
						<div class="card-body">
							@csrf
							{{ method_field('PUT') }}
							<div class="form-group">
								<label>Nama Acara</label>
								<input type="text" name="nama" class="form-control" value="{{old('nama', $data[0]->nama)}}">
							</div>
							<div class="form-group">
								<label>Ruangan</label>
								<input type="text" name="ruangan" class="form-control" value="{{old('ruangan', $data[0]->ruangan)}}">
							</div>
							<div class="form-group">
								@php $depart = preg_split ("/\,/", $data[0]->departemen);  @endphp

								<label>Departemen</label>
								@foreach($dpt as $dt) 
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="departemen[]" value="{{$dt->id}}" @if(in_array($dt->id, $depart)) checked @endif>
									<label class="form-check-label">
										{{$dt->nama}}
									</label>
								</div>
								@endforeach
							</div>
							<div class="form-group row">
								<div class="col-md-6">
									<label>Tanggal</label>
									<input type="date" name="waktu" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="{{old('waktu', date('Y-m-d', strtotime($data[0]->waktu)) ) }}">
								</div>
								<div class="col-md-3">
									<label>Jam</label>
									<select name="jam" class="form-control">
										@for ($i = 0; $i < 24; $i++)
										<option value="{{$i}}" @if(date('H', strtotime($data[0]->waktu)) == $i) selected @endif>{{$i}}</option>
										@endfor
									</select>
								</div>
								<div class="col-md-3">
									<label>Menit</label>
									<select name="menit" class="form-control">
										@for ($i = 0; $i < 60; $i++)
										<option value="{{$i}}" @if(date('i', strtotime($data[0]->waktu)) == $i) selected @endif>{{$i}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Deskripsi</label>
								<textarea name="deskripsi" class="form-control" rows="4">{{old('deskripsi', $data[0]->deskripsi)}}</textarea>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
