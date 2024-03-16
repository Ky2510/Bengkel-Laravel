@extends('layouts.index')

@section('menuNavbar')
  @include('layouts.components.menuNavbar')
@endsection

@section('content')
<style>
  .small-box{
    background-color: #968F81;
    font-family: play;
  }
</style>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829"> {{ $title }} </span></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span style="{{ \Route::is('admin') ? 'color: black; font-family: Alice, serif; color:#272829' : '' }}">Dashboard</span></a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container">
      <div class="row"> 
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $anggotaCount }}</h3>
              <p>Data Anggota</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="{{ route('anggota.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $userTerdaftarCount }}</h3>
              <p>User/Terdaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="{{ route('user.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $bankCount }}</h3>
              <p>Data Bank</p>
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
            <a href="{{ route('bank.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $pembelianCount }}</h3>
              <p>Laporan Barang Masuk</p>
            </div>
            <div class="icon">
              <i class="ion ion-archive"></i>
            </div>
            <a href="{{ route('laporan-barangmasuk.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $pembayaranCount }}</h3>
              <p>Laporan Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="{{ route('laporan-pembayaran.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $pembayaranCount }}</h3>
              <p>Laporan Penjualan</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('laporan-penjualan.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $layananServiceCount }}</h3>
              <p>Laporan Layanan Service</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('laporan-layanan-service.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('customer.components.footer')
@endsection