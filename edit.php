<?php
require 'config.php';
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_asset = trim($_POST['kode_asset']);
    $nama_asset = trim($_POST['nama_asset']);
    $jenis_asset = trim($_POST['jenis_asset']);
    $deskripsi_asset = trim($_POST['deskripsi_asset']);
    $tahun_pengadaan = trim($_POST['tahun_pengadaan']);

    $sql = "UPDATE aset SET kode_asset=:kode, nama_asset=:nama, jenis_asset=:jenis, deskripsi_asset=:deskripsi, tahun_pengadaan=:tahun WHERE id_aset=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':kode' => $kode_asset,
        ':nama' => $nama_asset,
        ':jenis' => $jenis_asset,
        ':deskripsi' => $deskripsi_asset,
        ':tahun' => $tahun_pengadaan,
        ':id' => $id
    ]);
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM aset WHERE id_aset = :id");
$stmt->execute(['id' => $id]);
$aset = $stmt->fetch();
if (!$aset) {
    header('Location: list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <h1>Edit Aset</h1>
        <hr>
        <form method="post">
            <div class="mb-3">
                <label for="kode_asset" class="form-label">Kode Aset</label>
                <input type="text" class="form-control" id="kode_asset" name="kode_asset" value="<?= htmlspecialchars($aset['kode_asset']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_asset" class="form-label">Nama Aset</label>
                <input type="text" class="form-control" id="nama_asset" name="nama_asset" value="<?= htmlspecialchars($aset['nama_asset']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_asset" class="form-label">Jenis Aset</label>
                <input type="text" class="form-control" id="jenis_asset" name="jenis_asset" value="<?= htmlspecialchars($aset['jenis_asset']) ?>">
            </div>
            <div class="mb-3">
                <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                <input type="text" class="form-control" id="tahun_pengadaan" name="tahun_pengadaan" maxlength="4" value="<?= htmlspecialchars($aset['tahun_pengadaan']) ?>">
            </div>
            <div class="mb-3">
                <label for="deskripsi_asset" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi_asset" name="deskripsi_asset" rows="3"><?= htmlspecialchars($aset['deskripsi_asset']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>