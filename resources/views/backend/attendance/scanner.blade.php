@extends('layouts.app')

@section('title', 'Scanner Kehadiran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">📷 Scanner Absensi</h4>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @elseif(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show">{{ session('warning') }}</div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('attendance.scan') }}">
                @csrf
                <div class="mb-3">
                    <label for="national_id" class="form-label">Scan / Input NIS/NIP</label>
                    <input type="text" class="form-control" id="national_id" name="national_id" required autofocus>
                </div>
                <button class="btn btn-primary">Absen Sekarang</button>
            </form>
        </div>
    </div>
</div>
@endsection
