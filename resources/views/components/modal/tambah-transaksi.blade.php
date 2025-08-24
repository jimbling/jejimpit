<!-- Modal Tambah Transaksi Jimpitan -->
<div class="modal fade" id="tambahTransaksiModal" tabindex="-1" aria-labelledby="tambahTransaksiModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">
            <div class="modal-header custom-header">
                <h5 class="modal-title" id="tambahTransaksiModalLabel">Tambah Transaksi Jimpitan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Transaksi -->
                <form id="form-transaksi" action="{{ route('transaksi.jimpitan.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row g-3">
                        <!-- Pilih Warga -->
                        <div class="col-md-6">
                            <label for="warga_id" class="form-label">Pilih Warga</label>
                            <select class="form-select" id="warga_id" name="warga_id" required>
                                <option value="" selected disabled>-- Pilih Warga --</option>
                                @foreach ($wargas as $warga)
                                    <option value="{{ $warga->id }}">
                                        {{ $warga->nama_kk }} ({{ $warga->kode_unik }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Petugas -->
                        <div class="col-md-6">
                            <label for="user_id" class="form-label">Petugas</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="" selected disabled>-- Pilih Petugas --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Tanggal Transaksi -->
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Jumlah Transaksi -->
                        <div class="col-md-6">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="10000"
                                required>
                        </div>

                        <!-- Keterangan / Catatan -->
                        <div class="col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Opsional"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
