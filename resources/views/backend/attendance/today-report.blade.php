@extends('layouts.app')

@section('title', 'Laporan Kehadiran Hari Ini')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">📋 Laporan Kehadiran - {{ \Carbon\Carbon::parse($schoolDay->date)->translatedFormat('l, d F Y') }}</h4>

    <div class="tab-content" id="classTabsContent">

        <ul class="nav nav-pills mb-3 flex-nowrap overflow-auto" id="classTabs" role="tablist" style="gap: 0.5rem;">
            @foreach ($classGroups as $classGroup)
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-2 rounded-pill {{ $loop->first ? 'active' : '' }}"
                            id="tab-{{ $classGroup->id }}"
                            data-bs-toggle="tab"
                            data-bs-target="#pane-{{ $classGroup->id }}"
                            type="button"
                            role="tab"
                            aria-controls="pane-{{ $classGroup->id }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        <i class="bx bx-group"></i>
                        {{ $classGroup->grade->name }} - {{ $classGroup->group_number }}
                    </button>
                </li>
            @endforeach
        </ul>

        @foreach ($classGroups as $classGroup)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
            id="pane-{{ $classGroup->id }}"
            role="tabpanel"
            aria-labelledby="tab-{{ $classGroup->id }}">

            <div class="card">
                <div class="card-header">
                    <h5>{{ $classGroup->grade->name }} - {{ $classGroup->group_number }}</h5>
                </div>
                <form method="GET" class="row g-3 mx-3 mb-4">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama / NIS"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="HADIR" @selected(request('status') == 'HADIR')>Hadir</option>
                            <option value="TERLAMBAT" @selected(request('status') == 'TERLAMBAT')>Terlambat</option>
                            <option value="IZIN" @selected(request('status') == 'IZIN')>Izin</option>
                            <option value="SAKIT" @selected(request('status') == 'SAKIT')>Sakit</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="sort_by" class="form-select">
                            <option value="name" @selected(request('sort_by') == 'name')>Urutkan Nama</option>
                            <option value="created_at" @selected(request('sort_by') == 'created_at')>Urutkan Waktu Absen</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="sort_dir" class="form-select">
                            <option value="asc" @selected(request('sort_dir') == 'asc')>Naik ↑</option>
                            <option value="desc" @selected(request('sort_dir') == 'desc')>Turun ↓</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-grid">
                        <button class="btn btn-primary">🔍</button>
                    </div>
                </form>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NIS/NIP</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $hadir = 0;
                                $total = $classGroup->paginatedUsers->count();
                            @endphp
                            @foreach ($classGroup->paginatedUsers as $user)
                            @php
                                $todayAttendance = $user->attendance->first();
                                $status = $todayAttendance->status ?? null;
                                $badgeClass = match ($status) {
                                    'HADIR' => 'bg-success',
                                    'TERLAMBAT' => 'bg-warning text-dark',
                                    'SAKIT' => 'bg-primary',
                                    'IZIN' => 'bg-info text-dark',
                                    'TIDAK HADIR' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                if ($status === 'HADIR') $hadir++;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->national_id }}</td>
                                <td>
                                    <span class="badge {{ $badgeClass }}"
                                        role="button"
                                        title="Klik untuk ubah status"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editStatusModal"
                                        data-id="{{ $todayAttendance->id ?? '' }}"
                                        data-status="{{ $todayAttendance->status ?? '' }}">
                                        {{ $todayAttendance->status ?? 'Belum Absen' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Total Hadir</strong></td>
                                <td><strong>{{ $hadir }} / {{ $total }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $classGroup->paginatedUsers->links() }}
                    </div>
                </div>
            </div>

            {{-- Include Modal for CRUD --}}
            @include('backend.attendance.modals.edit-attendance-status-modal')

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                });
            </script>

        </div>
        @endforeach
    </div>
@endsection
