<?php
session_start();
include_once "includes/connection.php";

$message = '';


if (isset($_POST["login"])) {

    $email = trim($_POST["loginEmail"]);
    $password = $_POST["loginPassword"];

    if (empty($email) || empty($password)) {

        $message = "Please fill in all fields";
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        //check if user exists 
        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            //verify password
            if (password_verify($password, $user['wachtwoord'])) {

                //store user in session 

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["naam"] = $user["naam"];


                header("location: index.php");
                exit();
            } else {
                $message = "Password is incorrect :(";
            }
        } else {
            $message = "User not found :(";
        }
        $stmt->close();
    }
}
