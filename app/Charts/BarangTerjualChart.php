<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Carbon\Carbon;
use App\Models\Checkout;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;

class BarangTerjualChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function buildChart()
    {
        $namaBarangs = [];
        $incomeData = [];

        $pembelian = Pembelian::all();

        foreach ($pembelian as $item) {
            $namaBarangs[] = $item->nama;

            $stokTerjual = Checkout::join('keranjang', 'checkout.id_keranjang', '=', 'keranjang.id')
                ->where('keranjang.id_pembelian', $item->id)
                ->sum('keranjang.quantity');

            $incomeData[] = $stokTerjual; 
        }

        $this->labels(array_reverse($namaBarangs));

        $this->dataset('Stok Terjual', 'bar', array_reverse($incomeData))
            ->backgroundColor([
                'linear-gradient(to right, #A8A196, #7D7463)',
                'linear-gradient(to bottom, #053B50, #64CCC5)',
                'linear-gradient(to right, #A8A196, #7D7463)',
                'linear-gradient(to bottom, #053B50, #64CCC5)'
            ]);

        return view('dashboard.index', ['chart' => $this]);
    }
}
