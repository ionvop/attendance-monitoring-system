<?php

chdir("../");
include "common.php";

?>

<html>
    <head>
        <title>
            Admin
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .main__admin {
                display: grid;
                grid-template-rows: max-content 1fr;
                height: 100%;
            }

            .header {
                padding: 1rem;
                background-color: #09f;
            }

            .content {
                padding: 1rem;
            }

            .form {
                padding: 1rem;
                background-color: #666;
                border-radius: 1rem;
            }

            .form__title {
                padding: 1rem;
                color: #fff;
            }

            .form__headers {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                background-color: #fff;
                font-weight: bold;
            }

            .form__header {
                padding: 1rem;
            }

            .form__data {
                padding-top: 1rem;
            }

            .form__data__box {
                background-color: #fff;
            }

            .form__data__box .item {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
            }

            .form__data__box .item__column {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__admin">
            <div class="header -title">
                RMC Faculty Attendance Monitoring System
            </div>
            <div class="content">
                <div class="form">
                    <div class="form__title -title">
                        Faculty Attendance
                    </div>
                    <div class="form__headers">
                        <div class="form__headers__name form__header">
                            Name
                        </div>
                        <div class="form__headers__department form__header">
                            Department
                        </div>
                        <div class="form__headers__time form__header">
                            Time Scanned
                        </div>
                    </div>
                    <div class="form__data">
                        <div class="form__data__box">
                            <?php
                                $db = new SQLite3("database.db");

                                $query = <<<SQL
                                    SELECT `attendance`.*, `users`.`firstname`, `users`.`lastname`, `users`.`department` FROM `attendance`
                                    LEFT JOIN `users` ON `attendance`.`user_id` = `users`.`id`;
                                SQL;

                                $result = $db->query($query);

                                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                    $name = "{$row['firstname']} {$row['lastname']}";
                                    $name = htmlentities($name);
                                    date_default_timezone_set("Asia/Manila");
                                    $time = date("F j, Y g:iA", $row["time"]);

                                    echo <<<HTML
                                        <div class="item">
                                            <div class="item__name item__column">
                                                {$name}
                                            </div>
                                            <div class="item__department item__column">
                                                {$row["department"]}
                                            </div>
                                            <div class="item__time item__column">
                                                {$time}
                                            </div>
                                        </div>
                                    HTML;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="script.js"></script>
    <script>

    </script>
</html>