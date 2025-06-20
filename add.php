<?php
require 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_asset = trim($_POST['kode_asset']);
    $nama_asset = trim($_POST['nama_asset']);
    $jenis_asset = trim($_POST['jenis_asset']);
    $deskripsi_asset = trim($_POST['deskripsi_asset']);
    $tahun_pengadaan = trim($_POST['tahun_pengadaan']);

    if (empty($kode_asset) || empty($nama_asset)) {
        $error = 'Kode Aset dan Nama Aset wajib diisi.';
    } else {
        try {
            $sql = "INSERT INTO aset (kode_asset, nama_asset, jenis_asset, deskripsi_asset, tahun_pengadaan) VALUES (:kode, :nama, :jenis, :deskripsi, :tahun)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':kode' => $kode_asset,
                ':nama' => $nama_asset,
                ':jenis' => $jenis_asset,
                ':deskripsi' => $deskripsi_asset,
                ':tahun' => $tahun_pengadaan
            ]);
            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            // Cek jika error karena duplikat kode aset
            if ($e->getCode() == '23505') {
                 $error = 'Kode Aset sudah ada, silakan gunakan kode lain.';
            } else {
                 $error = 'Gagal menyimpan data: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <h1>Tambah Aset Baru</h1>
        <hr>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="kode_asset" class="form-label">Kode Aset</label>
                <input type="text" class="form-control" id="kode_asset" name="kode_asset" required>
            </div>
            <div class="mb-3">
                <label for="nama_asset" class="form-label">Nama Aset</label>
                <input type="text" class="form-control" id="nama_asset" name="nama_asset" required>
            </div>
            <div class="mb-3">
                <label for="jenis_asset" class="form-label">Jenis Aset</label>
                <input type="text" class="form-control" id="jenis_asset" name="jenis_asset">
            </div>
            <div class="mb-3">
                <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                <input type="text" class="form-control" id="tahun_pengadaan" name="tahun_pengadaan" maxlength="4">
            </div>
            <div class="mb-3">
                <label for="deskripsi_asset" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi_asset" name="deskripsi_asset" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>