<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" id="editGradeForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editGradeName" class="form-label">Nama Grade</label>
            <input type="text" class="form-control" id="editGradeName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Listen for the edit button click
    document.querySelectorAll('[data-bs-target="#editGradeModal"]').forEach(button => {
      button.addEventListener('click', function () {
        const gradeId = this.getAttribute('data-grade-id');
        const gradeName = this.getAttribute('data-grade-name');

        // Set the form action to the correct route
        const form = document.getElementById('editGradeForm');
        form.action = `/grades/${gradeId}`;

        // Set the input value
        document.getElementById('editGradeName').value = gradeName;
      });
    });
  });
</script>