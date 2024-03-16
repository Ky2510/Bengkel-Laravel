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
        <h6 class="text-center display-4"><span style="font-family: 'Play', sans-serif; color:#272829">Layanan Service</span></h6>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan-layanan-service.index') }}" method="GET">
                        <div class="row mt-3">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group input-group-lg">
                                                <input type="text" name="id_layanan" class="form-control form-control-lg" placeholder="Masukan id layanan  ..." value="{{ Request()->input('id_layanan') }}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-lg btn-default">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
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
                                <th>ID Layanan Service</th>
                                <th>Nama Motor</th>
                                <th>Jenis Motor</th>
                                <th>Nama</th>
                                <th>Barang(Stok)</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                                <th>Anggota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportLayananService as $item)
                                @php
                                    $dataUser = App\Models\Datauser::where('id_user', $item->id_datauser)->get();
                                    $dataAnggota = App\Models\Anggota::where('user_id', $item->id_anggota)->get();
                                    $dataBarang = App\Models\ServiceBarang::where('id_layananservice', $item->id)->get();
                                @endphp
                                @if (Request()->input('id_layanan') == $item->id_layanan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id_layanan }}</td>
                                        <td>{{ $item->nama_motor }}</td>
                                        <td>{{ $item->jenis_motor }}</td>
                                        <td>
                                            @foreach ($dataUser as $itemDataUser)
                                                {{ $itemDataUser->namaPertama }} {{ $itemDataUser->namaTerakhir }}
                                            @endforeach
                                        </td>
                                        <td>
                                            <ol type="1">
                                                @foreach ($dataBarang as $itemBarang)
                                                    @if ($itemBarang->id_barang !== null && $itemBarang->stok_barang !== null)
                                                        <li>{{ $itemBarang->barang->nama }} ({{ $itemBarang->stok_barang }})</li>
                                                    @endif
                                                @endforeach
                                            </ol>    
                                        </td>
                                        <td>{{ $item->keluhan }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @foreach ($dataAnggota as $itemAnggota)
                                                {{ $itemAnggota->nama }}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-2 ">
                            @php
                                $totalHarga = 0;
                            @endphp
                            @if (Request()->input('id_layanan') == $item->id_layanan)
                                @foreach ($dataBarang as $itemBarang)
                                    @if ($itemBarang->id_barang !== null && $itemBarang->stok_barang !== null)
                                        Harga {{ $itemBarang->barang->nama }} /1 = Rp. {{ $itemBarang->barang->hargaJual }} = Rp.{{ $itemBarang->barang->hargaJual * $itemBarang->stok_barang }}<br>
                                        
                                        @php
                                            $totalHarga += $itemBarang->barang->hargaJual * $itemBarang->stok_barang;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif

                            Total Harga: Rp.{{ $totalHarga }}

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