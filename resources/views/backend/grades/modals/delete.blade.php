<!-- Delete Modal (Reusable) -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus grade <strong id="deleteGradeName">nama-grade</strong>?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
        </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const gradeId = button.getAttribute('data-grade-id');
                const gradeName = button.getAttribute('data-grade-name');

                // Update form action
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/grades/${gradeId}`;

                // Update modal content
                document.getElementById('deleteGradeName').textContent = gradeName;
            });
        });
    </script>