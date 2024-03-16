@extends('layouts.index')

@section('menuNavbar')
    @include('customer.components.menuNavbar')
@endsection

@section('content')
<style>
    .inline-form {
        display: flex;
        gap: 10px;
    }
</style>
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829">{{ $title }}</span></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('customer') }}"><span style="font-family: 'Alice', serif; color:#A59E92">{{ $breadscrumbs }}</span></a></li>
                            <li class="breadcrumb-item "><a href="{{ route($routePrefixPembelanjaan . '.index', auth()->user()->id) }}"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle }}</span></a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <div class="card-header" style="background-color: #A59E92;">
                    <h3 class="card-title"><span style="font-family: Alice, serif; color:#272829">{{ $miniTitle }}</span></h3>
                    <div class="float-right">
                        <form action="{{ route('pembelanjaan.index', auth()->user()->id) }}" method="GET">
                            <div class="inline-form">
                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ Request('start_date') }}">
                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ Request('end_date') }}">
                                <style>
                                .btn{
                                    font-family: 'Alice', serif;
                                    background-color: #F4F6F9;
                                    color: #272829;
                                    border: none; /* Menghilangkan border */
                                    cursor: pointer;
                                    }
                                    .btn:hover{
                                    background-color: #272829;
                                    color: #A59E92;
                                    border: none; /* Menghilangkan border */
                                    cursor: pointer;
                                }
                                </style>
                                <button type="submit" class="btn btn-sm btn-round">
                                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-2 ">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                $('.alert').fadeOut('slow');
                            }, 3000);
                        </script>
                    @elseif(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                $('.alert').fadeOut('slow');
                            }, 3000);
                        </script>
                    @elseif(session('danger'))
                        <div class="alert alert-danger">
                            {{ session('danger') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                $('.alert').fadeOut('slow');
                            }, 3000);
                        </script>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-family: 'Alice', serif; color:#272829">ID Transaksi</th>
                                <th style="font-family: 'Alice', serif; color:#272829">Nama</th>
                                {{-- <th style="font-family: 'Alice', serif; color:#272829">Merek</th> --}}
                                {{-- <th style="font-family: 'Alice', serif; color:#272829">Jumlah</th> --}}
                                <th style="font-family: 'Alice', serif; color:#272829">Total</th>
                                <th style="font-family: 'Alice', serif; color:#272829">Pembayaran Bank</th>
                                <th style="font-family: 'Alice', serif; color:#272829">Atas Nama</th>
                                <th style="font-family: 'Alice', serif; color:#272829">Pengiriman Barang</th>
                                <th style="font-family: 'Alice', serif; color:#272829">Tanggal</th>
                                <th style="width: 40px font-family: 'Alice', serif; color:#272829">Status</th>
                                <th style="font-family: 'Alice', serif; color:#272829">Terima Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Request()->input('start_date') || Request()->input('end_date')  !== null)
                                @foreach($models as $item)
                                    @if ($item->keranjang->status == 'Sudah dibayar' && $item->id_user == auth()->user()->id)
                                    <tr>
                                        <td style="font-family: 'Alice', serif; color:#272829">{{ $item->id_transaksi }}</td>
                                        <td style="font-family: 'Alice', serif; color:#272829">{{ $item->keranjang->pembelian->nama }}</td>
                                        {{-- <td style="font-family: 'Alice', serif; color:#272829">{{ $item->keranjang->merek->nama }}</td> --}}
                                        {{-- <td style="font-family: 'Alice', serif; color:#272829">{{ $item->keranjang->quantity }} {{ $item->keranjang->satuan->nama }}</td> --}}
                                        <td style="font-family: 'Alice', serif; color:#272829">Rp.{{ $item->keranjang->quantity * $item->keranjang->pembelian->hargaJual }}</td>
                                        <td style="font-family: 'Alice', serif; color:#272829">{{ $item->bank->nama_bank }}</td>
                                        <td style="font-family: 'Alice', serif; color:#272829">{{ $item->namaRek }}</td>
                                        <td style="font-family: 'Alice', serif; color:#272829">{{ $item->status_pengiriman }}</td>
                                        <td style="font-family: 'Alice', serif; color:#272829">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                        <td>
                                            <center><i class="fa-regular fa-circle-check fa-xl"></i></center>
                                        </td>
                                        <td>
                                            @if ($item->keranjang->status == 'Sudah dibayar')
                                                <button class="badge badge-xs badge-success">Sudah dibayar</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @else
                                @foreach($modelsToday as $item)
                                    @if ($item->keranjang->status == 'Sudah dibayar' && $item->id_user == auth()->user()->id)
                                        <tr>
                                            <td>{{ $item->id_transaksi }}</td>
                                            <td>{{ $item->keranjang->pembelian->nama }}</td>
                                            {{-- <td>{{ $item->keranjang->merek->nama }}</td> --}}
                                            {{-- <td>{{ $item->keranjang->quantity }} {{ $item->keranjang->satuan->nama }}</td> --}}
                                            <td>Rp.{{ $item->keranjang->quantity * $item->keranjang->pembelian->hargaJual }}</td>
                                            <td>{{ $item->bank->nama_bank }}</td>
                                            <td>{{ $item->namaRek }}</td>
                                            @if ($item->status_pengiriman == 'ditempat')
                                                <td>{{ $item->alamat_pengiriman }}</td>
                                            @else
                                                <td>Jemput ke bengkel</td>
                                            @endif
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                            <td>
                                                @if ($item->keranjang->status == 'Sudah dibayar')
                                                    <button class="badge badge-xs badge-success">Sudah dibayar</button>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- {{ $item }} --}}
                                                @if ($item->status == 'Konfirmasi' && $item->status_pengiriman == 'ditempat')
                                                    @php
                                                        $idCheckout = $item->id;
                                                        $kirimBarang = App\Models\KirimBarang::where('id_checkout', $idCheckout)->get();
                                                    @endphp
                                                    @foreach ($kirimBarang as $kirim)
                                                        @php
                                                            $konfirmasi = $kirim->status_barang == 'konfirmasi';
                                                            $tombolAktif = $kirim->konfirmasi_barang == 'aktif';
                                                        @endphp 
                                                        @if ($tombolAktif && $kirim->status_barang == 'belum diterima')
                                                            <center>
                                                                <a href="{{ route('terimabarang_customer.update', [
                                                                    'model' => 'terimabarangcustomer',
                                                                    'id' => $item->id,
                                                                    ]) }}" class="btn btn-sm btn-info">
                                                                    <i class="fa-regular fa-circle-check fa-xl"></i>
                                                                </a>
                                                                <button class="badge badge-xs badge-success">Terima Barang</button>
                                                            </center>
                                                        @elseif($tombolAktif && $item->status == 'Konfirmasi')
                                                            {{ \Carbon\Carbon::parse($item->barang_diterima)->isoFormat('D MMMM YYYY') }}
                                                        @elseif ($item->status_pengiriman == 'ditempat' && $item->alamat_pengiriman !== null && $item->barang_diterima == null)
                                                            <button class="badge badge-xs badge-info">Dalam perjalanan</button>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if ($item->status == 'Konfirmasi' && $item->barang_diterima != null)
                                                        {{ \Carbon\Carbon::parse($item->barang_diterima)->isoFormat('D MMMM YYYY') }}
                                                    @else
                                                        @if ($item->status_pengiriman == 'ditempat')
                                                            <button class="badge badge-xs badge-warning">Belum diantar</button>
                                                        @elseif($item->status_pengiriman == 'dibengkel')
                                                            <button class="badge badge-xs badge-warning">Belum dijemput</button>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'Belum Konfirmasi')
                                                    <button class="badge badge-xs badge-warning">Belum dikonfirmasi</button>
                                                @else
                                                    <button class="badge badge-xs badge-success">Sudah dikonfirmasi</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach 
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
</section>
@include('customer.components.footer')

@endsection