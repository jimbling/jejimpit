@extends('layouts.tabler')

@section('title', 'BKU Lengkap')
@section('page-title', 'BKU Lengkap')

@section('content')
    <div class="container-fluid space-y-4">

        <!-- Form Generate -->
        <div class="card p-3">
            <form action="{{ route('bku.lengkap.generate') }}" method="POST" class="row align-items-end">
                @csrf
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select" required>
                        @for ($y = 2023; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                            <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                            <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                            <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                            <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>Generate / Regenerate</button>
                </div>
            </form>
        </div>

        <!-- Filter + Hasil -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-filter me-2"></i> Filter Laporan
                </h5>
            </div>
            <div class="card-body border-bottom">
                <!-- Filter Form -->
                <form id="filterForm" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            <option value="">Semua</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            @for ($y = 2023; $y <= date('Y'); $y++)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-report-search">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                                <path d="M18 12v-5a2 2 0 0 0 -2 -2h-2" />
                                <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                <path d="M8 11h4" />
                                <path d="M8 15h3" />
                                <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                                <path d="M18.5 19.5l2.5 2.5" />
                            </svg> Tampilkan
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-body">

                <!-- Tabel hasil -->
                <div id="tableWrapper">
                    @include('modules.jimpitan.bku._table', ['bku' => $bku ?? []])
                </div>
            </div>
        </div>



    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const form = document.getElementById("filterForm");
                const tableWrapper = document.getElementById("tableWrapper");

                function fetchData() {
                    let params = new URLSearchParams(new FormData(form)).toString();
                    fetch("{{ route('bku.lengkap.index') }}?" + params, {
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            tableWrapper.innerHTML = html;
                        })
                        .catch(err => console.error(err));
                }

                // Trigger saat ganti filter
                form.querySelectorAll("select").forEach(el => {
                    el.addEventListener("change", fetchData);
                });
                form.querySelector("input[name=q]").addEventListener("keyup", _.debounce(fetchData, 500));
            });
        </script>
    @endpush

@endsection
