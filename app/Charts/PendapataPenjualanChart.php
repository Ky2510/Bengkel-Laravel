<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Carbon\Carbon;
use App\Models\Checkout;
use Illuminate\Support\Facades\DB;


class PendapataPenjualanChart extends Chart
{
    public function __construct()
    {
        parent::__construct();
    }

    public function translateMonthToIndonesian($month)
    {
        $monthTranslations = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'July' => 'Juli',
            'June' => 'Juni',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        return $monthTranslations[$month];
    }

    public function buildChart()
    {
        $now = Carbon::now();
        
        $months = [];
        $incomeData = [];
        
        for ($i = 0; $i <= 3; $i++) {
            $monthYear = $now->format('Y-m');
            $currentMonth = $this->translateMonthToIndonesian($now->format('F'));
            
            $months[] = $currentMonth;
            
            // Cari data pendapatan untuk bulan saat ini
            $monthlyIncome = Checkout::select(
                DB::raw('SUM(keranjang.quantity * pembelian.hargaJual) as income')
            )
            ->join('keranjang', 'checkout.id_keranjang', '=', 'keranjang.id')
            ->join('pembelian', 'keranjang.id_pembelian', '=', 'pembelian.id')
            ->whereRaw('DATE_FORMAT(checkout.created_at, "%Y-%m") = ?', [$monthYear])
            ->first();
            
            $incomeData[] = $monthlyIncome ? $monthlyIncome->income : 0;
            
            $now->subMonth(); 
        }
        
        $this->labels(array_reverse($months));
        $this->dataset('Pendapatan', 'bar', array_reverse($incomeData))
            ->backgroundColor([
                'linear-gradient(to right, #A8A196, #7D7463)',
                'linear-gradient(to bottom, #053B50, #64CCC5)',
                'linear-gradient(to right, #A8A196, #7D7463)',
                'linear-gradient(to bottom, #053B50, #64CCC5)'
            ]);
        
        return view('dashboard.index', ['chart' => $this]);
    }
}
