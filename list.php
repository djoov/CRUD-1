<?php
require 'config.php';
$stmt = $pdo->query("SELECT * FROM aset ORDER BY id_aset DESC");
$asets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Manajemen Aset</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><i class="bi bi-box-seam"></i> Daftar Aset</h1>
            <a href="add.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Aset Baru</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Jenis</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($asets)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data aset.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($asets as $aset): ?>
                            <tr>
                                <td><?= htmlspecialchars($aset['kode_asset']) ?></td>
                                <td><?= htmlspecialchars($aset['nama_asset']) ?></td>
                                <td><?= htmlspecialchars($aset['jenis_asset']) ?></td>
                                <td><?= htmlspecialchars($aset['tahun_pengadaan']) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $aset['id_aset'] ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete.php?id=<?= $aset['id_aset'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus aset ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>