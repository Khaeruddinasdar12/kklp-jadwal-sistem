@extends('layouts.template')

@section('title') Dashboard @endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Dashboard</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
					<!-- <li class="breadcrumb-item active">Dashboard v1</li> -->
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-light">
					<div class="inner">
						<h3>{{$jdw}}</h3>

						<p>Jadwal</p>
					</div>
					<div class="icon">
						<i class="fas fa-calendar-minus"></i>
					</div>
					<a href="{{route('jadwal')}}" class="small-box-footer" >More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-success">
					<div class="inner">
						<h3>{{$pgw}}</h3>

						<p>Jumlah Pegawai</p>
					</div>
					<div class="icon">
						<i class="fas fa-users"></i>
					</div>
					<a href="{{route('pegawai')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-warning">
					<div class="inner">
						<h3>{{$dpt}}</h3>

						<p>Jumlah Departemen</p>
					</div>
					<div class="icon">
						<i class="fas fa-tag"></i>
					</div>
					<a href="{{route('departemen')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-dark">
					<div class="inner">
						<h3>{{$adm}}</h3>

						<p>Jumlah Admin</p>
					</div>
					<div class="icon">
						<i class="fas fa-user-cog"></i>
					</div>
					<a href="{{route('admin')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
		</div>
		<!-- /.row -->
		<!-- Main row -->
		<div class="row">
			<!-- Left col -->

			<!-- right col -->
		</div>
		<!-- /.row (main row) -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection