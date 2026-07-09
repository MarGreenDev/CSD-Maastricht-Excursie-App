<?php
session_start();
include_once 'includes/connection.php';

$userId = $_SESSION['user_id'];
$activiteitId = $_POST['activiteit_id'];

$sql = "INSERT INTO favorieten (user_id, activiteit_id)
        VALUES (?, ?)";

$stmt = $conn->prepare("INSERT INTO favorieten (user_id, activiteit_id) VALUES (?, ?)");
$stmt->bind_param("ii", $userId, $activiteitId);
$stmt->execute();

header('Location: index.php');