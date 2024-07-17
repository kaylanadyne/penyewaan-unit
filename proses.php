<?php
// menampilkan data unit
$unitFile = 'data/unit.json';
$units = json_decode(file_get_contents($unitFile), true);

$dataFile = 'data/data.json';
$routes = [];

// mengisi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nomorTelp = $_POST['nomorTelp'];
    $unitYangAkanDisewa = $_POST['unitYangAkanDisewa'];
    $durasi = $_POST['durasi'];

    // Mendapatkan harga unit yang dipilih
    $hargaUnit = getHarga($units, $unitYangAkanDisewa);
    $totalHarga = $hargaUnit * $durasi;

    // Membuat array $newRoute untuk menyimpan data baru sewa properti yang akan disimpan ke file data.json
    $newRoute = [
        'nama' => $nama,
        'nomorTelp' => $nomorTelp,
        'unitYangAkanDisewa' => $unitYangAkanDisewa,
        'durasi' => $durasi,
        'totalHarga' => $totalHarga
    ];

    // Simpan data ke file data.json
    $routes = json_decode(file_get_contents($dataFile), true);
    $routes[] = $newRoute;

    file_put_contents($dataFile, json_encode($routes, JSON_PRETTY_PRINT));
}

// Fungsi untuk mendapatkan harga unit
function getHarga($data, $unit)
{
    foreach ($data as $unit_info) {
        if ($unit_info['unit'] === $unit) {
            return $unit_info['harga']; // Mengembalikan nilai harga jika unit cocok
        }
    }
    return 0; // Mengembalikan nilai 0 jika tidak ditemukan data harga untuk unit yang dimaksud
}
?>
