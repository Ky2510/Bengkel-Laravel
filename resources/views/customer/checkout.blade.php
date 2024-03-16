@extends('layouts.index')

@section('menuNavbar')
    @include('customer.components.menuNavbar')
@endsection

@section('content')
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
                            <li class="breadcrumb-item "><a href="{{ route($routePrefixKeranjang . '.index', auth()->user()->id) }}"><span style="font-family: 'Alice', serif; color:#A59E92">{{ $miniTitle }}</span></a></li>
                            <li class="breadcrumb-item "><a href=""><span style="font-family: 'Alice', serif; color:#272829">{{ $breadscrumbs1 }}</span></a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header" style="background-color: #A59E92;">
                                <h3 class="card-title"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle }}</span></h3>
                            </div>
                            <div class="card-body p-2 ">
                                <div class="container">
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
                                                <th style="width: 10px">No</th>
                                                <th style="font-family: 'Alice', serif; color:#272829">Nama</th>
                                                <th style="font-family: 'Alice', serif; color:#272829">Kategori</th>
                                                <th style="font-family: 'Alice', serif; color:#272829">Merek</th>
                                                <th style="font-family: 'Alice', serif; color:#272829">Jumlah</th>
                                                <th style="font-family: 'Alice', serif; color:#272829">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @forelse ($selectedItems as $item)
                                            <tr>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $no++ }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->pembelian->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->kategori->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->merek->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->quantity }} {{ $item->satuan->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">Rp.{{ $item->pembelian->hargaJual }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <center><b><i><span style="font-family: 'Alice', serif; color:#272829">Tidak ada barang</span></i></b></center>
                                            </tr>
                                            @endforelse 
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        <span style="font-family: 'Play', serif; color:#272829"> Total : Rp.{{ $totalPrice }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="card">
                            <div class="card-header" style="background-color: #A59E92;">
                                <h3 class="card-title"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle1 }}</span></h3>
                            </div>
                            <div class="card-body p-2 ">
                                {!! Form::model($selectedItems , ['route' => $route,'method' => $method, 'files' => true]) !!}
                                    <div class="container">
                                        {!! Form::hidden('id_user',  auth()->user()->id , ['class' => 'form-control ']) !!}
                                        @foreach($selectedItems as $item)
                                        {!! Form::hidden('id[]', $item->pembelian->id , ['class' => 'form-control']) !!}
                                        {!! Form::hidden('id_keranjang[]',  $item->id , ['class' => 'form-control ']) !!}
                                        @endforeach
                                        <div class="form-group mt-3">
                                            <label for="id_bank"><span style="font-family: 'Alice', serif; color:hsl(210, 3%, 16%)">Pilih Metode Pembayaran Bank <b>via rekening</b></span></label>  
                                            {!! Form::select('id_bank', $listBankC, old('id_bank'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_bank') ? 'is-invalid' : ''), 'placeholder' => 'Pilih...'])!!}
                                            <span class="text-danger">{{ $errors->first('id_bank') }}</span>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="status_pengiriman"><span style="font-family: 'Alice', serif; color:#272829">Pilih Metode Pengiriman Barang</span></label>  
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <center>
                                                        {!! Form::radio('status_pengiriman', 'bengkel', true, ['id' => 'status_bengkel']) !!}
                                                        <label for="status_bengkel">Jemput ke bengkel</label>
                                                    </center>
                                                </div>
                                                <div class="col-lg-6">
                                                    {!! Form::radio('status_pengiriman', 'ditempat', false, ['id' => 'status_ditempat']) !!}
                                                    <label for="status_ditempat">Antar ke lokasi Anda</label>
                                                </div>
                                                <div class="container">
                                                    {!! Form::textarea('alamat_pengiriman', null, ['class' => 'form-control' . ($errors->first('alamat_pengiriman') ? 'is-invalid' : ''), 'rows' => 3, 'placeholder' => 'Masukkan lokasi Anda di sini...', 'id' => 'alamat_pengiriman', 'style' => 'display: none;']) !!}
                                                </div>
                                            </div>
                                            <span class="text-danger" id="alamat_pengiriman_error">
                                                @if ($errors->has('alamat_pengiriman') && old('status_pengiriman') === 'ditempat')
                                                    {{ $errors->first('alamat_pengiriman') }}
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#alamat_pengiriman').show();
                                                        });
                                                    </script>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mt-3">
                                                    <label for="noRek"><span style="font-family: 'Alice', serif; color:#272829">No Rek Anda</span></label>  
                                                    {!! Form::number('noRek', old('noRek'), ['class' => 'form-control ' . ($errors->first('noRek') ? 'is-invalid' : ''),'placeholder' => 'Masukan nomor rekening...']) !!}
                                                    <span class="text-danger">{{ $errors->first('noRek') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mt-3">
                                                    <label for="namaRek"><span style="font-family: 'Alice', serif; color:#272829"> Atas Nama </span></label>  
                                                    {!! Form::text('namaRek', old('namaRek'), ['class' => 'form-control ' . ($errors->first('namaRek') ? 'is-invalid' : ''),'placeholder' => 'Masukan nama rekening...']) !!}
                                                    <span class="text-danger">{{ $errors->first('namaRek') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <style>
                                        .button-bayar {
                                            background-color: #A59E92;
                                            color: #272829;
                                            border: none; /* Menghilangkan border */
                                            cursor: pointer;
                                            font-family: 'Play';
                                        }
                                        .button-bayar:hover{
                                            color: #A59E92;
                                            background-color: #272829;
                                            font-family: 'Play';
                                            border: none; /* Menghilangkan border */
                                        }
                                      </style>
                                    {!! Form::submit($button, ['class' => 'button-bayar btn btn-sm btn-transparent float-right mt-1']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>
@include('customer.components.footer')

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type=radio][name=status_pengiriman]').change(function() {
            if (this.value === 'ditempat') {
                $('#alamat_pengiriman').show();
            } else {
                $('#alamat_pengiriman').hide();
            }
        });
        $('#status_bengkel').change(function() {
            if ($(this).is(':checked')) {
                $('#alamat_pengiriman').val(''); // Mengosongkan textarea
            }
        });
        // Inisialisasi status radio button pada saat halaman dimuat
        if ($('input[name=status_pengiriman]:checked').val() === 'ditempat') {
            $('#alamat_pengiriman').show();
            $('#alamat_pengiriman').addClass('form-control');
        } else {
            $('#alamat_pengiriman').hide();
        }
    });
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