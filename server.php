<?php

include "common.php";

if (isset($_POST["method"])) {
    switch ($_POST["method"]) {
        case "register":
            Register();
            break;
        case "scanQr":
            ScanQr();
            break;
        case "continue":
            ContinueQr();
            break;
        default:
            DefaultMethod();
            break;
    }
}

function Register() {
    $db = new SQLite3("database.db");

    if ($_POST["firstname"] == "" || $_POST["lastname"] == "" || $_POST["department"] == "") {
        Alert("All fields are required.");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `firstname` = :firstname AND `lastname` = :lastname;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":firstname", $_POST["firstname"]);
    $stmt->bindValue(":lastname", $_POST["lastname"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user != false) {
        Alert("An entry with the same first name and last name already exists.");
    }

    $qrId = uniqid("qr-");

    $query = <<<SQL
        INSERT INTO `users` (`firstname`, `lastname`, `department`, `qr_id`)
        VALUES (:firstname, :lastname, :department, :qr_id);
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":firstname", $_POST["firstname"]);
    $stmt->bindValue(":lastname", $_POST["lastname"]);
    $stmt->bindValue(":department", $_POST["department"]);
    $stmt->bindValue(":qr_id", $qrId);
    $stmt->execute();
    session_start();
    session_unset();
    $_SESSION["qrId"] = $qrId;
    header("Location: qr/");
}

function ScanQr() {
    $db = new SQLite3("database.db");
    
    $query = <<<SQL
        SELECT * FROM `users` WHERE `qr_id` = :qr_id;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":qr_id", $_POST["qrData"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user == false) {
        Alert("Invalid QR Code.");
    }

    $query = <<<SQL
        INSERT INTO `attendance` (`user_id`)
        VALUES (:user_id);
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user["id"]);
    $stmt->execute();
    session_start();
    session_unset();
    $_SESSION["name"] = "{$user['firstname']} {$user['lastname']}";
    header("Location: success/");
}

function ContinueQr() {
    session_start();
    session_destroy();
    header("Location: ./");
}

function DefaultMethod() {
    Breakpoint($_POST);
}
