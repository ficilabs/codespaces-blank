@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📌 Log Kehadiran Hari Ini - {{ \Carbon\Carbon::parse($schoolDay->date)->translatedFormat('l, d F Y') }}</h5>
            </div>
            <div class="row mb-4 px-3">
                <!-- ✅ Hadir -->
                <div class="col-md-3 mt-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #28a745, #218838);">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-user-check fs-1"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Hadir</h6>
                                <h3 class="fw-bold mb-0">{{ $totalHadir }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🟠 Terlambat -->
                <div class="col-md-3 mt-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #fd7e14, #e67e22);">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-time fs-1"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Terlambat</h6>
                                <h3 class="fw-bold mb-0">{{ $totalTerlambat }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🟡 Izin -->
                <div class="col-md-3 mt-3">
                    <div class="card text-dark" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-user-minus fs-1"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Izin</h6>
                                <h3 class="fw-bold mb-0">{{ $totalIzin }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🔵 Sakit -->
                <div class="col-md-3 mt-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-first-aid fs-1"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Sakit</h6>
                                <h3 class="fw-bold mb-0">{{ $totalSakit }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ❌ Tidak Masuk/belum absent -->
                <div class="col-md-3 mt-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-user-x fs-1"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Belum absent</h6>
                                <h3 class="fw-bold mb-0">{{ $totalTidakMasuk }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Siswa -->
                <div class="col-md-3 mt-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #6c757d, #5a6268);">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-user fs-1"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Siswa</h6>
                                <h3 class="fw-bold mb-0">{{ $totalStudents }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="GET" class="row g-3 mb-3 mx-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Cari Nama / NIS</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Filter Kelas</label>
                    <select name="class_group_id" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach ($classGroups as $group)
                            <option value="{{ $group->id }}" @selected(request('class_group_id') == $group->id)>
                                {{ $group->grade->name }} - {{ $group->group_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="HADIR" @selected(request('status') == 'HADIR')>Hadir</option>
                        <option value="TERLAMBAT" @selected(request('status') == 'TERLAMBAT')>Terlambat</option>
                        <option value="IZIN" @selected(request('status') == 'IZIN')>Izin</option>
                        <option value="SAKIT" @selected(request('status') == 'SAKIT')>Sakit</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Urut Berdasarkan</label>
                    <select name="sort_by" class="form-select">
                        <option value="created_at" @selected(request('sort_by') == 'created_at')>Waktu</option>
                        <option value="user_id" @selected(request('sort_by') == 'user_id')>Nama</option>
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit">🔍 Filter</button>
                </div>
            </form>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIS/NIP</th>
                            <th>Kelas</th>
                            <th>Waktu Absen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendanceLogs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->user->name }}</td>
                            <td>{{ $log->user->national_id }}</td>
                            <td>
                                {{ $log->user->classGroup->grade->name ?? '-' }}
                                {{ $log->user->classGroup->group_number ?? '' }}
                            </td>
                            <td>{{ $log->created_at->format('H:i:s') }}</td>
                            <td>
                                @if ($log->status === 'HADIR')
                                    <span class="badge bg-success">Hadir</span>
                                @else
                                    <span class="badge bg-danger">{{ $log->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada absensi hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $attendanceLogs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
