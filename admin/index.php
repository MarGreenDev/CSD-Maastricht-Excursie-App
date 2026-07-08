<?php
session_start();
if (isset($_SESSION["user_id"])) {


    if ($_SESSION["user_id"] !== 1) {
        echo "jij bent hier niet welkom";
    } else {
        echo "hallo marylou";
    }
} else {
    echo "log in sukkel";
}
