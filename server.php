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
        case "clear":
            Clear();
            break;
        case "deleteRecord":
            DeleteRecord();
            break;
        case "forgotQr":
            ForgotQr();
            break;
        case "download":
            Download();
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
        header("Location: ./");
        exit;
    }

    $query = <<<SQL
        SELECT * FROM `attendance` WHERE `user_id` = :user_id; ORDER BY `time` DESC LIMIT 1;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user["id"]);
    $attendance = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    session_start();
    session_unset();
    $_SESSION["name"] = "{$user['firstname']} {$user['lastname']}";

    if ($attendance != false) {
        $timeDiff = time() - $attendance["time"];

        if ($timeDiff < 3600) {
            header("Location: cooldown/");
            exit;
        }
    }

    $query = <<<SQL
        INSERT INTO `attendance` (`user_id`)
        VALUES (:user_id);
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user["id"]);
    $stmt->execute();
    header("Location: success/");
}

function ContinueQr() {
    session_start();
    session_destroy();
    header("Location: ./");
}

function Clear() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `attendance`
    SQL;

    $db->query($query);
    header("Location: admin/");
}

function DeleteRecord() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `attendance` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    header("Location: admin/");
}

function ForgotQr() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `users` WHERE `firstname` = :firstname AND `lastname` = :lastname AND `department` = :department LIMIT 1
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":firstname", $_POST["firstname"]);
    $stmt->bindValue(":lastname", $_POST["lastname"]);
    $stmt->bindValue(":department", $_POST["department"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user == false) {
        Alert("No matching records found.");
    }

    session_start();
    session_unset();
    $_SESSION["qrId"] = $user["qr_id"];
    header("Location: qr/");
}

function Download() {
    $db = new SQLite3("database.db");

    $result = [
        ["Name", "Department", "Time Scanned"]
    ];

    $query = <<<SQL
        SELECT `attendance`.*, `users`.`firstname`, `users`.`lastname`, `users`.`department`
        FROM `attendance` LEFT JOIN `users` ON `attendance`.`user_id` = `users`.`id`
    SQL;

    $rows = $db->query($query);

    while ($row = $rows->fetchArray()) {
        date_default_timezone_set("Asia/Manila");
        $result[] = ["{$row['firstname']} {$row['lastname']}", $row["department"], date("F j, Y g:iA", $row["time"])];
    }

    $filename = date("Y-m-d H-i-s", time()) . ".csv";
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"{$filename}\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    $fp = fopen("php://output", "w");

    foreach ($result as $row) {
        fputcsv($fp, $row, ",", "\"", "\\");
    }

    fclose($fp);
    flush();
    exit;
}

function DefaultMethod() {
    Breakpoint($_POST);
}
