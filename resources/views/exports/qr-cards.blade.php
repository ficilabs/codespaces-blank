<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      font-size: 12px;
    }
    .card {
      border: 1px solid #ccc;
      padding: 10px;
      width: 180px;
      margin: 0 auto;
    }
    .qr {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="card">
    <img src="data:image/png;base64,{{ $card['logo_base64'] }}" width="50">
    <p><strong>{{ $card['nama'] }}</strong></p>
    <p>{{ $card['kelas'] }}</p>
    <p>NIS: {{ $card['nis'] }}</p>
    <div class="qr">
      <img src="data:image/png;base64,{{ $card['qr_base64'] }}" width="100">
    </div>
  </div>
</body>
</html>