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
            <a href="{{ route('dashboard') }}" class="nav-link  {{ \Route::is('dashboard') ? 'active' : '' }}">Dashboard</a>
        </li>
        @if (auth()->user()->akses == 'superadmin')
            <li class="nav-item">
                <a href="{{ route('admin') }}" class="nav-link  {{ \Route::is(['admin','anggota*','user*','bank*','laporan-barangmasuk*']) ? 'active' : '' }}">Admin</a>
            </li>
        @endif
        {{-- <li class="nav-item dropdown">
            @php
                $notifications = DB::table('notifications')->latest()->get();
                $uniqueTransactions = [];
            @endphp
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    Pembayaran
                </span>
                <div class="dropdown-divider"></div>
                @foreach ($notifications as $notification)
                    @php
                        $id_checkout = $notification->id_transaksi;
                        $checkout = \App\Models\Checkout::where('id_transaksi', $id_checkout)->first(); 
                    @endphp
                    @if ($notification->read_at == null)
                        @if (!in_array($checkout->id_transaksi, $uniqueTransactions))
                            @php
                                $uniqueTransactions[] = $checkout->id_transaksi;
                            @endphp
            
                            <a href="{{ route('pemberitahuan.show', [
                                    'model' => 'pemberitahuan',
                                    'id' => $notification->id,
                                ]) }}" class="dropdown-item">
                                    <i class="fas fa-envelope mr-2"></i>{{ $checkout->user->username }} melakukan pembayaran
                                    <span class="float-right text-muted text-sm"> 
                                        {{ $checkout->created_at->diffForHumans() }}
                                    </span>
                            </a>
                        @endif
                    @endif
                @endforeach
                <span class="dropdown-item dropdown-header">
                    {{ count($uniqueTransactions) }} Notifications
                </span>
        
                <div class="dropdown-divider"></div>
                <a href="{{ route('pemberitahuan.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell fa-lg"></i>
                @if (count($uniqueTransactions) !== 0)
                    <span class="badge navbar-badge badge-danger badge-xs" style="color: #272829; font-family: play;">
                        {{ count($uniqueTransactions) }}
                    </span>
                @endif
            </a>
        </li> --}}
    @else
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">Login</a>
        </li>
    @endauth
@endif
    <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" style="color: #EEEEEE"><span style="color: #EEEEEE; font-family: 'Play', sans-serif;">{{ auth()->user()->username }}</span></a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu" style="background-color:#A8A196;">
            <li><a href="{{ route('logout') }}" class="dropdown-item"><span style="color: #EEEEEE"><span style="color: #272829;  font-family: 'Play', sans-serif;">Logout</span> </a></li>
        </ul>
    </li>