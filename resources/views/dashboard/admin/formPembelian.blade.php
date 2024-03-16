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
                                        {!! Form::label('id_suplay', 'Suplayer') !!}
                                        {!! Form::select('id_suplay', $listSuplay, old('id_suplay'), ['class' => 'form-control select2bs4 ' . ($errors->first('id_suplay') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Suplayer']) !!}
                                        <span class="text-danger">{{ $errors->first('id_suplay') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nama', 'Nama Barang') !!}
                                        {!! Form::text('nama', old('nama'), ['class' => 'form-control ' . ($errors->first('nama') ? 'is-invalid' : ''), 'placeholder' => "Masukan nama barang..."]) !!}
                                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('jenis', 'Jenis Motor') !!}
                                        {!! Form::text('jenis', old('jenis'), ['class' => 'form-control ' . ($errors->first('jenis') ? 'is-invalid' : ''), 'placeholder' => "Masukan jenis motor..."]) !!}
                                        <span class="text-danger">{{ $errors->first('jenis') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('stok', 'Stok Barang') !!}
                                        {!! Form::number('stok', old('stok'), ['class' => 'form-control ' . ($errors->first('stok') ? 'is-invalid' : ''), 'placeholder' => "Masukan stok ..."]) !!}
                                        <span class="text-danger">{{ $errors->first('stok') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('hargaBeli', 'Harga Beli Barang') !!}
                                        {!! Form::number('hargaBeli', old('hargaBeli'), ['class' => 'form-control ' . ($errors->first('hargaBeli') ? 'is-invalid' : ''), 'placeholder' => "Masukan harga beli..."]) !!}
                                        <span class="text-danger">{{ $errors->first('hargaBeli') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('hargaJual', 'Harga Jual Barang') !!}
                                        {!! Form::number('hargaJual', old('hargaJual'), ['class' => 'form-control ' . ($errors->first('hargaJual') ? 'is-invalid' : ''), 'placeholder' => "Masukan jual beli..."]) !!}
                                        <span class="text-danger">{{ $errors->first('hargaJual') }}</span>
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