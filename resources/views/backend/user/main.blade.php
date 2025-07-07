@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Users</h5>
            <div class="d-md-flex justify-content-between align-items-center pb-2">

                <!-- 🔍 Filter Form (auto-submit) -->
                <form method="GET" action="{{ route('users.index') }}" id="filterForm" class="row g-2 align-items-center flex-grow-1 me-3">
                    <div class="col-auto">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search name or email" id="searchInput">
                    </div>

                    <div class="col-auto">
                        <select name="role" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
                            <option value="">All Roles</option>
                            @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No need for search button anymore -->
                </form>

                <!-- ➕ Add User Button -->
                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons">
                        <button class="btn btn-primary add-new btn-sm" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            <span><i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline">Add User</span></span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-datatable table-responsive">
            <table class="table user-table table-bordered">
            <thead class="table-light text-center">
                <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                <td>
                    <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                        <img src="https://i.pravatar.cc/150?img={{ rand(1,70) }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <div class="fw-medium text-body">{{ $user->name }}</div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td class="text-center">{{ $user->getRoleNames()->first() ?? 'No Role' }}</td>
                <td>
                @php
                    $isOnline = $user->last_seen_at && \Carbon\Carbon::parse($user->last_seen_at)->gt(now()->subMinutes(5));
                @endphp

                <span class="badge {{ $isOnline ? 'bg-label-success' : 'bg-label-secondary' }}">
                    {{ $isOnline ? 'Online' : 'Offline' }}
                </span>
                </td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td class="d-flex justify-content-center gap-2">
                    <!-- View Button -->
                    <button class="btn btn-sm btn-info"
                        data-bs-toggle="modal"
                        data-bs-target="#viewModal"
                        data-user-name="{{ $user->name }}"
                        data-user-email="{{ $user->email }}"
                        data-user-role="{{ $user->roles->first()?->name ?? 'N/A' }}"
                        data-user-avatar="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://i.pravatar.cc/150?img=' . rand(1, 70) }}"
                        data-user-online="{{ Cache::has('user-is-online-' . $user->id) ? '1' : '0' }}">
                        <i class="bx bx-show"></i>
                    </button>
                    <!-- Edit -->
                    <button class="btn btn-sm btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal"
                    data-user-id="{{ $user->id }}"
                    data-user-name="{{ $user->name }}"
                    data-user-email="{{ $user->email }}">
                    <i class="bx bx-edit"></i>
                    </button>
                    <!-- Delete -->
                    <button type="button"
                    class="btn btn-sm btn-icon btn-danger"
                    title="Delete"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal"
                    data-user-id="{{ $user->id }}"
                    data-user-name="{{ $user->name }}">
                    <i class="bx bx-trash"></i>
                </button>
                </td>
                </tr>
            @endforeach
            </tbody>
            </table>
            <div class="mt-3 px-3">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
            
        </div>
        </div>

        {{-- Include Modal for CRUD --}}
        @include('backend.user.modals.create')
        @include('backend.user.modals.view')
        @include('backend.user.modals.edit')
        @include('backend.user.modals.delete')

    </div>
@endsection

@push('scripts')
<script>
    let timer;
    const input = document.getElementById('searchInput');

    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500); // Delay submit until user stops typing for 0.5 sec
    });
    
</script>
@endpush
