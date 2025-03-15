<html>
    <head>
        <title>
            Register
        </title>
        <base href="./">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
        <style>
            .main {
                height: 100%;
                background-image: url("assets/bg.jpg");
                background-size: cover;
            }

            .content {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                background-color: #4bfa;
                height: 100%;
                overflow-y: hidden;
            }

            .scan {
                display: grid;
                grid-template-rows: 1fr repeat(3, max-content) 1fr;
            }

            .scan__title {
                padding: 1rem;
                font-weight: bold;
            }

            .scan__qr {
                padding: 1rem;
            }

            .scan__qr > video {
                width: 20rem;
                border-radius: 1rem;
            }

            .scan__register {
                padding: 1rem;
            }

            .scan__lost {
                padding: 1rem;
            }

            .title {
                display: grid;
                grid-template-rows: 1fr repeat(2, max-content) 1fr;
                padding: 5rem;
            }

            .title__acronym {
                font-size: 7rem;
                font-weight: bold;
            }

            .title__name {
                font-size: 5rem;
            }
        </style>
    </head>
    <body>
        <div class="main">
            <div class="content">
                <div class="scan">
                    <div></div>
                    <div class="scan__title -title -center">
                        SCAN QR HERE
                    </div>
                    <div class="scan__qr -center">
                        <video id="vidCapture" autoplay playsinline></video>
                    </div>
                    <div class="scan__register -center">
                        Haven't registered yet? <a href="register/">Register</a>
                    </div>
                    <div class="scan__lost -center">
                        <a href="forgot/">Lost your QR?</a>
                    </div>
                    <div></div>
                </div>
                <div class="title">
                    <div></div>
                    <div class="title__acronym">
                        RMC
                    </div>
                    <div class="title__name">
                        Faculty Attendance Monitoring System
                    </div>
                    <div></div>
                </div>
            </div>
        </div>
    </body>
    <script src="script.js"></script>
    <script>
        let vidCapture = document.getElementById("vidCapture");

        async function startCamera() {
            try {
                let stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                vidCapture.srcObject = stream;
                requestAnimationFrame(scanFrame);
            } catch (error) {
                console.error("Error accessing the camera:", error);
            }
        }

        function scanFrame() {
            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");

            if (vidCapture.readyState === vidCapture.HAVE_ENOUGH_DATA) {
                canvas.width = vidCapture.videoWidth;
                canvas.height = vidCapture.videoHeight;
                ctx.drawImage(vidCapture, 0, 0, canvas.width, canvas.height);
                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    console.log("QR Code detected:", code.data);
                    sendToServer(code.data);
                    return;
                }
            }

            requestAnimationFrame(scanFrame);
        }

        function sendToServer(qrData) {
            let form = document.createElement("form");
            form.action = "server.php";
            form.method = "POST";
            let methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "method";
            methodInput.value = "scanQr";
            let qrInput = document.createElement("input");
            qrInput.type = "hidden";
            qrInput.name = "qrData";
            qrInput.value = qrData;
            form.appendChild(methodInput);
            form.appendChild(qrInput);
            document.body.appendChild(form);
            form.submit();
        }

        startCamera();
    </script>
</html>