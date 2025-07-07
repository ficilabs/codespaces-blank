<!-- View User Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    
    <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body text-center">

        <!-- Avatar + Online status -->
        <div class="avatar avatar-xl position-relative mx-auto mb-3">
            <img id="viewUserAvatar" src="" alt="Avatar" class="rounded-circle w-px-100 h-px-100">
            <span id="viewUserStatus" class="avatar-status bg-secondary"></span>
        </div>

        <!-- User Info -->
        <h5 id="viewUserName" class="mb-0"></h5>
        <small id="viewUserRole" class="text-muted d-block mb-2"></small>
        <p class="mb-0"><strong>Email:</strong> <span id="viewUserEmail"></span></p>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>

    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle view User Modal
        const viewModal = document.getElementById('viewModal');
        viewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            document.getElementById('viewUserName').textContent = button.getAttribute('data-user-name');
            document.getElementById('viewUserEmail').textContent = button.getAttribute('data-user-email');
            document.getElementById('viewUserRole').textContent = button.getAttribute('data-user-role');
            document.getElementById('viewUserAvatar').src = button.getAttribute('data-user-avatar');

            const online = button.getAttribute('data-user-online') === '1';
            const statusIndicator = document.getElementById('viewUserStatus');

            statusIndicator.classList.remove('bg-secondary', 'bg-success');
            statusIndicator.classList.add(online ? 'bg-success' : 'bg-secondary');
        });
    });
</script>