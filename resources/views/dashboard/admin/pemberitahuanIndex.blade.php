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
                <div class="row">
                    @php
                        $displayedTransactions = []; 
                        $getNotification = DB::table('notifications')->get();
                    @endphp
                    @foreach ($checkouts as $key => $item)
                        @php
                            $id_transaksi_found = false;
                            $read_at_is_null = false;
                            $idNotification = null; 
                        @endphp
                        
                        @foreach ($notifications as $notification)
                            @php
                                $id_transaksi = $notification->id_transaksi;
                                $read_at = $notification->read_at;
                                $id = $notification->id;
                            @endphp
                            @if ($id_transaksi == $item->id_transaksi && $read_at == null)
                                @php
                                    $idTransaksi = $id_transaksi;
                                    $idNotification = $id;
                                @endphp
                            @endif
                            @if ($id_transaksi == $item->id_transaksi)
                                @php
                                    $id_transaksi_found = true;
                                    if ($read_at === null) {
                                        $read_at_is_null = true;
                                    }
                                @endphp
                            @endif
                        @endforeach
                        @if (!in_array($item->id_transaksi, $displayedTransactions))
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><b><i>{{ $item->id_transaksi }}</i></b></h3>
                                    </div>
                                    <div class="card-body">
                                        Nama : {{ $namaPertamaCustomer[$item->id_user] }}  {{ $namaTerakhirCustomer[$item->id_user] }} <br>
                                        Bank (via Transfer) : {{ $item->bank->nama_bank }} <br>
                                        Atas Nama : {{ $item->namaRek }} <br>
                                        Nomor Rek : {{ $item->noRek }}
                                        {{ $id }}
                                    </div>
                                    @if ($id_transaksi_found)
                                        @if ($read_at_is_null)
                                            @if ($idNotification !== null) 
                                                <a href="{{ route('pemberitahuan.show', [
                                                    'model' => 'pemberitahuan',
                                                    'id' => $idNotification,
                                                ]) }}" class="btn btn-sm btn-warning">
                                                    Belum dibaca
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('pemberitahuan.show', ['id' => $idNotification]) }}" class="btn btn-sm btn-primary">
                                                Lihat detail
                                            </a>
                                        @endif
                                    @else
                                    <a href="{{ route('pemberitahuan.show', ['id' => $idNotification]) }}" class="btn btn-sm btn-primary">
                                        Lihat detail
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @php
                                $displayedTransactions[] = $item->id_transaksi;
                            @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        </div>  
    </div>
</section>
@include('customer.components.footer')
@endsection