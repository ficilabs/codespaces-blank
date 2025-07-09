<!-- Edit User Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <form method="POST" id="editForm">
    @csrf
    @method('PUT')
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
        <div class="mb-3">
            <label for="editNationalId" class="form-label">NIM atau NISN</label>
            <input type="text" class="form-control" id="editNationalId" name="national_id" required>
        </div>
        <div class="mb-3">
            <label for="editName" class="form-label">Name</label>
            <input type="text" class="form-control" id="editName" name="name" required>
        </div>
        <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning">Save Changes</button>
        </div>
    </div>
    </form>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle edit User Modal
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            // Populate form fields with user data
            document.getElementById('editName').value = button.getAttribute('data-user-name');
            document.getElementById('editEmail').value = button.getAttribute('data-user-email');
            document.getElementById('editNationalId').value = button.getAttribute('data-user-national-id');

            // Set the form action to the user's update route
            const userId = button.getAttribute('data-user-id');
            document.getElementById('editForm').action = `/users/${userId}`;
        });
    });
</script>