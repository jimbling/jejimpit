<?php

namespace App\Services\Jimpitan;

use App\Helpers\BreadcrumbHelper;

class KehadiranService
{
    /**
     * Ambil daftar warga dengan filter
     *
     * @param array $filter
     * @return \Illuminate\Support\Collection
     */


    /**
     * Ambil breadcrumbs
     */
    public function getBreadcrumbs()
    {
        return BreadcrumbHelper::generate([
            ['name' => 'Data Kehadiran Petugas Jimpitan']
        ]);
    }
}
