<?php
require 'config.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM aset WHERE id_aset = :id");
    $stmt->execute(['id' => $id]);
}
header('Location: list.php');
exit;
?>