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
                                @if(Route::currentRouteName() === 'anggota.ubah')
                                    <div class="col-sm-12">
                                        <h3 class=""><center>Form Data Anggota</center></h3>
                                        <div class="form-group">
                                            {!! Form::label('nama', 'Nama') !!}
                                            {!! Form::text('nama', old('nama'), ['class' => 'form-control ' . ($errors->first('name') ? 'is-invalid' : ''), 'placeholder' => "Masukan nama ..."]) !!}
                                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('jeniskelamin', 'Jenis Kelamin') !!}
                                            <div class="form-group">
                                                {!! Form::radio('jeniskelamin', 'Pria', false, old('jeniskelamin') === 'Pria', ['id' => 'pria', 'class' => 'custom-control-input1 ' . ($errors->has('jeniskelamin') ? 'is-invalid' : '')]) !!}
                                                {!! Form::label('custom-control-label1', 'Pria') !!}
                                                {!! Form::radio('jeniskelamin', 'Wanita', false,old('jeniskelamin') === 'Wanita', ['id' => 'wanita', 'class' => 'custom-control-input2 ' . ($errors->has('jeniskelamin') ? 'is-invalid' : '')]) !!}
                                                {!! Form::label('custom-control-label2', 'Wanita') !!}
                                                <span class="text-danger">{{ $errors->first('jeniskelamin') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tpt_lhr', 'Tempat Lahir') !!}
                                            {!! Form::text('tpt_lhr', old('tpt_lhr'), ['class' => 'form-control ' . ($errors->first('tpt_lhr') ? 'is-invalid' : ''), 'placeholder' => "Masukan tempat lahir ..."]) !!}
                                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('tgl_lhr', 'Tanggal Lahir') !!}
                                            {!! Form::date('tgl_lhr', old('tgl_lhr'), ['class' => 'form-control ' . ($errors->first('tgl_lhr') ? 'is-invalid' : '')]) !!}
                                            <span class="text-danger">{{ $errors->first('tgl_lhr') }}</span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('alamat', 'Alamat') !!}
                                            {!! Form::textarea('alamat', old('alamat'), ['class' => 'form-control '  . ($errors->first('tgl_lhr') ? 'is-invalid' : ''), 'rows' => 3, 'placeholder' => 'Masukan alamat...']) !!}
                                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('no_hp', 'No HP') !!}
                                            {!! Form::text('no_hp', old('no_hp'), ['class' => 'form-control ' . ($errors->first('tgl_lhr') ? 'is-invalid' : ''), 'rows' => 3, 'placeholder' => 'Masukan nomor...']) !!}
                                            <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                                        </div>
                                    </div>
                                @else
                                    @if(Route::currentRouteName() === 'anggota.ubah-akun')
                                        <div class="col-sm-12">
                                            <h3 class="">Ubah Akun</h3>
                                            <div class="form-group">
                                                {!! Form::label('email', 'Email') !!}
                                                {!! Form::email('email', old('email'), ['class' => 'form-control ' . ($errors->first('email') ? 'is-invalid' : ''), 'placeholder' => "Masukan email ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('username', 'Username') !!}
                                                {!! Form::text('username', old('username'), ['class' => 'form-control ' . ($errors->first('username') ? 'is-invalid' : ''), 'placeholder' => "Masukan username ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-sm-6">
                                            <h3 class="">Buat akun anggota</h3>
                                            <div class="form-group">
                                                {!! Form::label('nama', 'Nama') !!}
                                                {!! Form::text('nama', old('nama'), ['class' => 'form-control ' . ($errors->first('name') ? 'is-invalid' : ''), 'placeholder' => "Masukan nama ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('email', 'Email') !!}
                                                {!! Form::email('email', old('email'), ['class' => 'form-control ' . ($errors->first('email') ? 'is-invalid' : ''), 'placeholder' => "Masukan email ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('username', 'Username') !!}
                                                {!! Form::text('username', old('username'), ['class' => 'form-control ' . ($errors->first('username') ? 'is-invalid' : ''), 'placeholder' => "Masukan username ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('password', 'Password') !!}
                                                {!! Form::password('password', ['class' => 'form-control ' . ($errors->first('password') ? 'is-invalid' : ''), 'placeholder' => "Masukan passoword ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('password_confirmation', 'Konfirmasi Password') !!}
                                                {!! Form::password('password_confirmation', ['class' => 'form-control '  . ($errors->first('Password') ? 'is-invalid' : ''), 'autocomplete' => 'new-password', 'placeholder' => "Masukan konfirmasi password ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h3 class=""><center>Form Data Anggota</center></h3>
                                            <div class="form-group">
                                                {!! Form::label('jeniskelamin', 'Jenis Kelamin') !!}
                                                <div class="form-group">
                                                    {!! Form::radio('jeniskelamin', 'Pria', false, old('jeniskelamin') === 'Pria', ['id' => 'pria', 'class' => 'custom-control-input1 ' . ($errors->has('jeniskelamin') ? 'is-invalid' : '')]) !!}
                                                    {!! Form::label('custom-control-label1', 'Pria') !!}
                                                    {!! Form::radio('jeniskelamin', 'Wanita', false,old('jeniskelamin') === 'Wanita', ['id' => 'wanita', 'class' => 'custom-control-input2 ' . ($errors->has('jeniskelamin') ? 'is-invalid' : '')]) !!}
                                                    {!! Form::label('custom-control-label2', 'Wanita') !!}
                                                    <span class="text-danger">{{ $errors->first('jeniskelamin') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tpt_lhr', 'Tempat Lahir') !!}
                                                {!! Form::text('tpt_lhr', old('tpt_lhr'), ['class' => 'form-control ' . ($errors->first('tpt_lhr') ? 'is-invalid' : ''), 'placeholder' => "Masukan tempat lahir ..."]) !!}
                                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tgl_lhr', 'Tanggal Lahir') !!}
                                                {!! Form::date('tgl_lhr', old('tgl_lhr'), ['class' => 'form-control ' . ($errors->first('tgl_lhr') ? 'is-invalid' : '')]) !!}
                                                <span class="text-danger">{{ $errors->first('tgl_lhr') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('alamat', 'Alamat') !!}
                                                {!! Form::textarea('alamat', old('alamat'), ['class' => 'form-control '  . ($errors->first('tgl_lhr') ? 'is-invalid' : ''), 'rows' => 3, 'placeholder' => 'Masukan alamat...']) !!}
                                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('no_hp', 'No HP') !!}
                                                {!! Form::text('no_hp', old('no_hp'), ['class' => 'form-control ' . ($errors->first('tgl_lhr') ? 'is-invalid' : ''), 'rows' => 3, 'placeholder' => 'Masukan nomor...']) !!}
                                                <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
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