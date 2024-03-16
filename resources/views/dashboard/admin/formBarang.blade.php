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
            <div class="container">
                <div class="card">
                    <div class="card-header" style="background-color: #A59E92;">
                        <h3 class="card-title"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle }}</span></h3>
                    </div>
                    <div class="card-body">
                        {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('id_pembelian', 'Pilih Barang') !!}
                                        {!! Form::select('id_pembelian', $listPembelian, old('id_pembelian'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_pembelian') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Barang']) !!}
                                        <span class="text-danger">{{ $errors->first('id_pembelian') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('id_kategori', 'Kategori') !!}
                                        {!! Form::select('id_kategori', $listKategori, old('id_kategori'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_kategori') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Kategori']) !!}
                                        <span class="text-danger">{{ $errors->first('id_kategori') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('id_merek', 'Merek') !!}
                                        {!! Form::select('id_merek', $listMerek, old('id_merek'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_merek') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Merek']) !!}
                                        <span class="text-danger">{{ $errors->first('id_merek') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('kode', 'Kode Barang') !!}
                                        {!! Form::text('kode', old('kode'), ['class' => 'form-control ' . ($errors->first('kode') ? 'is-invalid' : ''), 'placeholder' => "Masukan kode ..."]) !!}
                                        <span class="text-danger">{{ $errors->first('kode') }}</span>
                                    </div>
                                    @if($model->image != null)
                                    <div class="m-3">
                                        <img src="{{ \Storage::url($model->image) }}" alt="" width="200" class="img-thumbnail">
                                    </div>
                                    @endif
                                    <div class="form-group mt-3">
                                        {!! Form::label('image', 'Gambar (Format: jpg, jpeg, png, Ukuran Maks: 5MB)') !!}
                                        {!! Form::file('image', ['class' => 'form-control ' . ($errors->first('image') ? 'is-invalid' : ''), 'accept' => 'image/*']) !!}
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('id_satuan', 'Satuan') !!}
                                        {!! Form::select('id_satuan', $listSatuan,  old('id_satuan'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_satuan') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Satuan']) !!}
                                        <span class="text-danger">{{ $errors->first('id_satuan') }}</span>
                                    </div>
                                </div>
                            </div>
                            <style>
                                .btn-simpan {
                                    background-color: #82CD47;
                                    color: #272829;
                                    border: none; /* Menghilangkan border */
                                    cursor: pointer;
                                }
                                .btn-simpan:hover{
                                    background-color: #379237;
                                    color: #FFFFFF;
                                    border: none; /* Menghilangkan border */
                                    cursor: pointer;
                                }
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
                            {!! Form::submit($button , ['class' => 'btn-simpan btn btn-md mx-2  btn-round  float-right']) !!}
                            <a href="{{ route($routePrefix . '.index') }}" class="btn-kembali btn btn-md btn-round float-right">Kembali</a>
                        {!! Form::close() !!}
                    </div>
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