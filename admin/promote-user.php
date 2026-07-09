<?php
session_start();
include_once '../includes/connection.php';

if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_id'] !== 1) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['user_id'])) {
    header('Location: index.php');
    exit;
}

$userId = (int) $_POST['user_id'];

if ($userId <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare('UPDATE users SET is_admin = 1 WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->close();

header('Location: index.php');
exit;
