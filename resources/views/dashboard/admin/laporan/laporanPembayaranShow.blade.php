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
                        <h1 class="m-0">
                            <span style="font-family: 'Play', sans-serif; color:#272829">{{ $title }} 
                                @if(Request()->input('atas_nama'))
                                    {{ Request()->input('atas_nama') }}
                                @endif
                            </span>
                        </h1>
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
            <h6 class="text-center display-4"><span style="font-family: 'Play', sans-serif; color:#272829">
                @if (Request()->input('tgl_pembayaran') != null)
                    {{ \Carbon\Carbon::parse(Request()->input('tgl_pembayaran'))->isoFormat('D MMMM YYYY') }}</span>
                @elseif (Request()->input('atas_nama') == null && Request()->input('bank') == null && Request()->input('tgl_pembayaran') == null && Request()->input('id_transaksi') == null)
                    {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                @endif
            </h6>
            <div class="card mt-4">
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
                <div class="card-body p-2 ">
                    <ul>
                        <li class="text-danger">Hati-hati dalam <b><i>mengonfirmasi pembayaran</i> </b>apabila sudah <b><i>dikonfirmasi</i></b> maka tidak bisa <b><i>"dikembalikan".</i></b></li>
                        <li class="text-danger">Setelah <b><i>mengonfirmasi pembayaran</i> </b> otomatis pada halaman customer apabila status pengiriman barang nya sesuai lokasi customer maka statusnya <b><i>"dalam perjalanan".</i></b></li>
                    </ul>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>ID Transaksi</th>
                                <th>Nama </th>
                                <th>Via Transfer <br> (nama bank)</th>
                                <th>Status </th>
                                <th>Tanggal</th>
                                <th>Status Pembayaran</th>
                                <th>Pengiriman Barang</th>
                                <th>Konfirmasi Pembayaran</th>
                                <th>Terima Barang</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (request()->input('atas_nama') && request()->input('tgl_pembayaran') == null)
                                @foreach ($pembayaranToday as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id_transaksi }}</td>
                                        <td>{{ $item->keranjang->pembelian->nama }}</td>
                                        <td>{{ $item->bank->nama_bank }}</td>
                                        <td>
                                            @if ($item->keranjang->status == 'Sudah dibayar')
                                                <button class="badge badge-xs badge-success">Sudah dibayar</button>
                                            @else
                                                <button class="badge badge-xs badge-warning">Belum dibayar</button>
                                            @endif
                                        </td>
                                        <td> {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</span></td>
                                        <td>{{ $item->status }}</td>
                                        <td></td>
                                        <td>
                                            <center>
                                                <a href="{{ route('konfirmasi.update', [
                                                    'model' => 'pemberitahuan',
                                                    'id' => $item->id,
                                                    'status' => $item->status ==  'konfirmasi' ? 'belum konfirmasi' : 'konfirmasi',
                                                    ]) }}" class="btn btn-success btn-md">
                                                    <center><i class="fa-regular fa-circle-check fa-xl"></i></center>
                                                </a>
                                            </center>
                                        </td>
                                        <td><a href="{{ route('invoice.show', $item->id) }}" target="blank"><center><i class="fa-solid fa-file-invoice-dollar fa-xl" style="color: #272829"></i></center></a></td>
                                    </tr>
                                @endforeach
                            @endif
                            @foreach ($reportPembayaran as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->id_transaksi }}</td>
                                <td>{{ $item->keranjang->pembelian->nama }}</td>
                                <td>{{ $item->bank->nama_bank }}</td>
                                <td>
                                    @if ($item->keranjang->status == 'Sudah dibayar')
                                        <button class="badge badge-xs badge-success">Sudah dibayar</button>
                                    @else
                                        <button class="badge badge-xs badge-warning">Belum dibayar</button>
                                    @endif
                                </td>
                                <td> {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</span></td>
                                <td>
                                    @if ($item->status == 'Konfirmasi')
                                        <center>
                                            <button class="badge badge-xs badge-success">Konfirmasi</button>
                                        </center>
                                    @else
                                        <center>
                                            <button class="badge badge-xs badge-warning">Belum Konfirmasi</button>
                                        </center>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_pengiriman == 'bengkel')
                                        <center>
                                            <button class="badge badge-xs badge-info">Jemput ke bengkel</button>
                                        </center>
                                    @else
                                        <center>
                                            <button class="badge badge-xs badge-warning">{{ $item->alamat_pengiriman }}</button>
                                            <button href=""  class="badge badge-xs badge-info" data-toggle="modal" data-target="#modal-default{{ $item->id }}">
                                                @php
                                                    $idCheckout = $item->id;
                                                    $kirimBarang = App\Models\KirimBarang::where('id_checkout', $idCheckout)->get();
                                                @endphp
                                                @foreach ($kirimBarang as $item)
                                                    {{ $item->anggota->nama }}
                                                @endforeach
                                                @if ($kirimBarang == '[]')
                                                    Kirim Barang
                                                @endif
                                            </button>
                                            <div class="modal fade" id="modal-default{{ $item->id }}">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Form pengiriman barang ke {{ $item->alamat_pengiriman }} </h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <input type="hidden" value="{{ $item->id }}" name="id_checkout">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" value="belum diterima" name="status_barang">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" value="tidak aktif" name="konfirmasi_barang">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            {!! Form::label('id_anggota', 'Nama Anggota') !!}
                                                            {!! Form::select('id_anggota', $listAnggota, old('id_anggota'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_anggota') ? 'is-invalid' : '')]) !!}
                                                            <span class="text-danger">{{ $errors->first('id_anggota') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        {!! Form::submit($button , ['class' => 'btn btn-primary']) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                  </div>
                                                </div>
                                            </div>
                                        </center>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == 'Belum Konfirmasi')
                                        <center>
                                            <a href="{{ route('konfirmasi.update', [
                                                'model' => 'checkout',
                                                'id' => $item->id,
                                                'status' => $item->status ==  'konfirmasi' ? 'belum konfirmasi' : 'konfirmasi',
                                                ]) }}" class="btn btn-success btn-md">
                                                <center><i class="fa-regular fa-circle-check fa-xl"></i></center>
                                            </a>
                                        </center>
                                    @else
                                        <center>
                                            <button class="badge badge-xs badge-success">Sudah dikonfirmasi</button>
                                        </center>
                                    @endif
                                </td>
                                {{-- Bengkel Update --}}
                                <td>
                                    @if ($item->status_pengiriman == 'bengkel')
                                        @if ($item->barang_diterima == null)
                                            <center>
                                                <a href="{{ route('terima_barang.update', [
                                                    'model' => 'bengkel',
                                                    'id' => $item->id,
                                                    ]) }}" class="btn btn-success btn-md">
                                                    <center><i class="fa-regular fa-circle-check fa-xl"></i></center>
                                                </a>
                                            </center>
                                        @else
                                            {{ \Carbon\Carbon::parse($item->barang_diterima)->isoFormat('D MMMM YYYY') }}
                                        @endif
                                    @else
                                        @if ($item->status_barang == 'diterima' && $item->konfirmasi_barang == 'aktif')
                                            <center>
                                                {{ \Carbon\Carbon::parse($item->barang_diterima)->isoFormat('D MMMM YYYY') }}
                                            </center>
                                        @else
                                            <center>
                                                <button class="badge badge-xs badge-warning">Belum diterima</button>
                                            </center>
                                        @endif
                                    @endif
                                </td>
                                <td><a href="{{ route('invoice.show', $item->id) }}" target="blank"><center><i class="fa-solid fa-file-invoice-dollar fa-xl" style="color: #272829"></i></center></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                            border: none; /* Menghilangkan border */
                            cursor: pointer;
                        }
                    </style>
                    <a href="{{ route('laporan-pembayaran.index') }}" class="btn-kembali btn btn-md btn-round float-right mt-2">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
@include('customer.components.footer')

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endsection