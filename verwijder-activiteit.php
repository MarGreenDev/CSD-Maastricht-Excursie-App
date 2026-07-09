<?php
session_start();
include_once 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: admin/index.php');
    exit;
}

$currentUserId = (int) $_SESSION['user_id'];
$isAdmin = false;
$stmt = $conn->prepare('SELECT is_admin FROM users WHERE id = ? LIMIT 1');
if ($stmt) {
    $stmt->bind_param('i', $currentUserId);
    $stmt->execute();
    $stmt->bind_result($userIsAdmin);
    if ($stmt->fetch()) {
        $isAdmin = intval($userIsAdmin) === 1;
    }
    $stmt->close();
}

if (!$isAdmin) {
    header('Location: admin/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['activiteit_id'])) {
    header('Location: admin/index.php');
    exit;
}

$activiteitId = (int) $_POST['activiteit_id'];

if ($activiteitId > 0) {
    $stmt = $conn->prepare('DELETE FROM activiteiten WHERE id = ?');
    $stmt->bind_param('i', $activiteitId);
    $stmt->execute();
    $stmt->close();
}

header('Location: admin/index.php');
exit;

