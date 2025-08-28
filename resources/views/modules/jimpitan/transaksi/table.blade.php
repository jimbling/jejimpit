<table class="table table-vcenter table-selectable">
    <thead>
        <tr>

            <th>Tanggal</th>
            <th>Warga</th>
            <th>Jumlah</th>
            <th>Petugas</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transaksi as $t)
            <tr>

                <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                <td>{{ $t->warga->nama_kk }} ({{ $t->warga->kode_unik }})</td>
                <td>{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                <td>{{ $t->user->name }}</td>
                <td class="text-end">
                    {{-- Tombol Kirim Ulang WA --}}
                    <a href="{{ route('transaksi.resendWa', $t->id) }}" class="btn btn-outline-success btn-icon"
                        target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21l1.65 -4.7a9 9 0 1 1 3.35 3.35l-4.7 1.65" />
                            <path d="M9 10a.5 .5 0 0 0 1 0v0a2 2 0 0 1 4 0c0 1 -1 3 -3 3" />
                        </svg>
                    </a>

                    {{-- Tombol Hapus --}}
                    <button type="button" class="btn btn-outline-danger btn-icon btn-hapus-transaksi"
                        data-url="{{ route('transaksi.jimpitan.destroy', $t->id) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="4" y1="7" x2="20" y2="7" />
                            <line x1="10" y1="11" x2="10" y2="17" />
                            <line x1="14" y1="11" x2="14" y2="17" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3h6v3" />
                        </svg>
                    </button>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
</table>
