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
<link rel="stylesheet" href="https://unpkg.com/ionicons@5.0.2/dist/css/ionicons.min.css">
<div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829"> {{ $title }} </span></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span style="{{ \Route::is('dashboard') ? 'color: black; font-family: Alice, serif; color:#272829' : '' }}">Dashboard</span></a></li>
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
              <h3>{{ $barangCount }}</h3>
              <p>Data Barang</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-archive"></i> --}}
              <i class="ion ion-document-text"></i>
            </div>
            <a href="{{ route('barang.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $kategoriCount }}</h3>
              <p>Data Kategori</p>
            </div>
            <div class="icon">
              <i class="ion ion-clipboard"></i>
            </div>
            <a href="{{ route('kategori.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $merekCount }}</h3>
              <p>Data Merek</p>
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
            <a href="{{ route('merek.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $satuanCount }}</h3>
              <p>Data Satuan</p>
            </div>
            <div class="icon">
              <i class="ion ion-funnel"></i>
            </div>
            <a href="{{ route('satuan.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $suplayCount }}</h3>
              <p>Data Suplayer</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="{{ route('suplay.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $pembelianCount }}</h3>
              <p>Data Pembelian</p>
            </div>
            <div class="icon">
              <i class="ion ion-archive"></i>
            </div>
            <a href="{{ route('pembelian.index') }}" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>Graphic</h3>
              <p>Pendapatan Penjualan</p>
            </div>
            <div class="icon">
              <i class="fas fa-chart-line"></i> 
            </div>
            <a type="button" class="small-box-footer" data-toggle="modal" data-target="#modal-pendapatan">
              Lihat Selengkapnya
              <i class="fas fa-arrow-circle-right"></i>
            </a>
            <div class="modal fade" id="modal-pendapatan">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #968F81; color:#272829">
                    <h4 class="modal-title">Grafik Pendapatan Per/Bulan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="background-color: #D8D9DA">
                    @include('dashboard.admin.chart.pendapatan')
                  </div>
                  <style>
                    .btn-kembali {
                        background-color: #D8D9DA;
                        color: #272829;
                        border: none; 
                        cursor: pointer;
                    }
                    .btn-kembali:hover{
                        background-color: #61677A;
                        color: #FFFFFF;
                        border: none;
                        cursor: pointer;
                    }
                  </style>
                  <div class="modal-footer float-right" style="background-color: #968F81; color:#D8D9DA">
                    <button type="button" class="btn-kembali btn btn-md btn-round mt-2" data-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box">
            <div class="inner">
              <h3>Graphic</h3>
              <p>Barang Terjual</p>
            </div>
            <div class="icon">
              <i class="fas fa-chart-line"></i> 
            </div>
            <a type="button" class="small-box-footer" data-toggle="modal" data-target="#modal-barang">
              Lihat Selengkapnya
              <i class="fas fa-arrow-circle-right"></i>
            </a>
            <div class="modal fade" id="modal-barang">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #968F81; color:#272829">
                    <h4 class="modal-title">Grafik Barang Terjual</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="background-color: #D8D9DA">
                    @include('dashboard.admin.chart.barangTerjual')
                  </div>
                  <style>
                    .btn-kembali {
                        background-color: #D8D9DA;
                        color: #272829;
                        border: none; 
                        cursor: pointer;
                    }
                    .btn-kembali:hover{
                        background-color: #61677A;
                        color: #FFFFFF;
                        border: none; 
                        cursor: pointer;
                    }
                  </style>
                  <div class="modal-footer float-right" style="background-color: #968F81; color:#D8D9DA">
                    <button type="button" class="btn-kembali btn btn-md btn-round mt-2" data-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="small-box">
            <div class="inner">
              <h3>{{ $pengirimanBarangCount }}</h3>
              <p>Pengiriman Barang</p>
            </div>
            <div class="icon">
              <i class="fas fa-chart-line"></i> 
            </div>
            <a type="button" class="small-box-footer" data-toggle="modal" data-target="#modal-kirimBarang">
              Lihat Selengkapnya
              <i class="fas fa-arrow-circle-right"></i>
            </a>
            <div class="modal fade" id="modal-kirimBarang">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #968F81; color:#272829">
                    <h4 class="modal-title">Pengiriman Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="background-color: #D8D9DA">
                    <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th style="font-family: 'Alice', serif; color:#272829; width: 10px">No</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">ID Transaksi</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Nama Barang</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Merek Barang</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Jumlah Barang</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Total Pembayaran</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Status Pembayaran</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Konfirmasi Pembayaran</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Alamat</th>
                              <th style="font-family: 'Alice', serif; color:#272829;">Penerimaan Barang</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($pengirimanBarang as $item)
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->checkout->id_transaksi }}</td>
                              <td>{{ $item->checkout->keranjang->barang->pembelian->nama }}</td>
                              <td>{{ $item->checkout->keranjang->merek->nama }}</td>
                              <td>{{ $item->checkout->keranjang->quantity }}</td>
                              <td>{{ $item->checkout->keranjang->barang->pembelian->hargaJual * $item->checkout->keranjang->quantity }}</td>
                              <td>{{ $item->checkout->keranjang->status }}</td>
                              <td>{{ $item->checkout->status }}</td>
                              <td>{{ $item->checkout->alamat_pengiriman }}</td>
                              <td>
                                @if ($item->konfirmasi_barang == 'tidak aktif')
                                  <a href="{{ route('penerimaan_barang.update', [
                                      'model' => 'terimaBarang',
                                      'id' => $item->id,
                                      ]) }}" class="btn btn-success btn-md">
                                      Submit
                                  </a>
                                @elseif($item->konfirmasi_barang == 'aktif' && $item->status_barang == 'belum diterima')
                                  <button class="badge badge-xs badge-warning">Proses penerimaan barang</button>
                                @elseif($item->konfirmasi_barang == 'aktif' && $item->status_barang == 'diterima')
                                  <button class="badge badge-xs badge-success"> {{ \Carbon\Carbon::parse($item->barang_diterima)->isoFormat('D MMMM YYYY') }}</button>
                                @endif
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  </div>
                  <style>
                    .btn-kembali {
                        background-color: #D8D9DA;
                        color: #272829;
                        border: none; /* Menghilangkan border */
                        cursor: pointer;
                    }
                    .btn-kembali:hover{
                        background-color: #61677A;
                        color: #FFFFFF;
                        border: none; 
                        cursor: pointer;
                    }
                  </style>
                  <div class="modal-footer float-right" style="background-color: #968F81; color:#D8D9DA">
                    <button type="button" class="btn-kembali btn btn-md btn-round mt-2" data-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          @include('dashboard.components.layananService1')
        </div>
        <div class="col-lg-3">
          @include('dashboard.components.layananService2')
        </div>
      </div>
    </div>
  </div>
</div>
@include('customer.components.footer')
@endsection