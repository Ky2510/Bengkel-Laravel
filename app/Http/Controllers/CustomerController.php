<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang as Model;
use Illuminate\Support\Facades\Validator;
use App\Notifications\PembayaranNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\Checkout;
use App\Models\Pembelian;
use App\Models\Keranjang;
use App\Models\bankCompany;
use App\Models\Datauser;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\LayananService;
use App\Models\KirimBarang;
use App\Models\Merek;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    private $viewIndex = 'index';
    private $viewKeranjang = 'keranjang';
    private $viewBarang = 'barang';
    private $viewPembelanjaan = 'pembelanjaan';
    private $routePrefixKeranjang = 'keranjang';
    private $routePrefixPembelanjaan = 'pembelanjaan';
    private $routePrefixCheckout = 'checkout';

    public function customer(Request $request)
    {
        $search = $request->input('search');
        $new = Barang::latest()->take(4)->get();
        $kategori = Barang::whereHas('kategori', function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
        ->with('kategori')
        ->latest()->get();

        $idUser = null;
        $namaPertama = ''; 
        $namaTerakhir = ''; 

        if (auth()->check()) {
            $layananServices = layananservice::where('id_datauser', auth()->user()->id)->get();
            foreach ($layananServices as $value) {
                $idUser = $value->id_datauser;
            }
            $dataUser = Datauser::where('id_user', $idUser)->get();
            foreach ($dataUser as $valueDU) {
                $namaPertama = $valueDU->namaPertama;
                $namaTerakhir = $valueDU->namaTerakhir;
            }
        }
        $layanan = LayananService::all();
        $kategoriArray = $kategori->pluck('id_kategori')->toArray();
        $uniqueKategoriArray = array_unique($kategoriArray);
        $kategoris = Kategori::whereIn('id', $uniqueKategoriArray)->get();
        return view('customer.' . $this->viewIndex, [
            'title' => 'Home',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefixKeranjang' => $this->routePrefixKeranjang,
            'route' => $this->routePrefixKeranjang . '.store',
            'produk' => $new,
            'kategoriCount' => $kategori->count(),
            'search' => $request->input('search'),
            'kategori' => $kategoris,
            'namaPertama' => $namaPertama,
            'namaTerakhir' => $namaTerakhir,
            'allLayanan' => $layanan,
            'userID' => $idUser,
            'model' => new LayananService(),
            'method' => 'POST',
            'routePrefix' => 'customer',
            'route' => 'layananservice.store',
            'button' => 'Submit',
        ]);
    }

    public function layananServiceStore(Request $request)
    {
        $request->validate([
            'keluhan' => 'required',
            'nama_motor' => 'required',
            'jenis_motor' => 'required',
        ],[
            'nama_motor.required' => 'Nama Motor wajib diisi',
            'jenis_motor.required' => 'Jenis Motor wajib diisi',
            'keluhan.required' => 'Keluhan wajib diisi.',
        ]);
        $kode_acak = Str::random(12);

        LayananService::create([
            'id_layanan' => $kode_acak,
            'id_datauser' => $request->id_datauser,
            'keluhan' => $request->keluhan,
            'nama_motor' => $request->nama_motor,
            'jenis_motor' => $request->jenis_motor,
        ]);

        return redirect()->back();
    }

    public function customerProduk (Request $request)
    {
        $jenisMotor = Pembelian::pluck('jenis')->toArray();
        $search = $request->input('search');
        $barang = Barang::whereHas('pembelian', function ($query) use ($search) {
                        $query->where('jenis', 'like', '%' . $search . '%')
                              ->orWhere('nama', 'like', '%' . $search . '%');
                    })->orWhereHas('kategori', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%'); 
                    })
                    ->with('pembelian')
                    ->latest()->get();
  
        return view('customer.' . $this->viewBarang, [
            'title' => 'Home',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefixKeranjang' => $this->routePrefixKeranjang,
            'route' => $this->routePrefixKeranjang . '.store',
            'produk' => $barang,
            'search' => $request->input('search'),
            'jenisMotor' => array_unique($jenisMotor),
        ]);
    }

    public function indexKeranjang(Request $request, $id)
    {
        $userId = auth()->user()->id; 
        $models = Model::where('id_user', $userId)->get();
        return view('customer.' . $this->viewKeranjang, [
            'title' => 'Keranjang',
            'breadscrumbs' => 'Home',
            'miniTitle' => 'Keranjang Anda',
            'routePrefixKeranjang' => $this->routePrefixKeranjang,
            'models' => $models,
            'countProduk' => $models->count(),
        ]);
    }

    public function storeKeranjang(Request $request)
    {
        $item = Barang::find($request->input('id_barang'));
        if ($item) {
            $customMessages = [
                'quantity.required' => 'Kuantitas wajib diisi.',
                'quantity.max' => $item->pembelian->stok == 0 ? 'Maaf stok habis.' : 'Kuantitas melibihi stok yang tersedia.',
            ];

            $rules = [
                'quantity' => [
                    'required',
                    'numeric',
                    'min:1',
                    'max:' . $item->pembelian->stok,
                ],
            ];

            $validatedData = $request->validate($rules, $customMessages);
        }


        $keranjang = new Model();
        $keranjang->id_user = $request->id_user;
        $keranjang->id_pembelian = $request->id_pembelian;
        $keranjang->id_kategori = $request->id_kategori;
        $keranjang->id_merek = $request->id_merek;        
        $keranjang->id_satuan = $request->id_satuan;        
        $keranjang->id_barang = $request->id_barang;        
        $keranjang->quantity = $request->quantity;      
        $keranjang->created_at = now();      
        $keranjang->save();
        
        return redirect()->route($this->routePrefixKeranjang . '.index', auth()->user()->id)->with('success', 'Barang berhasil dimasukan .');
    }

    public function deleteKeranjang(Request $request, $id)
    {
        $keranjang = Model::findOrFail($id);
        if ($keranjang->id_user == auth()->user()->id) {
            $keranjang->delete();
        }else{
            return redirect()->back();
        }
        return redirect()->route($this->routePrefixKeranjang . '.index', auth()->user()->id)->with('danger', 'Barang berhasil hapus.');
    }

    public function showCheckout(Request $request)
    {
        $itemIds = explode(',', $request->query('items'));
        if (count($itemIds) === 1 && $itemIds[0] === "") {
            return redirect()->route('keranjang.index', auth()->user()->id);
        }
        $selectedItems = Model::whereIn('id', $itemIds)->get();
        $totalPrice = 0;
        foreach ($selectedItems as $item) {
            $totalPrice += $item->quantity * $item->pembelian->hargaJual;
            if ($item->id_user != auth()->user()->id) {
                return redirect()->back();
            }
        }
        $bankCompanies = bankcompany::get();
        $listBankC = [];
        foreach ($bankCompanies as $bank) {
            $listBankC[$bank->id] = $bank->nama_bank . ' - ' . $bank->nama_rekening . ' - ' .  $bank->nomor_rekening;
        }

        return view('customer.checkout', [
            'selectedItems' => $selectedItems,
            'totalPrice' => $totalPrice, 
            'title' => 'Checkout',
            'listBankC' => $listBankC,
            'breadscrumbs' => 'Home',
            'breadscrumbs1' => 'Chekcout',
            'miniTitle' => 'Keranjang Anda',
            'miniTitle1' => 'Metode Pembayaran Bank',
            'routePrefixKeranjang' => $this->routePrefixKeranjang,
            'route' => $this->routePrefixCheckout . '.store',
            'method' => 'POST',
            'button' => 'Bayar Sekarang',
            'listBank' => bankCompany::get(),
        ]);
    }

    public function storeCheckout(Request $request)
    {
        $requestData = $request->validate([
            'id_bank' => 'required',
            'noRek' => 'required',
            'namaRek' => 'required',
            'status_pengiriman' => 'required',
            'alamat_pengiriman' => 'required_if:status_pengiriman,ditempat',
        ],[
            'id_bank.required' => 'Metode pembayaran wajib dipilih.',
            'status_pengiriman.required' => 'Status pengiriman wajib diisi.',
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'noRek.required' => 'Nomor rekening wajib diisi.',
            'namaRek.required' => 'Nama rekening wajib diisi.',
        ]);
        $idUser = $request->input('id_user');
        $idKeranjangs = $request->input('id_keranjang');
        $idBanks = $request->input('id_bank');
        
        $allKeranjang = Keranjang::all();
        $pembelian = Pembelian::whereIn('id', $request->input('id'))->get();
        $stokArray = $pembelian->pluck('stok')->toArray();

        $tanggal_pembayaran = Carbon::now()->format('Ymd');
        $kode_acak = Str::random(12);
        $id_transaksi = $tanggal_pembayaran . $kode_acak;
        
        if (is_array($idKeranjangs)) {
            foreach ($idKeranjangs as $idKeranjang) {
                // Membuat catatan checkout
                $checkout = new Checkout();
                $checkout->id_user = $idUser;
                $checkout->id_transaksi = $id_transaksi;
                $checkout->id_keranjang = $idKeranjang;
                $checkout->id_bank = $idBanks;
                $checkout->noRek = $request->noRek;
                $checkout->namaRek = $request->namaRek;
                $checkout->status_pengiriman = $request->status_pengiriman;
                $checkout->alamat_pengiriman = $request->alamat_pengiriman;
                $checkout->save();
            
        
                // Mengubah status keranjang
                $keranjang = Keranjang::findOrFail($idKeranjang);
                $keranjang->status = 'Sudah dibayar';
                $keranjang->save();
        
                // Mengurangi stok berdasarkan kuantitas
                foreach ($allKeranjang as $index => $keranjangItem) {
                    $quantityArray = $keranjangItem->quantity;
                    
                    if (isset($stokArray[$index])) {
                        $newStok = $stokArray[$index] - $quantityArray;
                        $pembelian[$index]->update(['stok' => $newStok]);
                    }
                }


            }
        } else {
            // Jika hanya satu keranjang
            $idKeranjang = $idKeranjangs;
        
            // Membuat catatan checkout
            $checkout = new Checkout();
            $checkout->id_user = $idUser;
            $checkout->id_transaksi = $id_transaksi;
            $checkout->id_keranjang = $idKeranjang;
            $checkout->id_bank = $idBanks;
            $checkout->noRek = $request->noRek;
            $checkout->namaRek = $request->namaRek;
            $checkout->status_pengiriman = $request->status_pengiriman;
            $checkout->alamat_pengiriman = $request->alamat_pengiriman;
            $checkout->save();
        
            // Mengubah status keranjang
            $keranjang = Keranjang::findOrFail($idKeranjang);
            $keranjang->status = 'Sudah dibayar';
            $keranjang->save();
        
            // Mengurangi stok berdasarkan kuantitas
            foreach ($allKeranjang as $index => $keranjangItem) {
                $quantityArray = $keranjangItem->quantity;
                
                if (isset($stokArray[$index])) {
                    $newStok = $stokArray[$index] - $quantityArray;
                    $pembelian[$index]->update(['stok' => $newStok]);
                }
            }
        }

        $lastCheckout = Checkout::latest('created_at')->first();

        if ($lastCheckout) {
            $id_transaksi = $lastCheckout->id_transaksi;
            $user = User::find($idUser);
        } else {
            dd('Tidak ada checkout yang ditemukan.');
        }

        $uuid = Str::uuid();
        DB::table('notifications')->insert([
            'id' => $uuid,
            'id_transaksi' => $id_transaksi,
            'id_user' => $idUser,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route($this->routePrefixPembelanjaan . '.index', auth()->user()->id);
    }

    public function indexPembelanjaan(Request $request, $id)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $today = Carbon::now()->format('Y-m-d');
        $modelsToday = Checkout::whereDate('created_at', $today)->get();
        $models = Checkout::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get();
        return view('customer.' . $this->viewPembelanjaan, [
            'title' => 'Pembelanjaan',
            'breadscrumbs' => 'Home',
            'miniTitle' => 'Pembelanjaan Anda',
            'routePrefixPembelanjaan' => $this->routePrefixPembelanjaan,
            'routePrefixKeranjang' => $this->routePrefixKeranjang,
            'models' => $models,
            'kirimBarang' => KirimBarang::get(),
            'today' => Carbon::now()->format('Y-m-d'),
            'modelsToday' => $modelsToday,
        ]);
    }

    public function updatePenerimaanBarangCustomer(Request $request)
    {
        $models = KirimBarang::where('id_checkout', $request->id)->get();
        if ($request->model == 'terimabarangcustomer') {
            foreach ($models as $model) {
                $model->status_barang = 'diterima';
                $model->save();
            }

            return redirect()->back()->with('success', 'Anggota siap untuk mengantarkan.');
        }
    }

    public function detailLayananService(Request $request, $id)
    {
        $layanan = LayananService::where('id', $id)->first();
        return view('customer.detailLayananService',[
            'title' => 'Detail',
            'layanan' => $layanan,
        ]);
    }
}
