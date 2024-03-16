<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\CustomerController::class, 'customer'])->name('customer');
Route::get('/barang', [App\Http\Controllers\CustomerController::class, 'customerProduk'])->name('customer.produk');
Route::prefix('/')->middleware(['auth'])->group(function() {
    Route::get('/keranjang/{id}', [App\Http\Controllers\CustomerController::class, 'indexKeranjang'])->name('keranjang.index');
    Route::post('/store-keranjang', [App\Http\Controllers\CustomerController::class, 'storeKeranjang'])->name('keranjang.store');
    Route::get('/delete-keranjang/{id}', [App\Http\Controllers\CustomerController::class, 'deleteKeranjang'])->name('keranjang.destroy');
    Route::get('{id}/checkout', [App\Http\Controllers\CustomerController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/store', [App\Http\Controllers\CustomerController::class, 'storeCheckout'])->name('checkout.store');
    Route::get('/pembelanjaan/{id}', [App\Http\Controllers\CustomerController::class, 'indexPembelanjaan'])->name('pembelanjaan.index');
    Route::post('/layanan/service/store', [App\Http\Controllers\CustomerController::class, 'layananServiceStore'])->name('layananservice.store');
    Route::get('/diterima/customer/update', [App\Http\Controllers\CustomerController::class, 'updatePenerimaanBarangCustomer'])->name('terimabarang_customer.update');
    Route::get('/layanan/service/{id}', [App\Http\Controllers\CustomerController::class, 'detailLayananService'])->name('detail.layananservice');
});

Route::prefix('/')->middleware(['auth', 'auth.admin'])->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::prefix('/dashboard')->group(function() {
        // Kategori
        Route::get('/kategori', [App\Http\Controllers\KategoriController::class, 'kategori'])->name('kategori.index');
        Route::get('/add-kategori', [App\Http\Controllers\KategoriController::class, 'addKategori'])->name('kategori.create');
        Route::post('/store-kategori', [App\Http\Controllers\KategoriController::class, 'storeKategori'])->name('kategori.store');
        Route::get('/edit-kategori/{id}', [App\Http\Controllers\KategoriController::class, 'editKategori'])->name('kategori.edit');
        Route::put('/update-kategori/{id}', [App\Http\Controllers\KategoriController::class, 'updateKategori'])->name('kategori.update');
        Route::get('/delete-kategori/{id}', [App\Http\Controllers\KategoriController::class, 'deleteKategori'])->name('kategori.destroy');
        // Merek
        Route::get('/merek', [App\Http\Controllers\MerekController::class, 'merek'])->name('merek.index');
        Route::get('/add-merek', [App\Http\Controllers\MerekController::class, 'addMerek'])->name('merek.create');
        Route::post('/store-merek', [App\Http\Controllers\MerekController::class, 'storeMerek'])->name('merek.store');
        Route::get('/edit-merek/{id}', [App\Http\Controllers\MerekController::class, 'editMerek'])->name('merek.edit');
        Route::put('/update-merek/{id}', [App\Http\Controllers\MerekController::class, 'updateMerek'])->name('merek.update');
        Route::get('/delete-merek/{id}', [App\Http\Controllers\MerekController::class, 'deleteMerek'])->name('merek.destroy');
        // Satuan
        Route::get('/satuan', [App\Http\Controllers\SatuanController::class, 'satuan'])->name('satuan.index');
        Route::get('/add-satuan', [App\Http\Controllers\SatuanController::class, 'addSatuan'])->name('satuan.create');
        Route::post('/store-satuan', [App\Http\Controllers\SatuanController::class, 'storeSatuan'])->name('satuan.store');
        Route::get('/edit-satuan/{id}', [App\Http\Controllers\SatuanController::class, 'editSatuan'])->name('satuan.edit');
        Route::put('/update-satuan/{id}', [App\Http\Controllers\SatuanController::class, 'updateSatuan'])->name('satuan.update');
        Route::get('/delete-satuan/{id}', [App\Http\Controllers\SatuanController::class, 'deleteSatuan'])->name('satuan.destroy');
        // Barang
        Route::get('/barang', [App\Http\Controllers\BarangController::class, 'barang'])->name('barang.index');
        Route::get('/add-barang', [App\Http\Controllers\BarangController::class, 'addBarang'])->name('barang.create');
        Route::post('/store-barang', [App\Http\Controllers\BarangController::class, 'storeBarang'])->name('barang.store');
        Route::get('/edit-barang/{id}', [App\Http\Controllers\BarangController::class, 'editBarang'])->name('barang.edit');
        Route::put('/update-barang/{id}', [App\Http\Controllers\BarangController::class, 'updateBarang'])->name('barang.update');
        Route::get('/delete-barang/{id}', [App\Http\Controllers\BarangController::class, 'deleteBarang'])->name('barang.destroy');
         // Suplay
        Route::get('/suplay', [App\Http\Controllers\SuplayController::class, 'suplay'])->name('suplay.index');
        Route::get('/add-suplay', [App\Http\Controllers\SuplayController::class, 'addSuplay'])->name('suplay.create');
        Route::post('/store-suplay', [App\Http\Controllers\SuplayController::class, 'storeSuplay'])->name('suplay.store');
        Route::get('/edit-suplay/{id}', [App\Http\Controllers\SuplayController::class, 'editSuplay'])->name('suplay.edit');
        Route::put('/update-suplay/{id}', [App\Http\Controllers\SuplayController::class, 'updateSuplay'])->name('suplay.update');
        Route::get('/delete-suplay/{id}', [App\Http\Controllers\SuplayController::class, 'deleteSuplay'])->name('suplay.destroy');
        // Pembelian
        Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'pembelian'])->name('pembelian.index');
        Route::get('/add-pembelian', [App\Http\Controllers\PembelianController::class, 'addPembelian'])->name('pembelian.create');
        Route::post('/store-pembelian', [App\Http\Controllers\PembelianController::class, 'storePembelian'])->name('pembelian.store');
        Route::get('/edit-pembelian/{id}', [App\Http\Controllers\PembelianController::class, 'editPembelian'])->name('pembelian.edit');
        Route::put('/update-pembelian/{id}', [App\Http\Controllers\PembelianController::class, 'updatePembelian'])->name('pembelian.update');
        Route::get('/delete-pembelian/{id}', [App\Http\Controllers\PembelianController::class, 'deletePembelian'])->name('pembelian.destroy');
        // Barang Diterima
        Route::get('/diterima/update', [App\Http\Controllers\DashboardController::class, 'UpdatePenerimaanBarang'])->name('penerimaan_barang.update');
        Route::get('/layanan/services/update', [App\Http\Controllers\DashboardController::class, 'updateKonfirmasiLayanan'])->name('layanankonfirmasi.update');
        // Layanan
        Route::post('/layanan/store', [App\Http\Controllers\DashboardController::class, 'storeLayanan'])->name('layanan.store');
        Route::get('/layanankonfirmasi/store', [App\Http\Controllers\DashboardController::class, 'storeLayananKonfirmasi'])->name('layanankonfirmasi.store');
    });
});

