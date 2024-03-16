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
                                        {!! Form::label('nama', 'Nama Satuan') !!}
                                        {!! Form::text('nama', old('nama'), ['class' => 'form-control ' . ($errors->first('name') ? 'is-invalid' : ''), 'placeholder' => "Masukan nama ..."]) !!}
                                        <span class="text-danger">{{ $errors->first('nama') }}</span>
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
@endsection