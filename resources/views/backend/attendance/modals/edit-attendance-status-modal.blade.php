<!-- Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editStatusForm" action="{{ route('attendance.update', ':id') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Edit Status Kehadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="attendance_id" id="editAttendanceId">
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select name="status" id="editStatus" class="form-select" required>
                            <option value="HADIR">Hadir</option>
                            <option value="TERLAMBAT">Terlambat</option>
                            <option value="IZIN">Izin</option>
                            <option value="SAKIT">Sakit</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editStatusModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const status = button.getAttribute('data-status');

        document.getElementById('editAttendanceId').value = id;
        document.getElementById('editStatus').value = status;
        document.getElementById('editStatusForm').action = `/attendance/${id}`;
    });
});
</script>
