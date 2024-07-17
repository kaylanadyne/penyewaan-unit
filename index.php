<?php
$unitFile = 'data/unit.json';
$units = json_decode(file_get_contents($unitFile), true);
$dataFile = 'data/data.json';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><strong>
                <img src="img/logo.png" alt="" width="50" height="50" class="img-circle mx-2">Pemesanan Sewa Properti</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Form input sewa -->
    <div class="container px-5">
        <form id="contactForm" action="proses.php" method="post">
            <div class="form-floating mb-3">
                <input class="form-control" name="nama" id="nama" type="text" placeholder="Nama" required />
                <label for="nama">Nama</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="nomorTelp" name="nomorTelp" type="text" placeholder="Nomor Telp" required />
                <label for="nomorTelp">Nomor Telp</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="unitYangAkanDisewa" name="unitYangAkanDisewa" required>
                    <option value="">Pilih Unit</option>
                    <?php foreach ($units as $unit) : ?>
                        <option value="<?= $unit['unit'] ?>" data-rate="<?= $unit['harga'] ?>"><?= $unit['unit'] ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="unitYangAkanDisewa">Unit yang akan disewa</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="durasi" name="durasi" type="number" placeholder="Jumlah Unit" required />
                <label for="durasi">Durasi peminjaman (Dalam hari)</label>
            </div>
            <div class="d-grid mb-3">
                <button class="btn btn-success" id="hitungButton" type="button">Hitung Total Biaya</button>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="totalBiaya" name="totalBiaya" type="text" placeholder="Total Biaya" readonly />
                <label for="totalBiaya">Total Biaya</label>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
            </div>
        </form>
        <div class="container my-5">
        <h2>Data Pemesanan Sewa Properti</h2>
        <div class="container mb-5">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Nomor</th>
                            <th scope="col">Unit yang disewa</th>
                            <th scope="col">Durasi</th>
                            <th scope="col">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Pastikan file data.json ada dan dapat dibaca
                        if (file_exists($dataFile)) {
                            // Membaca file JSON yang berisi informasi data penerbangan dan mengubahnya menjadi array PHP menggunakan json_decode
                            $datas = json_decode(file_get_contents($dataFile), true);
                            if ($datas) {
                                foreach ($datas as $data) {
                                    echo '<tr>';
                                    echo '<td>' . $data['nama'] . '</td>';
                                    echo '<td>' . $data['nomorTelp'] . '</td>';
                                    echo '<td>' . $data['unitYangAkanDisewa'] . '</td>';
                                    echo '<td>' . $data['durasi'] ." ". "hari". '</td>';
                                    echo '<td>' . $data['totalHarga'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">Tidak ada data rute penerbangan.</td></tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">File data.json tidak ditemukan.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('hitungButton').addEventListener('click', function() {
            const unitSelect = document.getElementById('unitYangAkanDisewa');
            const selectedUnit = unitSelect.options[unitSelect.selectedIndex];
            const rate = selectedUnit.getAttribute('data-rate');
            const durasi = document.getElementById('durasi').value;

            if (rate && durasi) {
                const totalBiaya = rate * durasi;
                document.getElementById('totalBiaya').value = totalBiaya;
            } else {
                alert('Silakan pilih unit dan masukkan jumlah unit yang valid.');
            }
        });
    </script>
  </body>
</html>
