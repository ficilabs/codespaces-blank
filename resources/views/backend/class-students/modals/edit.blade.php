<!-- 🎓 Edit Kelas Modal -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="editClassForm">
      @csrf
      @method('PUT')
      <div class="modal-content border-0">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">Ubah Kelas Siswa</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2 fw-semibold" id="editStudentName">Nama Siswa</p>

          <div class="mb-3">
            <label class="form-label">Pilih Kelas</label>
            <select name="class_group_id" class="form-select" id="editClassSelect" required>
              <option value="">-- Pilih Kelas --</option>
              @foreach ($classGroups as $group)
                <option value="{{ $group->id }}">
                  {{ $group->grade->name }} - {{ $group->group_number }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function openEditClassModal(studentId, studentName, currentClassId) {
    document.getElementById('editStudentName').innerText = studentName;

    // Set form action
    const form = document.getElementById('editClassForm');
    form.action = `/class-students/${studentId}`;

    // Set current class selected
    const select = document.getElementById('editClassSelect');
    select.value = currentClassId ?? '';

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editClassModal'));
    modal.show();
  }
</script>

