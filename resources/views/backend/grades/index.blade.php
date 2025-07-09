@extends('layouts.app')

@section('title', 'Daftar Tingkatan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">📘 Data Grade (Tingkatan)</h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List Grade</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGradeModal">+ Tambah Grade</button>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Grade</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($grades as $grade)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $grade->name }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button"
                                        class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editGradeModal"
                                        data-grade-id="{{ $grade->id }}"
                                        data-grade-name="{{ $grade->name }}">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-grade-id="{{ $grade->id }}"
                                        data-grade-name="{{ $grade->name }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Include Modal for CRUD --}}
    @include('backend.grades.modals.create')
    @include('backend.grades.modals.edit')
    @include('backend.grades.modals.delete')

</div>
@endsection
