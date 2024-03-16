@extends('layouts.index')

@section('menuNavbar')
  @include('layouts.components.menuNavbar')
@endsection

@section('content')
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829">{{ $title }} </span></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <h1 class="m-0"><span style="font-family: 'Alice', sans-serif; color:#272829"><b><i>{{ \Carbon\Carbon::parse($created_at)->isoFormat('D MMMM YYYY') }}</i></b></span></h1> 
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    @foreach ($checkoutIDTransaksi as $item)
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title">{{ $item->keranjang->barang->pembelian->nama }} ( <b><i>{{ $item->keranjang->barang->kategori->nama }}</i></b> )</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <img src="{{ \Storage::url($item->keranjang->barang->image) }}" class="product-image" alt="Product Image">
                                    </div>
                                    <div class="col-lg-6">
                                        <p> Kode Barang : {{ $item->keranjang->barang->kode }} <br>
                                            Merek Barang : {{ $item->keranjang->barang->merek->nama }} <br>
                                            Kuantitas : {{ $item->keranjang->quantity }} {{ $item->keranjang->satuan->nama }}<br>
                                            Total : Rp.{{ $item->keranjang->pembelian->hargaJual * $item->keranjang->quantity }} <br>
                                            @if ($item->status == 'Konfirmasi')
                                                <button class="badge badge-xs badge-success">Sudah dikonfirmasi</button>
                                            @else
                                                <button class="badge badge-xs badge-warning">Belum dikonfirmasi</button>
                                            @endif<br>
                                        </p>
                                    </div>
                                    <div class="col-lg-2">
                                        Jam <b><i>{{ \Carbon\Carbon::parse($created_at)->format('H:i') }}</i></b>
                                    </div>
                                </div>
                            <br>
                            Metode Pembayaran <br>
                            <p> Nama Bank : {{ $item->bank->nama_bank }} <br>
                                Nomor Rek. : {{ $item->noRek }} <br>
                                Nama Rek. : {{ $item->namaRek }}<br>
                            </p>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>  
    </div>
</section>
@include('customer.components.footer')
@endsection