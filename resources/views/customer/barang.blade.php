@extends('layouts.index')

@section('menuNavbar')
  @include('customer.components.menuNavbar')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alice&family=Pacifico&family=Play:wght@700&display=swap" rel="stylesheet">
<style>
  .input-quantity {
    display: flex;
    align-items: center;
  }

  .btn-quantity {
    padding: 5px 10px;
    border: none;
    background-color: #f0f0f0;
    cursor: pointer;
  }
  .price {
    float: right;
  }
</style>
<section class="content">
  @if(request()->input('search') === null)
    <div class="card">
      <div class="card-body" style="background-color: #f0f0f0">
        <div class="col-md-8 offset-md-2">
          <form action="{{ route('customer.produk') }}" method="GET">
              <div class="input-group">
                  <input type="search" class="form-control form-control-md"  name="search" value="{{ Request()->input('search') }}"  placeholder="Dapatkan barang disini...">
                  <div class="input-group-append">
                      <button type="submit" class="btn btn-md btn-default">
                          <i class="fa fa-search"></i>
                      </button>
                  </div>
              </div>
          </form>
      </div>
        <img class="img-fluid mt-2" src="{{ asset('images/image4.jpg') }}" alt="Photo">
      </div>
    </div>
  @endif
  <div class="container">
    <div class="row mt-4">
      <div class="col-lg-8">
        <div class="row">
          @foreach ($produk as $item)
            <div class="col-lg-4">
              <div class="card animate__animated animate__fadeInUp">
                <div class="card-header" style="background-color: #A59E92;">
                  <div class="float-right">
                    <h5 class="card-title m-0" style="font-family: 'Play', sans-serif; color:#272829">{{ $item->kategori->nama }}</h5>
                  </div>
                </div>
                <div class="card-body" style="background-color: #FEFBF6">
                  <h6><span style="font-family: 'Alice', serif; color:#272829"><center>{{ $item->pembelian->nama }} ({{ $item->merek->nama }}) - {{ $item->pembelian->jenis }}</center></span></h6>
                  <div class="position-relative">
                    <img src="{{ \Storage::url($item->image ) }}" alt="{{ $item->pembelian->nama }}" class="img-fluid">
                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon text-sm" style="background-color:#272829; color:#FEFBF6">
                        Rp.{{ $item->pembelian->hargaJual }}
                      </div>
                    </div>
                  </div>
                  <p class="card-text">
                  @if ($item->pembelian)
                      @if ($item->pembelian->stok == 0)
                        <span style="font-family: 'Alice', serif; color:#272829">Stok Habis</span>
                      @else
                        <span style="font-family: 'Alice', serif; color:#272829">tersisa {{ $item->pembelian->stok }} {{ $item->satuan->nama }} </span>
                      @endif
                  @endif
                  </p>
                  {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                  <input type="hidden" name="id_barang" value="{{ $item->id }}" id="">
                    <div class="row justify-content-center">
                      <div class="input-quantity">
                        <div class="container">
                            {!! Form::hidden('id_user', auth()->user() ? auth()->user()->id : null, ['class' => 'form-control']) !!}
                            {!! Form::hidden('id_pembelian',  $item->pembelian->id , ['class' => 'form-control ']) !!}
                            {!! Form::hidden('id_kategori',  $item->kategori->id , ['class' => 'form-control ']) !!}
                            {!! Form::hidden('id_merek',  $item->merek->id , ['class' => 'form-control ']) !!}
                            {!! Form::hidden('id_satuan',  $item->satuan->id , ['class' => 'form-control ']) !!}
                            <div class="row">
                              <div class="col-lg-9">
                                <input type="number" name="quantity" id="quantity" min="1" step="1" class="form-control{{ $errors->has('quantity') && $item->id == old('id_barang') ? ' is-invalid' : '' }}" placeholder="Masukan jumlah ..." value="{{ $errors->has('quantity') && $item->id == old('barang') ? old('quantity') : '' }}">
                                @if ($errors->has('quantity') && $item->id == old('id_barang'))
                                  <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                @endif
                              </div>
                              <div class="col-lg-3">
                                <style>
                                  .cart-button {
                                      color: #A59E92;
                                      border: none; /* Menghilangkan border */
                                      cursor: pointer;
                                    }
                                    .cart-button:hover{
                                      color: #272829;
                                      border: none; /* Menghilangkan border */
                                      cursor: pointer;
                                  }
                                </style>
                                <button type="submit" class="cart-button mt-1">
                                  <i class="material-icons">shopping_cart</i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="col-lg-4">
        <div class="row mt-2">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background-color: #A59E92;">
                  <h5 class="card-title m-0" style="font-family: 'Play', sans-serif; color:#272829">Jenis Motor</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <a href="{{ route('customer.produk') }}" class="text-center"><span style="font-family: 'Alice', serif; color:#272829"><h4>Semua</h4></span></a>
                    <ul>
                      <div class="justify-content-center row">
                        <div class="col-lg-12">                            
                          <div class="row">
                            @foreach ($jenisMotor as $item)
                              <div class="col-lg-6">
                                <input type="hidden" value="{{ $item }}" name="jenisMotor" class="motor-input">
                                <div class="form-group">
                                  <div class="custom-control custom-switch">
                                    <input type="radio" class="custom-control-input" id="customSwitch{{ $loop->index }}" name="jenisMotorSelected" value="{{ $item }}" @if ($search === $item ) checked @endif>
                                    <label class="custom-control-label active" for="customSwitch{{ $loop->index }}"><h5 class="card-title m-0" style="font-family: 'Play', sans-serif; color:#272829">{{ $item }}</h5></label>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                          <form action="{{ route('customer.produk') }}" method="GET">
                              <input type="hidden" name="search" id="selectedName" value="">
                              <button class="btn btn-navbar" type="submit"  id="submitButton" style="display: none">Submit</button>
                          </form>
                        </div>
                      </div>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const inputElements = document.querySelectorAll('.motor-input');
      const radioElements = document.querySelectorAll('input[type="radio"]');
      const selectedNameInput = document.getElementById('selectedName');
      const submitButton = document.getElementById('submitButton');


      inputElements.forEach((input) => {
          input.style.display = 'none';
      });

    
      const urlParams = new URLSearchParams(window.location.search);
      const searchValue = urlParams.get('search');

      radioElements.forEach((radio) => {
          radio.addEventListener('change', (event) => {
              const itemName = event.target.value;

              inputElements.forEach((input) => {
                  input.style.display = 'none';
              });

              inputElements.forEach((input) => {
                  if (input.value === itemName) {
                      input.style.display = 'block';
                  }
              });

              selectedNameInput.value = itemName;

              if (event.target.checked) {
                  submitButton.click();
              }
          });
      });
  });
</script>
@include('customer.components.footer')
@endsection