@extends('layouts.tabler')

@section('title', $title ?? 'Pemeliharaan Sistem')
@section('page-title', 'Pemeliharaan Sistem')

@section('content')
    <div class="container-xl">
        <div class="row row-cards">
            <!-- Card Backup -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Backup Database & File</h3>
                        <button id="btnBackup" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-database-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
                                <path d="M4 6v6c0 1.657 3.582 3 8 3c1.075 0 2.1 -.08 3.037 -.224" />
                                <path d="M20 12v-6" />
                                <path d="M4 12v6c0 1.657 3.582 3 8 3c.166 0 .331 -.002 .495 -.006" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                            </svg> Cadangkan Sekarang
                        </button>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Proses ini akan membuat backup seluruh file penting dan database (tanpa vendor & node_modules).
                        </p>

                        <!-- Progress Box -->
                        <div id="progressBox" class="border p-3 rounded bg-light d-none"
                            style="max-height: 250px; overflow:auto; font-family: monospace;">
                            <!-- Progress akan muncul di sini -->
                        </div>
                    </div>
                </div>
            </div>


            <!-- Card Daftar Backup -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Backup</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th>Ukuran</th>
                                    <th>Tanggal</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $backup)
                                    <tr>
                                        <td>{{ $backup['file_name'] }}</td>
                                        <td>{{ number_format($backup['file_size'] / 1024 / 1024, 2) }} MB</td>
                                        <td>{{ $backup['last_modified']->isoFormat('D MMMM YYYY HH.mm') }} WIB</td>


                                        <td>
                                            <div class="btn-list">
                                                <a href="{{ route('pengaturan.pemeliharaan.download', basename($backup['path'])) }}"
                                                    class="btn btn-sm btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                        <path d="M7 11l5 5l5 -5" />
                                                        <path d="M12 4l0 12" />
                                                    </svg> Unduh
                                                </a>

                                                <button class="btn btn-sm btn-danger btn-hapus-backup"
                                                    data-url="{{ route('pengaturan.pemeliharaan.delete', urlencode($backup['file_name'])) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg> Hapus
                                                </button>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada backup tersimpan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Backup?"
        body="Backup yang dipilih akan dihapus permanen. Tindakan ini tidak bisa dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" {{-- kosongkan, nanti diisi JS --}} method="DELETE" />


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // === Tombol Backup & Progress ===
                const btnBackup = document.getElementById('btnBackup');
                const originalText = btnBackup.innerHTML;
                const progressBox = document.getElementById('progressBox');

                btnBackup.addEventListener('click', function() {
                    progressBox.classList.remove('d-none');
                    progressBox.innerHTML = "Memulai backup...\n";

                    // Disable tombol & ganti teks
                    btnBackup.disabled = true;
                    btnBackup.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Sedang Proses Pencadangan
        `;

                    fetch("{{ route('pengaturan.pemeliharaan.startBackup') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        pollProgress();
                    });
                });

                function pollProgress() {
                    fetch("{{ route('pengaturan.pemeliharaan.getBackupProgress') }}")
                        .then(res => res.json())
                        .then(data => {
                            progressBox.innerHTML = data.progress;
                            progressBox.scrollTop = progressBox.scrollHeight; // auto scroll ke bawah

                            if (data.progress.includes('Backup selesai!') || data.progress.includes(
                                    'Backup selesai')) {
                                // Backup selesai
                                setTimeout(() => {
                                    // Enable tombol & kembalikan teks asli
                                    btnBackup.disabled = false;
                                    btnBackup.innerHTML = originalText;

                                    location.reload(); // reload halaman agar daftar backup terbaru muncul
                                }, 1000);
                            } else {
                                setTimeout(pollProgress, 1000); // update setiap 1 detik
                            }
                        });
                }

                // === Modal Konfirmasi Hapus Backup ===
                document.querySelectorAll('.btn-hapus-backup').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.url; // URL delete file (encoded)

                        const form = document.querySelector('#modalKonfirmasiHapus form');
                        form.action = url;

                        // Tampilkan modal
                        const konfirmasiModal = new bootstrap.Modal(document.getElementById(
                            'modalKonfirmasiHapus'));
                        konfirmasiModal.show();
                    });
                });

            });
        </script>
    @endpush


@endsection
