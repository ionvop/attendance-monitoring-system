<?php

session_start();

?>

<html>
    <head>
        <title>
            Attendance on Cooldown
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <style>
            .main__cooldown {
                display: grid;
                grid-template-rows: max-content 1fr;
                height: 100%;
                background-image: url("assets/bg.jpg");
                background-size: cover;
            }

            .header {
                padding: 1rem;
                background-color: #fff;
            }

            .content {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                background-color: #4bfa;
            }

            .message {
                display: grid;
                grid-template-rows: 1fr max-content 1fr;
            }

            .message__box {
                background-color: #a55;
                border-radius: 1rem;
                color: #fff;
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__cooldown">
            <div class="header -title">
                RMC Faculty Attendance Monitoring System
            </div>
            <div class="content -center__flex">
                <div></div>
                <div class="message">
                    <div></div>
                    <div class="message__box">
                        Hello, <?=$_SESSION["name"]?><br>
                        You have already scanned in within the past hour.
                    </div>
                    <div></div>
                </div>
                <div></div>
            </div>
        </div>
    </body>
    <script src="script.js"></script>
    <script>
        setInterval(() => {
            location.href = "./";
        }, 3000);
    </script>
</html>