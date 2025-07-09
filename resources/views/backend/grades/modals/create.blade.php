<!-- Create Grade Modal -->
<div class="modal fade" id="createGradeModal" tabindex="-1" aria-labelledby="createGradeModalLabel">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('grades.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createGradeModalLabel">Tambah Grade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="gradeName" class="form-label">Nama Grade</label>
            <input type="text" class="form-control" id="gradeName" name="name" placeholder="Contoh: X" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

