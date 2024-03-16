@extends('layouts.index')

@section('menuNavbar')
    @include('customer.components.menuNavbar')
@endsection

@section('content')
<style>
  .total-checkout-wrapper {
      display: flex;
      flex-direction: row;
      align-items: center;
  }

  .total-checkout-wrapper h5 {
      margin-right: 10px;
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
                            <li class="breadcrumb-item"><a href="{{ route('customer') }}"> <span style="font-family: 'Alice', serif; color:#A59E92">{{ $breadscrumbs }}</span></a></li>
                            <li class="breadcrumb-item "><a href="{{ route($routePrefixKeranjang . '.index', auth()->user()->id) }}"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle }}</span></a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="card">
                    <div class="card-header"  style="background-color: #A59E92;">
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
                                        <th><center><i class="fa-regular fa-circle-check fa-xl" style="color: #272829"></i></center></th>
                                        <th style="width: 10px; font-family: 'Alice', serif; color:#272829">No</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Nama</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Kategori</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Merek</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Quantity</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Satuan</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Harga</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Total</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Status</th>
                                        <th style="width: 40px; font-family: 'Alice', serif; color:#272829"><i class="fa-solid fa-bars" style="color: #272829;"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @forelse($models as $item)
                                        @if ($item->status == 'Belum dibayar')
                                            <tr>
                                                <td>
                                                    <center>
                                                        <div class="custom-control custom-switch">
                                                            {!! Form::checkbox('item', $item->id, false, ['class' => 'custom-control-input', 'id' => 'item-checkbox-' . $item->id, 'data-quantity' => $item->quantity, 'data-hargajual' => $item->pembelian->hargaJual]) !!}
                                                            <label class="custom-control-label" for="item-checkbox-{{ $item->id }}"></label>
                                                        </div>
                                                    </center>
                                                </td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $no++ }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->pembelian->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->kategori->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->merek->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->quantity }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">{{ $item->satuan->nama }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">Rp.{{ $item->pembelian->hargaJual }}</td>
                                                <td style="font-family: 'Alice', serif; color:#272829">Rp.{{ $item->quantity * $item->pembelian->hargaJual }}</td>
                                                <td>
                                                    @if ($item->status == 'Belum dibayar')
                                                        <button class="badge badge-xs badge-warning">Belum dibayar</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="btn-group">
                                                            <a href="{{ route($routePrefixKeranjang .'.destroy', $item->id)   }}" class="btn btn-danger btn-md btn-sm d-inline-block"><i class="fa-solid fa-trash" style="color: #F4F6F9;"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <center><b><i><span style="font-family: 'Alice', serif; color:#272829">Tidak ada barang dalam keranjang</span></i></b></center>
                                        </tr>
                                    @endforelse 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="content">
            <div class="container">
                <div class="card">
                    <div class="card-body p-2" style="background-color: #A59E92">
                        <div class="container">
                          <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">
                                <div class="float-right total-checkout-wrapper">
                                  <span id="total-amount" style="font-family: 'Play', serif; color:#272829">Centang untuk</span>
                                  <style>
                                    .button-checkout {
                                        background-color: #F4F6F9;
                                        color: #272829;
                                        border: none; /* Menghilangkan border */
                                        cursor: pointer;
                                        font-family: 'Play';
                                    }
                                    .button-checkout:hover{
                                        color: #A59E92;
                                        background-color: #272829;
                                        font-family: 'Play';
                                        border: none; /* Menghilangkan border */
                                    }
                                  </style>
                                  <button id="checkout-button" class="button-checkout btn btn-transparent d-inline-block mx-2" disabled>Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('customer.components.footer')

<script>
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var checkoutButton = document.getElementById('checkout-button');

    function calculateTotal() {
        var total = 0;
        var anyCheckboxChecked = false;

        // Mengambil semua checkbox yang dicentang
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                var quantity = parseFloat(checkbox.dataset.quantity);
                var hargaJual = parseFloat(checkbox.dataset.hargajual);
                total += quantity * hargaJual;
                anyCheckboxChecked = true; 
            }
        });

        checkoutButton.disabled = !anyCheckboxChecked;

        return total;
    }

    function updateTotal() {
        var totalAmountElement = document.getElementById('total-amount');
        var checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        
        totalAmountElement.textContent = 'Total (' + checkedCheckboxes.length + ' produk): Rp.' + calculateTotal().toFixed(2).replace('.00', '');
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateTotal();
        });
    });

    document.getElementById('checkout-button').addEventListener('click', function() {
        var checkedItems = [];
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checkedItems.push(checkbox.value);
            }
        });

        // Redirect ke halaman checkout dengan data yang dicentang
        var baseUrl = window.location.origin;
        var userId = {{ auth()->user()->id }};
        var checkoutUrl = baseUrl + '/' + userId + '/checkout?items=' + checkedItems.join(',');
        window.location.href = checkoutUrl;
    }); 
</script>
@endsection