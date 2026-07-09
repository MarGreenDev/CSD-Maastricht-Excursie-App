<?php
include_once 'includes/connection.php';


$activiteitId = (int)$_GET["activiteit_id"];


$sql = "
SELECT users.naam
FROM favorieten
JOIN users
ON favorieten.user_id = users.id
WHERE favorieten.activiteit_id = $activiteitId
";

$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

header("Content-Type: application/json");
echo json_encode($users);