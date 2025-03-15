<html>
    <head>
        <title>
            Forgot QR
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .main__forgot {
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

            .form__box__subtitle {
                padding: 1rem;
                padding-bottom: 0rem;
            }

            .form__box__field__input {
                padding: 1rem;
            }

            .form__box__field__label {
                padding: 1rem;
                padding-top: 0rem;
            }

            .form__box__department__label {
                padding: 1rem;
            }

            .form__box__department__input {
                padding: 1rem;
                padding-top: 0rem;
            }

            .form__box__submit {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="main__forgot">
            <div class="header -title">
                RMC Faculty Attendance Monitoring System
            </div>
            <div class="content -center__flex">
                <div></div>
                <div class="form">
                    <div></div>
                    <form class="-form form__box" action="server.php" method="post" enctype="multipart/form-data">
                        <div class="form__box__title -title -center">
                            Forgot QR
                        </div>
                        <div class="form__box__subtitle -center">
                            Enter the details of your account
                        </div>
                        <div class="form__box__firstname form__box__field">
                            <div class="form__box__firstname__input form__box__field__input">
                                <input class="-input" name="firstname" required>
                            </div>
                            <div class="form__box__firstname__label form__box__field__label">
                                First Name
                            </div>
                        </div>
                        <div class="form__box__lastname form__box__field">
                            <div class="form__box__lastname__input form__box__field__input">
                                <input class="-input" name="lastname" required>
                            </div>
                            <div class="form__box__lastname__label form__box__field__label">
                                Last Name
                            </div>
                        </div>
                        <div class="form__box__department">
                            <div class="form__box__department__label">
                                Department
                            </div>
                            <div class="form__box__department__input">
                                <select class="-select" name="department" required>
                                    <option value="">Select Department</option>
                                    <option>Grade 7</option>
                                    <option>STEM</option>
                                    <option>ABM</option>
                                    <option>HUMSS</option>
                                    <option>GAS</option>
                                    <option>TVL ICT</option>
                                    <option>TVL COOKERY</option>
                                </select>
                            </div>
                            <div class="form__box__submit -center">
                                <button class="-button" name="method" value="forgotQr">
                                    Submit
                                </button>
                            </div>
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

    </script>
</html>