<?php

namespace App\Http\Controllers\Modules\Admin;


use App\Models\Warga;
use App\Helpers\BreadcrumbHelper;
use App\Models\TransaksiJimpitan;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\PengeluaranJimpitan;
use App\Models\User;


class DashboardController extends Controller
{
    protected $dashboardService;

    public function index()
    {
        // Hitung jumlah warga
        $totalWarga = Warga::count();

        // Hitung total penerimaan (sum semua transaksi jimpitan)
        $totalPenerimaan = TransaksiJimpitan::sum('jumlah');

        // Hitung total petugas (user dengan role 'user' / 'petugas' sesuai spatie)
        $totalPetugas = User::role('user')->count();
        // atau ganti 'user' dengan nama role yang kamu gunakan untuk petugas

        // Hitung total pengeluaran
        $totalPengeluaran = PengeluaranJimpitan::sum('jumlah');

        return view('modules.admin.adminpanel', [
            'title'            => 'Dashboard',
            'breadcrumbs'      => BreadcrumbHelper::generate([['name' => 'Dashboard']]),
            'totalWarga'       => $totalWarga,
            'totalPenerimaan'  => $totalPenerimaan,
            'totalPetugas'     => $totalPetugas,
            'totalPengeluaran' => $totalPengeluaran,
        ]);
    }
}
