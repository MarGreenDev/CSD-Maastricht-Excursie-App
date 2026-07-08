<?php
session_start();
include_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $naam = $_POST['activiteit'];
    $omschrijving = $_POST['activiteitOmschrijving'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];

    $sql = "INSERT INTO activiteiten
    (naam, omschrijving, datum, tijd)

    VALUES
    ('$naam', '$omschrijving', '$datum', '$tijd')";

    $conn->query($sql);

    header('Location: admin/index.php');
}