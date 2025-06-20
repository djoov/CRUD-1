<?php
header('Content-Type: application/json; charset=utf-8');
require 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';
$path_parts = explode('/', trim($path, '/'));

// Endpoint: /api.php/aset/{id?}
if (empty($path_parts[0]) || $path_parts[0] !== 'aset') {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint tidak ditemukan. Gunakan /aset']);
    exit;
}

$id = $path_parts[1] ?? null;

switch ($method) {
    case 'GET':
        if ($id) getAset($id);
        else listAset();
        break;
    case 'POST':
        createAset();
        break;
    case 'PUT':
    case 'PATCH': // Seringkali PATCH digunakan untuk update parsial
        if ($id) updateAset($id);
        else errorBadRequest('ID Aset diperlukan untuk update.');
        break;
    case 'DELETE':
        if ($id) deleteAset($id);
        else errorBadRequest('ID Aset diperlukan untuk delete.');
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method tidak diizinkan.']);
}

function listAset() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM aset ORDER BY id_aset');
    echo json_encode($stmt->fetchAll());
}

function getAset($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM aset WHERE id_aset = :id');
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch();
    if ($data) {
        echo json_encode($data);
    } else {
        errorNotFound('Aset tidak ditemukan.');
    }
}

function createAset() {
    global $pdo;
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input['kode_asset']) || empty($input['nama_asset'])) {
        errorBadRequest('Kode dan Nama Aset wajib diisi.');
    }
    $sql = 'INSERT INTO aset (kode_asset, nama_asset, jenis_asset, deskripsi_asset, tahun_pengadaan)
            VALUES (:kode, :nama, :jenis, :deskripsi, :tahun) RETURNING id_aset';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':kode' => $input['kode_asset'],
        ':nama' => $input['nama_asset'],
        ':jenis' => $input['jenis_asset'] ?? null,
        ':deskripsi' => $input['deskripsi_asset'] ?? null,
        ':tahun' => $input['tahun_pengadaan'] ?? null,
    ]);
    $newId = $stmt->fetchColumn();
    http_response_code(201);
    echo json_encode(['message'=>'Aset berhasil dibuat', 'id_aset' => $newId]);
}

function updateAset($id) {
    global $pdo;
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input)) errorBadRequest('Tidak ada data untuk diupdate.');

    $fields = [];
    foreach ($input as $key => $value) {
        // Pastikan hanya kolom yang valid yang diupdate
        if (in_array($key, ['kode_asset', 'nama_asset', 'jenis_asset', 'deskripsi_asset', 'tahun_pengadaan'])) {
            $fields[] = "{$key} = :{$key}";
        }
    }
    if (empty($fields)) errorBadRequest('Tidak ada field valid untuk diupdate.');

    $sql = 'UPDATE aset SET '.implode(', ', $fields).' WHERE id_aset = :id';
    $input['id'] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($input);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message'=>'Aset berhasil diperbarui.']);
    } else {
        errorNotFound('Aset tidak ditemukan atau data tidak berubah.');
    }
}

function deleteAset($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM aset WHERE id_aset = :id');
    $stmt->execute(['id'=>$id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message'=>'Aset berhasil dihapus.']);
    } else {
        errorNotFound('Aset tidak ditemukan.');
    }
}

function errorBadRequest($msg) {
    http_response_code(400); // Bad Request
    echo json_encode(['error'=>$msg]);
    exit;
}

function errorNotFound($msg) {
    http_response_code(404); // Not Found
    echo json_encode(['error'=>$msg]);
    exit;
}
?>