Route::prefix('/admin')->middleware(['auth', 'auth.superAdmin'])->group(function() {
    Route::prefix('/dashboard')->group(function() {
        // Anggota
        Route::get('/', [App\Http\Controllers\DashboardController::class, 'dashboardAdmin'])->name('admin');
        Route::get('/anggota', [App\Http\Controllers\AnggotaController::class, 'anggota'])->name('anggota.index');
        Route::get('/tambah-anggota', [App\Http\Controllers\AnggotaController::class, 'addAnggota'])->name('anggota.create');
        Route::post('/anggota-store', [App\Http\Controllers\AnggotaController::class, 'storeAnggota'])->name('anggota.store');
        Route::get('/ubah-anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'editAnggota'])->name('anggota.ubah');
        Route::get('/ubah-akun-anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'editAkunAnggota'])->name('anggota.ubah-akun');
        Route::put('/update-akun-anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'updateAkunAnggota'])->name('anggota.update-akun');
        Route::put('/update-anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'updateAnggota'])->name('anggota.update');
        Route::get('/delete-anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'deleteAnggota'])->name('anggota.destroy');
        // User
        Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/show-user/{id}', [App\Http\Controllers\UserController::class, 'showUser'])->name('user.show');
        Route::get('/status-user/update', [App\Http\Controllers\UserController::class, 'updateStatusUser'])->name('user.status-update');
        Route::get('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('user.destroy');
        // Bank
        Route::get('/bank', [App\Http\Controllers\BankcompanyController::class, 'bankIndex'])->name('bank.index');
        Route::get('/add-bank', [App\Http\Controllers\BankcompanyController::class, 'addBank'])->name('bank.create');
        Route::post('/store-bank', [App\Http\Controllers\BankcompanyController::class, 'storeBank'])->name('bank.store');
        Route::get('/edit-bank/{id}', [App\Http\Controllers\BankcompanyController::class, 'editBank'])->name('bank.edit');
        Route::put('/update-bank/{id}', [App\Http\Controllers\BankcompanyController::class, 'updateBank'])->name('bank.update');
        Route::get('/delete-bank/{id}', [App\Http\Controllers\BankcompanyController::class, 'deleteBank'])->name('bank.destroy');
        // Laporan
        Route::get('/laporan/pembayaran', [App\Http\Controllers\DashboardController::class, 'laporanPembayaranIndex'])->name('laporan-pembayaran.index');
        Route::get('/laporan/pembayaran/show', [App\Http\Controllers\DashboardController::class, 'laporanPembayaranShow'])->name('laporan-pembayaran.show');
        Route::get('/laporan/penjualan', [App\Http\Controllers\DashboardController::class, 'laporanPenjualanIndex'])->name('laporan-penjualan.index');
        Route::get('/laporan/penjualan/show', [App\Http\Controllers\DashboardController::class, 'laporanPenjualanShow'])->name('laporan-penjualan.show');
        Route::get('/laporan/layanan', [App\Http\Controllers\DashboardController::class, 'laporanlayananServiceIndex'])->name('laporan-layanan-service.index');
        Route::get('/laporan/layanan/show', [App\Http\Controllers\DashboardController::class, 'laporanlayananServiceShow'])->name('laporan-layanan-service.show');
        Route::get('/laporan/barang/masuk', [App\Http\Controllers\DashboardController::class, 'laporanbarangMasukIndex'])->name('laporan-barangmasuk.index');
        Route::get('/laporan/barang/masuk/show', [App\Http\Controllers\DashboardController::class, 'laporanbarangMasukShow'])->name('laporan-barangmasuk.show');
        // Invoice
        Route::get('/invoice/{id}', [App\Http\Controllers\DashboardController::class, 'invoiceShow'])->name('invoice.show');
        Route::get('/konfirmasi/update', [App\Http\Controllers\DashboardController::class, 'updateStatusKonfirmasi'])->name('konfirmasi.update');
        // Pemberitahuan
        Route::get('/pemberitahuan/show/{id}', [App\Http\Controllers\DashboardController::class, 'pemberitahuanShow'])->name('pemberitahuan.show');
        Route::get('/pemberitahuan/', [App\Http\Controllers\DashboardController::class, 'pemberitahuanIndex'])->name('pemberitahuan.index');
        // Barang diterima
        Route::get('/diterima/update', [App\Http\Controllers\DashboardController::class, 'updateTerimaBarang'])->name('terima_barang.update');
        Route::post('/diterima/update', [App\Http\Controllers\DashboardController::class, 'storeTerimaBarang'])->name('terima_barang.store');
    });
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Auth::routes();

