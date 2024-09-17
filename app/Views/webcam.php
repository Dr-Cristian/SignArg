<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Application</title>
    <style>
    #video {
    border: 1px solid black;
    box-shadow: 2px 2px 3px black;
    width: 320px;
    height: 240px;
    }
    #photo {
    border: 1px solid black;
    box-shadow: 2px 2px 3px black;
    width: 320px;
    height: 240px;
    }
    #canvas {
    display: none;
    }
    .camera {
    width: 340px;
    display: inline-block;
    }
    .output {
    width: 340px;
    display: inline-block;
    vertical-align: top;
    }
    #startbutton {
    display: block;
    position: relative;
    margin-left: auto;
    margin-right: auto;
    bottom: 32px;
    background-color: rgb(0 150 0 / 50%);
    border: 1px solid rgb(255 255 255 / 70%);
    box-shadow: 0px 0px 1px 2px rgb(0 0 0 / 20%);
    font-size: 14px;
    font-family: "Lucida Grande", "Arial", sans-serif;
    color: rgb(255 255 255 / 100%);
    }
    .contentarea {
    font-size: 16px;
    font-family: "Lucida Grande", "Arial", sans-serif;
    width: 760px;
    }
    </style>
</head>
<body>
<div class="contentarea">
    <h1>Sign Arg</h1>
    <div class="camera">
        <video id="video" autoplay controls>Video stream not available.</video>
        <button id="startbutton">Take photo</button>
    </div>
    <canvas id="canvas"> </canvas>
    <form id="image-form" method="POST" action="<?= base_url('123') ?>">
        <input type="hidden" id="image-data" name="image-data" />
        <div class="output">
            <img id="photo" name="photo" alt="The screen capture will appear in this box." />
        </div>
        <input type="submit" id="save-button">Save Image</input>
    </form>
</div>
<script>
(() => {
    const width = 320;
    let height = 0;
    let streaming = false;
    let video = null;
    let canvas = null;
    let photo = null;
    let startbutton = null;
    function showViewLiveResultButton() {
        if (window.self !== window.top) {
        document.querySelector(".contentarea").remove();
        const button = document.createElement("button");
        button.textContent = "View live result of the example code above";
        document.body.append(button);
        button.addEventListener("click", () => window.open(location.href));
        return true;
        }
        return false;
    }
    function startup() {
        if (showViewLiveResultButton()) {
        return;
        }
        video = document.getElementById("video");
        canvas = document.getElementById("canvas");
        photo = document.getElementById("photo");
        startbutton = document.getElementById("startbutton");
        navigator.mediaDevices
        .getUserMedia({ video: true, audio: false })
        .then((stream) => {
            video.srcObject = stream;
            video.play();
        })
        .catch((err) => {
            console.error(`An error occurred: ${err}`);
        });
        video.addEventListener(
        "canplay",
        (ev) => {
            if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            if (isNaN(height)) {
                height = width / (4 / 3);
            }
            video.setAttribute("width", width);
            video.setAttribute("height", height);
            canvas.setAttribute("width", width);
            canvas.setAttribute("height", height);
            streaming = true;
            }
        },
        false,
        );
        startbutton.addEventListener("click", (ev) => {
        takepicture();
        ev.preventDefault();
        }, false);
        clearphoto();
    }
    function saveImage(data) {
    const formData = new FormData();
    formData.append('image', data);
    fetch('saveImage', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            console.log('Image saved successfully');
        } else {
            console.error('Failed to save image');
        }
    })
    .catch(error => {
        console.error('Error saving image:', error);
    });
    }
    function clearphoto() {
        const context = canvas.getContext("2d");
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);

        const data = canvas.toDataURL("image/png");
        photo.setAttribute("src", data);
    }
    function takepicture() {
        const context = canvas.getContext("2d");
        if (width && height) {
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);

        const data = canvas.toDataURL("image/png");
        photo.setAttribute("src", data);
        saveImage(data);
        } else {
        clearphoto();
        }
    }
    window.addEventListener("load", startup, false);
})();
</script>
</body>
</html>