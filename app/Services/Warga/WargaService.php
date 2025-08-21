<?php

namespace App\Services\Warga;

use App\Helpers\BreadcrumbHelper;
use App\Models\Warga;

class WargaService
{
    /**
     * Ambil daftar warga dengan filter
     *
     * @param array $filter
     * @return \Illuminate\Support\Collection
     */
    public function getFilteredWargas($filter = [])
    {
        $query = Warga::query();

        // Filter berdasarkan kode unik
        if (!empty($filter['kode_unik'])) {
            $query->where('kode_unik', 'like', '%' . $filter['kode_unik'] . '%');
        }

        // Filter berdasarkan nama kepala keluarga
        if (!empty($filter['nama_kk'])) {
            $query->where('nama_kk', 'like', '%' . $filter['nama_kk'] . '%');
        }

        // Filter RT
        if (!empty($filter['rt'])) {
            $query->where('rt', $filter['rt']);
        }

        // Filter RW
        if (!empty($filter['rw'])) {
            $query->where('rw', $filter['rw']);
        }

        // Filter status
        if (!empty($filter['status'])) {
            $query->where('status', $filter['status']);
        }

        // Ambil data
        $wargas = $query->get();

        // Tambahan field bisa ditambahkan di sini
        foreach ($wargas as $warga) {
            $warga->display_name = $warga->nama_kk . ' (' . $warga->kode_unik . ')';
        }

        return $wargas;
    }

    /**
     * Ambil breadcrumbs
     */
    public function getBreadcrumbs()
    {
        return BreadcrumbHelper::generate([
            ['name' => 'Data Warga']
        ]);
    }
}
