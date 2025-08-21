<!-- Modal Tambah Warga -->
<div class="modal fade" id="tambahWargaModal" tabindex="-1" aria-labelledby="tambahWargaModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">
            <div class="modal-header custom-header">
                <h5 class="modal-title" id="tambahWargaModalLabel">Tambah Data Warga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Warga -->
                <form id="form-warga" action="{{ route('induk.warga.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="kode_unik" class="form-label">Kode Unik</label>
                            <input type="text" class="form-control" id="kode_unik" name="kode_unik"
                                placeholder="KDTCUV" disabled>
                            <small class="text-muted">Kode Unik akan dibuat otomatis setelah data warga
                                disimpan.</small>
                        </div>

                        <div class="col-md-4">
                            <label for="nama_kk" class="form-label">Nama Kepala Keluarga</label>
                            <input type="text" class="form-control" id="nama_kk" name="nama_kk"
                                placeholder="Nama KK" required>
                        </div>

                        <div class="col-md-4">
                            <label for="no_telp" class="form-label">No. Telp</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp"
                                placeholder="0812xxxx">
                        </div>

                        <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="Jl. Contoh No. 1" required>
                        </div>

                        <div class="col-md-2">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" placeholder="01"
                                required>
                        </div>

                        <div class="col-md-2">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" placeholder="02"
                                required>
                        </div>

                        <div class="col-md-2">
                            <label for="no_rumah" class="form-label">No. Rumah</label>
                            <input type="text" class="form-control" id="no_rumah" name="no_rumah" placeholder="12"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Warga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
