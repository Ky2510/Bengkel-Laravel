<style>
    .nav-link {
      text-decoration: none;
      color: #EEEEEE;
      font-family: 'Play', sans-serif;
      transition: font-size 0.3s, color 0.3s; 
    }
  
    .nav-link:hover,
    .nav-link.active {
      font-size: 1.1em;
      color: #272829; 
    }
</style>

@if (Route::has('login'))
    @auth
        <li class="nav-item">
            <a href="{{ route('customer') }}" class="nav-link {{ \Route::is('customer') ? 'active' : '' }}">Home</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('customer.produk') }}" class="nav-link {{ \Route::is('customer.produk') ? 'active' : '' }}">Barang</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('keranjang.index', auth()->user()->id) }}" class="nav-link {{ \Route::is('keranjang.index') ? 'active' : '' }}">Keranjang</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pembelanjaan.index', auth()->user()->id) }}" class="nav-link {{ \Route::is('pembelanjaan.index') ? 'active' : '' }}">Pembelian</a>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" style="color: #EEEEEE"><span style="color: #EEEEEE; font-family: 'Play', sans-serif;">{{ auth()->user()->username }}</span></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu" style="background-color:#A8A196;">
                @if (auth()->user()->akses == 'admin')
                    <li><a href="{{ route('dashboard') }}" class="dropdown-item"><span style="color: #EEEEEE"><span style="color: #272829;  font-family: 'Play', sans-serif;">Dashboard</span> </a></li>
                @elseif(auth()->user()->akses == 'superadmin')
                    <li><a href="{{ route('admin') }}" class="dropdown-item"><span style="color: #EEEEEE"><span style="color: #272829;  font-family: 'Play', sans-serif;">Dashboard</span> </a></li>
                @endif
                <li><a href="{{ route('logout') }}" class="dropdown-item"><span style="color: #EEEEEE"><span style="color: #272829;  font-family: 'Play', sans-serif;">Logout</span> </a></li>
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a href="{{ route('customer') }}" class="nav-link {{ \Route::is('customer') ? 'active' : '' }}">Home</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('customer.produk') }}" class="nav-link {{ \Route::is('customer.produk') ? 'active' : '' }}">Barang</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link {{ \Route::is('login') ? 'active' : '' }}">Login</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('register') }}" class="nav-link {{ \Route::is('register') ? 'active' : '' }}">Register</a>
        </li>
        <br>
    @endauth
@endif