<!-- Student QR Modal -->
<div class="modal fade" id="qrCardModal" tabindex="-1" aria-labelledby="qrCardModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="qrCardModalLabel">Kartu QR Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- Card for printing -->
        <div id="pdf-wrapper" class="pdf-a4-hidden" style="width: 210mm; height: 297mm; display: flex; align-items: center; justify-content: center; background: #fff;">
        <div id="qr-card-print" class="border rounded bg-white d-flex flex-column align-items-center justify-content-center" style="height: 85.60mm; width: 53.98mm; text-align: center; box-shadow: 0 0 4mm #ccc;">
          <div class="mb-2">
            <img id="logo-img" src="{{ asset('assets/img/logo/logo.jpg') }}" width="40" alt="Logo Sekolah" style="display: block; margin: 0 auto;">
          </div>
          <div class="fw-bold" id="qr-name" style="font-size: 13px;">Nama</div>
          <div class="text-muted" id="qr-kelas" style="font-size: 11px;">Kelas</div>
          <div class="text-muted" id="qr-nis" style="font-size: 11px;">NIS</div>
          <div class="mt-2">
            <img id="qr-image" src="" width="90" height="90" alt="QR Code" style="display: block; margin: 0 auto;">
          </div>
        </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button id="btn-download-pdf" class="btn btn-outline-primary">
          <i class="bx bx-download"></i> Download PDF
        </button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Utility to convert image URL to base64
    function toDataURL(url, callback) {
        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            const reader = new FileReader();
            reader.onloadend = function () {
                callback(reader.result);
            };
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }

    const qrModal = document.getElementById('qrCardModal');

    qrModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Extract student data from button
        const name = button.getAttribute('data-name');
        const nis = button.getAttribute('data-nis');
        const kelas = button.getAttribute('data-kelas');
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${nis}&size=100x100`;
        const logoUrl = "{{ asset('assets/img/logo/logo.jpg') }}";

        // Fill modal fields
        document.getElementById('qr-name').textContent = name;
        document.getElementById('qr-nis').textContent = "NIS: " + nis;
        document.getElementById('qr-kelas').textContent = kelas;

        // Convert logo and QR to base64 before setting them
        toDataURL(logoUrl, function (logoBase64) {
            document.getElementById('logo-img').src = logoBase64;

            toDataURL(qrUrl, function (qrBase64) {
                document.getElementById('qr-image').src = qrBase64;
            });
        });
    });

    // Handle PDF download
    document.getElementById('btn-download-pdf').addEventListener('click', function () {
        const element = document.getElementById('pdf-wrapper'); // Use the wrapper for A4 centering
        html2pdf()
            .set({
                margin: 0,
                filename: 'kartu-id-cr80.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: {
                    scale: 3, // High-res for print
                    useCORS: true,
                    scrollX: 0,
                    scrollY: 0,
                    backgroundColor: '#fff'
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4', // A4 page
                    orientation: 'portrait'
                }
            })
            .from(element)
            .save();
    });
</script>
