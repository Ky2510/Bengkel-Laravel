<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Checkout;
use App\Models\Keranjang;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Merek;
use App\Models\User;
use App\Models\Satuan;
use App\Models\Suplay;
use App\Models\DataUser;
use App\Models\Pembelian;
use App\Models\KirimBarang;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;
use App\Models\Bankcompany;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Charts\PendapataPenjualanChart;
use App\Notifications\PembayaranNotification;
use App\Charts\BarangTerjualChart;
use App\Models\LayananService;
use App\Models\ServiceBarang;

class DashboardController extends Controller
{
    private $viewIndex = 'index';
    private $viewIndexAdmin = 'index';
    private $viewIndexLaporanPembayaran =  'laporanPembayaranIndex';
    private $viewInvoiceShow =  'invoiceShow';
    private $viewShowLaporanPembayaran =  'laporanPembayaranShow';
    private $viewIndexLaporanPenjualan =  'laporanPenjualanIndex';
    private $viewIndexLaporanLayananService =  'laporanLayananServiceIndex';
    private $viewShowLaporanPenjualan =  'laporanPenjualanShow';
    private $viewLaporanBarangMasukIndex =  'laporanBarangMasukIndex';
    private $viewLaporanBarangMasukShow =  'laporanBarangMasukShow';
    private $routePrefixLPembayaran = 'laporan-pembayaran';
    private $routePrefixLBarangMasuk = 'laporan-barangmasuk';
    private $routePrefixLLayananService = 'laporan-layanan-service';
    private $routePrefixLPenjualan = 'laporan-penjualan';
    private $routePrefix = 'terima_barang';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefixLPembayaran . '.index', 'label' => 'Laporan Pembayaran'],
            [
                'route' => $this->routePrefixLPembayaran . '.show',
                'label' => \Route::currentRouteName() == $this->routePrefixLPembayaran . '.show' ? 'Data Laporan Pembayaran' : '',
            ],
        ];

        $this->breadcrumbsLBarangMasuk = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefixLBarangMasuk . '.index', 'label' => 'Laporan Barang Masuk'],
            [
                'route' => $this->routePrefixLBarangMasuk . '.show',
                'label' => \Route::currentRouteName() == $this->routePrefixLBarangMasuk . '.show' ? 'Data Laporan Barang Masuk' : '',
            ],
        ];

        $this->breadcrumbsLpenjualan = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefixLPenjualan . '.index', 'label' => 'Laporan Penjualan'],
        ];

        $this->breadcrumbsLLayananService = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefixLLayananService . '.index', 'label' => 'Laporan Penjualan'],
        ];

        $this->breadcrumbsPemberitahuan = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => 'pemberitahuan.index', 'label' => 'Pemberitahuan'],
        ];
    }

    public function dashboard(Request $request)
    {
        $chartPendapatanPenjualan = new PendapataPenjualanChart;
        $chartBarangTerjual = new BarangTerjualChart;
        $chartPendapatanPenjualan->buildChart();
        $chartBarangTerjual->buildChart();
        $userId = auth()->user()->id;
        $anggota = Anggota::where('user_id', $userId)->get(); 
        foreach ($anggota as $value) {
            $id = $value->id;
        }
        $kirimBarang = KirimBarang::where('id_anggota', $id)->get();
        $pengirimanBarangCount = KirimBarang::where('id_anggota', $id)->count();

        return view('dashboard.' . $this->viewIndex, [
            'title' => 'Dashboard',
            'barangCount' => Barang::count(),
            'kategoriCount' => Kategori::count(),
            'merekCount' => Merek::count(),
            'satuanCount' => Satuan::count(),
            'suplayCount' => Suplay::count(),
            'pembelianCount' => Pembelian::count(),
            'layananService' => LayananService::all(),
            'serviceBarang' => ServiceBarang::all(),
            'listBarang' => Pembelian::get()->pluck('nama', 'id'),
            'pengirimanBarangCount' => $pengirimanBarangCount,
            'pengirimanBarang' => $kirimBarang,
            'chartPendapatanPenjualan' => $chartPendapatanPenjualan,
            'chartBarangTerjual'=> $chartBarangTerjual,
            'model' => new ServiceBarang(), 
        ]);
    }

    public function dashboardAdmin(Request $request)
    {
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Dashboard',
            'pembelianCount' => Pembelian::count(),
            'pembayaranCount' => Checkout::count(),
            'anggotaCount' => User::where('akses','admin')->count(),
            'bankCount' => Bankcompany::count(),
            'userTerdaftarCount' => User::where('akses','customer')->count(),
            'layananServiceCount' => LayananService::count(),
        ]);
    }

    public function storeLayanan(Request $request)
    {
        if (request()->input('harga') != null) {
            LayananService::where('id', $request->id_layananservice)->update([
                'harga' =>  $request->input('harga')
            ]);
        }

        ServiceBarang::create([
            'id_layananservice' => $request->id_layananservice,
            'id_barang' => $request->id_barang,
            'stok_barang' => $request->stok_barang,
            'id_anggota' => auth()->user()->id,
        ]);

        return redirect()->back();

    }

    public function storeLayananKonfirmasi(Request $request)
    {
        if($request->model == 'layanankonfirmasi'){
            LayananService::where('id', $request->id)->update([
                'barang' => 'true',
            ]);
        }

        return redirect()->back();
    }

    public function laporanPembayaranIndex(Request $request)
    {
        return view('dashboard.admin.laporan.' . $this->viewIndexLaporanPembayaran, [
            'breadcrumbs' => $this->breadcrumbs,
            'title' => 'Laporan Pembayaran',
            'miniTitle' => 'Laporan Pembayaran',
            'listBank' => Bank::get()->pluck('nama_bank', 'sandi_bank'),
        ]);
    }

    public function laporanPembayaranShow(Request $request)
    {
        $searchAtasNama = $request->input('atas_nama');
        $searchBank = $request->input('bank');
        $searchTransaksi = $request->input('id_transaksi');
        $searchTanggal = $request->input('tgl_pembayaran');
        $pembayaranToday = []; 
        if ($searchTransaksi) {
            $reportPembayaran = Checkout::where('id_transaksi', 'like', '%' . $searchTransaksi . '%')->latest()->get();
        }elseif ($searchBank) {
            $reportPembayaran = Checkout::whereHas('bank', function($query) use ($searchBank){
                                $query->where('kode', 'like', '%' . $searchBank . '%');
                            })->latest()->get();
        }elseif ($searchAtasNama) {
             $reportPembayaran = Checkout::where('namaRek', 'like', '%' . $searchAtasNama . '%')->latest()->get();
        }elseif($searchTanggal) {
            $reportPembayaran = Checkout::where('created_at', 'like', '%' . $searchTanggal . '%')->latest()->get();
        }else {
            $today = Carbon::now()->format('Y-m-d');
            $reportPembayaran = Checkout::whereDate('created_at', $today)->latest()->get();
            $pembayaranToday = $reportPembayaran; 
        }

        $listAnggota = ['' => 'Pilih Anggota'] + Anggota::get()->pluck('nama', 'id')->toArray();

      
        return view('dashboard.admin.laporan.' . $this->viewShowLaporanPembayaran, [
            'title' => 'Laporan Pembayaran',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Laporan Pembayaran',
            'reportPembayaran' => $reportPembayaran,
            'pembayaranToday'=> $pembayaranToday,
            'model' => new KirimBarang(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
            'listAnggota' => $listAnggota,
        ]);
    }

    public function laporanlayananServiceIndex(Request $request)
    {
        $searchIDLayanan = $request->input('id_layanan');
        $reportLayananService = LayananService::where('id_layanan', 'like', '%' . $searchIDLayanan . '%')
                                              ->latest()->get();
                                      
        return view('dashboard.admin.laporan.' . $this->viewIndexLaporanLayananService, [
            'title' => 'Laporan Layanan Service',
            'breadcrumbs' => $this->breadcrumbsLLayananService,
            'miniTitle' => 'Laporan Layanan Service',
            'reportLayananService' => $reportLayananService,
        ]);
    }

    public function laporanPenjualanIndex(Request $request)
    {
        $startDate = Carbon::parse($request->input('awal'));
        $endDate = Carbon::parse($request->input('akhir'));
        $searchNamaBarang = $request->input('nama_barang');
        $reportPenjualan = Keranjang::whereHas('pembelian', function ($query) use ($searchNamaBarang){
                                        $query->where('nama', 'like', '%' . $searchNamaBarang . '%');
                                    })->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)
                                      ->with('pembelian')->latest()->get();
                                      
        return view('dashboard.admin.laporan.' . $this->viewIndexLaporanPenjualan, [
            'title' => 'Laporan Penjualan',
            'breadcrumbs' => $this->breadcrumbsLpenjualan,
            'miniTitle' => 'Laporan Penjualan',
            'reportPenjualan' => $reportPenjualan,
        ]);
    }

    public function laporanbarangMasukIndex(Request $request)
    {
        return view('dashboard.admin.laporan.' . $this->viewLaporanBarangMasukIndex, [
            'title' => 'Laporan Barang Masuk', 
            'breadcrumbs' => $this->breadcrumbsLBarangMasuk,
            'miniTitle' => 'Laporan Barang Masuk',
        ]);
    }

    public function laporanBarangMasukShow(Request $request)
    {
        $searchNama = $request->input('nama');
        $searchTanggal = $request->input('tgl');
        $barangMasukToday = []; 
        
        if ($searchNama) {
            $reportBarangMasuk = Pembelian::where('nama', 'like', '%' . $searchNama . '%')->latest()->get();
        }elseif($searchTanggal){
            $reportBarangMasuk = Pembelian::where('created_at', 'like', '%' . $searchTanggal . '%')->latest()->get();
        }else{
            $today = Carbon::now()->format('Y-m-d');
            $reportBarangMasuk = Pembelian::whereDate('created_at', $today)->latest()->get();
            $barangMasukToday = $reportBarangMasuk; 
        }
        $today = Carbon::now()->format('Y-m-d');
        return view('dashboard.admin.laporan.' . $this->viewLaporanBarangMasukShow, [
            'title' => 'Laporan Barang',
            'breadcrumbs' => $this->breadcrumbsLBarangMasuk,
            'miniTitle' => 'Laporan Barang Masuk',
            'reportBarangMasuk' => $reportBarangMasuk,
            'barangMasukToday' => $barangMasukToday,
        ]);
        
    }

    public function invoiceShow (Request $request, $id)
    {
        $checkout = Checkout::findOrFail($id);
        $invoiceIDAwal = Str::substr($checkout->id_transaksi, -4);
        $invoiceIDTengah = Str::substr($checkout->id_transaksi, -8, 4);
        $invoiceIDAkhir = Str::substr($checkout->id_transaksi, 8, -8);
        $id_user = $checkout->id_user;
        $dataUser = DataUser::where('id_user', $id_user)->get();

        foreach ($dataUser as $value) {
            $namaPertamaCustomer = $value->namaPertama;
            $namaTerakhirCustomer = $value->namaTerakhir;
            $alamatCustomer = $value->alamat;
        }
        $dataAdmin = Anggota::where('user_id', auth()->user()->id)->get();
        foreach ($dataAdmin as $value) {
            $namaAdmin = $value->nama; 
            $alamatAdmin = $value->alamat;
            $noHpAdmin = $value->no_hp; 
        }
        return view('dashboard.admin.laporan.' . $this->viewInvoiceShow,[
            'items' => $checkout,
            'namaPertamaCustomer' => $namaPertamaCustomer,
            'namaTerakhirCustomer' => $namaTerakhirCustomer,
            'alamatCustomer' => $alamatCustomer,
            'namaAdmin' => $namaAdmin,
            'alamatAdmin' => $alamatAdmin,
            'noHpAdmin' => $noHpAdmin,
            'invoiceIDAwal' => $invoiceIDAwal,
            'invoiceIDTengah' => $invoiceIDTengah,
            'invoiceIDAkhir' => $invoiceIDAkhir,
        ]);
    }

    public function updateStatusKonfirmasi(Request $request)
    {
        if ($request->model == 'checkout') {
            $model = Checkout::findOrFail($request->id);
            $model->status = 'Konfirmasi';
            $model->save();
            
            if ($request->status == 'konfirmasi') {
                return redirect()->back()->with('success', 'Checkout berhasil dikonfirmasi.');
            }else{
                return redirect()->back()->with('danger', 'User berhasil dibelum konfirmasi.');
            }
        }
    }

    public function updateTerimaBarang(Request $request)
    {
        if ($request->model == 'bengkel') {
            $model = Checkout::findOrFail($request->id);
            $model->barang_diterima = now();
            $model->save();
            
            return redirect()->back()->with('success', 'Barang sudah diterima.');
        }
    }

    public function storeTerimaBarang(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required',
        ],[
            'id_anggota.required' => 'Anggota wajib dipilih.',
        ]);
        
        KirimBarang::create([
            'id_checkout' => $request->id_checkout,
            'id_anggota' => $request->id_anggota,
            'status_barang' => $request->status_barang,
            'konfirmasi_barang' => $request->konfirmasi_barang,
        ]);

        return redirect()->back()->with('success', 'Anggota siap untuk mengantarkan.');
    }
    
    public function updateKonfirmasiLayanan(Request $request)
    {
        if ($request->model == 'layananservices') {
            $model = LayananService::findOrFail($request->id);
            $t = $model->status = 'konfirmasi';
            $model->id_anggota = auth()->user()->id;
            $model->save();
        }

        return redirect()->back()->with('success', 'Anggota berhasil mengkonfirmasi layanan service.');
    }

    public function UpdatePenerimaanBarang(Request $request)
    {
        if ($request->model == 'terimaBarang') {
            $model = KirimBarang::findOrFail($request->id);
            $model->konfirmasi_barang = 'aktif';
            $model->save();

            return redirect()->back()->with('success', 'Anggota siap untuk mengantarkan.');
        }

    }


    public function pemberitahuanShow(Request $request, $id)
    {
        $notifications = DB::table('notifications')->where('id', $id)->first();
        if ($notifications == null ) {
            return redirect()->route('dashboard');
        }

        if ($request->model == 'pemberitahuan') {
            DB::table('notifications') ->where('id', $request->id) ->update([
                'read_at' => now(),
            ]);
        }
        
        $id_checkout = $notifications->id_transaksi;
        $checkout = Checkout::where('id_transaksi', $id_checkout)->get(); 
        $notificationId = $request->id;
        $notification = DB::table('notifications')->find($notificationId);
        if ($notification) {
            if ($request->input('model') === 'pemberitahuan') {
                DB::table('notifications')
                    ->where('id', $notificationId)
                    ->update(['read_at' => now()]);
            }
        }
       
        foreach ($checkout as $item) {
            $id_user = $item->id_user;
            $created_at = $item->created_at;
        }
        $dataUser = DataUser::where('id_user', $id_user)->get();
        if (!empty($dataUser)) {
            foreach ($dataUser as $value) {
                $namaPertamaCustomer = $value->namaPertama;
                $namaTerakhirCustomer = $value->namaTerakhir;
            }
        }
        return view('dashboard.admin.pemberitahuanShow', [
            'title' => 'Pembayaran ' . $namaPertamaCustomer . ' ' . $namaTerakhirCustomer,
            'checkoutIDTransaksi' => $checkout,
            'checkout' => $checkout,
            'created_at' => $created_at,
        ]);
    }

    public function pemberitahuanIndex(Request $request)
    {
        $notifications = DB::table('notifications')->latest()->get(['id','id_transaksi','read_at', 'id_user']);
        $checkout_id_values = $notifications->pluck('id_transaksi')->toArray();
        $user_id_values = $notifications->pluck('id_user')->toArray();
        $notification_id_values = $notifications->pluck('id')->toArray();
        $checkouts = Checkout::whereIn('id_transaksi', $checkout_id_values)
                            ->whereIn('id_user', $user_id_values)
                            ->get();

        $notificationIds = DB::table('notifications')
            ->join('checkout', 'notifications.id_transaksi', '=', 'checkout.id_transaksi')
            ->select('notifications.id')
            ->get()
            ->pluck('id')
            ->toArray();
        
        $dataUserByUserId = [];
        $dataUser = DataUser::whereIn('id_user', $user_id_values)->get();
        foreach ($dataUser as $user) {
            $namaPertamaCustomer[$user->id_user] = $user->namaPertama;
            $namaTerakhirCustomer[$user->id_user] = $user->namaTerakhir;
        }

        return view('dashboard.admin.pemberitahuanIndex', [
            'title' => 'Pemberitahuan',
            'checkouts' => $checkouts,
            'notifications' => $notifications,
            'namaPertamaCustomer' => $namaPertamaCustomer,
            'namaTerakhirCustomer' => $namaTerakhirCustomer,
            'breadcrumbs' => $this->breadcrumbsPemberitahuan,
        ]);
    }
}
