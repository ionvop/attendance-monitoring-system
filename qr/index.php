<?php

session_start();

?>

<html>
    <head>
        <title>
            Register Successful
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <style>
            .main__qr {
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

            .form {
                display: grid;
                grid-template-rows: 1fr max-content 1fr;
            }

            .form__box {
                background-color: #fff;
                border-radius: 1rem;
            }

            .form__box__title {
                padding: 1rem;
            }

            .form__box__qr {
                display: grid;
                grid-template-columns: 1fr max-content 1fr;
            }

            .form__box__qr__img {
                padding: 1rem;
            }

            .form__box__continue {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__qr">
            <div class="header -title">
                RMC Faculty Attendance Monitoring System
            </div>
            <div class="content -center__flex">
                <div></div>
                <div class="form">
                    <div></div>
                    <form class="-form form__box" action="server.php" method="post" enctype="multipart/form-data">
                        <div class="form__box__title -title -center">
                            Your QR Code
                        </div>
                        <div class="form__box__qr">
                            <div></div>
                            <div class="form__box__qr__img" id="panelQr"></div>
                            <div></div>
                        </div>
                        <div class="form__box__continue -center">
                            <button class="-button" name="method" value="continue">
                                Continue
                            </button>
                        </div>
                    </form>
                    <div></div>
                </div>
                <div></div>
            </div>
        </div>
    </body>
    <script src="script.js"></script>
    <script>
        let panelQr = document.getElementById("panelQr");

        let qr = new QRCode(panelQr, {
            text: <?=json_encode($_SESSION["qrId"])?>,
            width: 256,
            height: 256,
        });
    </script>
</html>