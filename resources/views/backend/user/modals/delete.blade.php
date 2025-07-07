<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <form method="POST" id="deleteUserForm">
        @csrf
        @method('DELETE')

        <div class="modal-header">
        <h5 class="modal-title">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
        <span id="deleteUserMessage">Are you sure you want to delete this user?</span>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
    </form>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle delete User Modal
        const deleteModal = document.getElementById('confirmDeleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');

            // Set the form action to the user's delete route
            document.getElementById('deleteUserForm').action = `/users/${userId}`;

            // Optionally show the user's name in the confirmation message
            const message = userName ? `Are you sure you want to delete <strong>${userName}</strong>?` : 'Are you sure you want to delete this user?';
            document.getElementById('deleteUserMessage').innerHTML = message;
        });
    });
</script>