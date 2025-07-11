@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">👨‍🎓 Manajemen Siswa per Kelas</h4>

    {{-- 🔍 Search & Filter --}}
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
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

        <div class="col-md-4">
            <label class="form-label">Cari Nama / NIS</label>
            <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button class="btn btn-primary" type="submit"><i class="bx bx-search"></i> Cari</button>
        </div>
    </form>

    {{-- 📋 Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIS/NIP</th>
                        <th>Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->national_id }}</td>
                            <td>
                                @if ($student->classGroup)
                                    {{ $student->classGroup->grade->name }} - {{ $student->classGroup->group_number }}
                                @else
                                    <span class="badge bg-warning">Belum diatur</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- 📷 QR Code Button --}}
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#qrCardModal"
                                    data-name="{{ $student->name }}"
                                    data-nis="{{ $student->national_id }}"
                                    data-kelas="{{ $student->classGroup?->grade->name }} - {{ $student->classGroup?->group_number }}">
                                    <i class="bx bx-qr"></i> QR
                                </button>
                                {{-- ✏️ Trigger Edit Modal --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-warning me-1"
                                    onclick="openEditClassModal(
                                        '{{ $student->id }}',
                                        '{{ addslashes($student->name) }}',
                                        '{{ $student->class_group_id ?? '' }}'
                                    )"
                                    title="Ubah Kelas">
                                    <i class="bx bx-pencil">edit</i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tidak ada siswa ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 🔁 Pagination --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>

    </div>

    {{-- Include Modal for CRUD --}}
    @include('backend.class-students.modals.qr-card')
    @include('backend.class-students.modals.edit')

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection
