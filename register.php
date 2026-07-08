<?php
include_once 'includes/connection.php';

$message = '';

if (isset($_POST["register"])) {


    $registerName = trim($_POST["registerName"]);
    $registerEmail = $_POST["registerEmail"];
    $registerPassword = $_POST["registerPassword"];

    if (empty($registerName) || empty($registerEmail) || empty($registerPassword)) {
        $message = "Please fill in all fields";
    } else {
        //check for existing user

        $checkSql = "SELECT id FROM users WHERE naam = ? OR email = ?";

        $checkStmt = $conn->prepare($checkSql);

        $checkStmt->bind_param("ss", $registerName, $registerEmail);

        $checkStmt->execute();

        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Username or email already exists";
        } else {

            $hashedPassword = password_hash($registerPassword, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (naam, email, wachtwoord) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("sss", $registerName, $registerEmail, $hashedPassword);


            if (!$stmt) {
                die("Prepare error: " . $conn->error);
            }

            if ($stmt->execute()) {
                header("Location: index.php");
            } else {
                die("Execute error: " . $stmt->error);
            }

            $stmt->close();
        }
        $checkStmt->close();
    }
}
