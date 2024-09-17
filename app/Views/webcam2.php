<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Application</title>
    <style>
    video {
    width: 50%;
    height: auto;
    }
    canvas {
    display: none;
    }
    </style>
</head>
<body>
    <h1>Video:</h1>
    <video id="camera-feed" autoplay controls></video>
<script>
    window.addEventListener('load', function startCamera() {
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
        const videoElement = document.getElementById('camera-feed');
        videoElement.srcObject = stream;
        })
        .catch(error => {
        console.error('Error accessing camera:', error);
        });
    });
</script>
</body>
</html>