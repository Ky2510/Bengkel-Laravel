<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Checkout extends Model
{
    use HasFactory;
    protected $fillable = ['id_user','id_transaksi','id_keranjang', 'id_bank', 'noRek', 'namaRek', 'status_pengiriman','alamat_pengiriman', 'barang_diterima'];
    protected $table = 'checkout';


    public function kirimBarang(): HasMany
    {
        return $this->HasMany(KirimBarang::class, 'id_checkout');
    }

    public function keranjang(): BelongsTo
    {
        return $this->BelongsTo(Keranjang::class, 'id_keranjang');
    }

    public function bank(): BelongsTo
    {
        return $this->BelongsTo(bankCompany::class, 'id_bank');
    }
    
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
}
