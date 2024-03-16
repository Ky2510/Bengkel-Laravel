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
                        @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item">
                            <a href="{{ route($breadcrumb['route']) }}">
                                <span style="{{ \Route::currentRouteName() == $breadcrumb['route'] ? 'color: black; font-family: Alice, serif; color:#A59E92;' : 'color:#272829;' }}">
                                    {{ $breadcrumb['label'] }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <h6 class="text-center display-4"><span style="font-family: 'Play', sans-serif; color:#272829">Penjualan</span></h6>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan-penjualan.index') }}" method="GET">
                        <div class="row mt-3">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            {!! Form::label('awal', 'Range Tanggal (awal)') !!}
                                            {!! Form::date('awal', old('awal', Request::get('awal')), ['class' => 'form-control form-control form-control-md ' . ($errors->first('awal') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Bank']) !!}
                                            <span class="text-danger">{{ $errors->first('awal') }}</span>
                                        </div>
                                    </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                {!! Form::label('akhir', 'Range Tanggal (akhir)') !!}
                                                {!! Form::date('akhir', old('akhir', Request::get('akhir')), ['class' => 'form-control form-control form-control-md ' . ($errors->first('akhir') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Bank']) !!}
                                                <span class="text-danger">{{ $errors->first('akhir') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <input type="text" name="nama_barang" class="form-control form-control-lg" placeholder="Masukan nama barang  ..." value="{{ Request()->input('nama_barang') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-body p-2 ">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Merek</th>
                                <th>Jenis Motor</th>
                                <th>Harga Jual</th>
                                <th>Total Barang Terjual</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dataJumlah = [];
                            @endphp
                            @foreach ($reportPenjualan as $item)
                                @if ($item->status == 'Sudah dibayar')
                                    @php
                                        $nama = $item->barang->pembelian->nama;
                                        $jenis = $item->barang->pembelian->jenis;
                                        $merek = $item->barang->merek->nama;
                                        $hargaJual = $item->barang->pembelian->hargaJual;
                                        $quantity = $item->quantity;
                                        $satuan = $item->satuan->nama;
                                        $status = $item->status;
                                    @endphp
                    
                                    @if (!isset($dataJumlah[$nama]))
                                        @php
                                            $dataJumlah[$nama] = [
                                                'jenis' => $jenis,
                                                'hargaJual' => $hargaJual,
                                                'satuan' => $satuan,
                                                'merek' => $merek,
                                                'status' => $status,
                                                'quantity' => 0,
                                            ];
                                        @endphp
                                    @endif
                                    @php
                                        $dataJumlah[$nama]['quantity'] += $quantity;
                                    @endphp
                                @endif
                            @endforeach
                       
                            @foreach ($dataJumlah as $nama => $item)
                                @if ($item['status'] == 'Sudah dibayar')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $nama }}</td>
                                    <td>{{ $item['merek'] }}</td>
                                    <td>{{ $item['jenis'] }}</td>
                                    <td>Rp.{{ $item['hargaJual'] }}</td>
                                    <td>{{ $item['quantity'] }} {{ $item['satuan'] }}</td>
                                    <td>Rp.{{ $item['hargaJual'] * $item['quantity'] }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-2 ">
                            <h6><center>Range Tanggal</center></h6>
                            <center> <h3>{{ Request('awal') }} - {{ Request('akhir') }}</h3> </center>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-2 ">
                            <h6><center>Total Pendapatan</center></h6>
                            @php
                                $totalPenjualan = 0; // Variabel total
                            @endphp
                    
                            @foreach ($dataJumlah as $nama => $item)
                                @php
                                    $totalPenjualan += $item['hargaJual'] * $item['quantity']; // Menambahkan ke total
                                @endphp
                            @endforeach
                            <center><h3> Rp.{{ $totalPenjualan }}</h3></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@include('customer.components.footer')
@endsection