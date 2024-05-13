
function getUserMedia(options, successCallback, failureCallback) {
    var api = navigator.getUserMedia || navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia || navigator.msGetUserMedia;
    if (api) {
        return api.bind(navigator)(options, successCallback, failureCallback);
    }
}

var theStream1;
var theRecorder;
var recordedChunks = [];

function getStream() {
    if (!navigator.mediaDevices.getUserMedia) {
        alert('User Media API not supported.');
        return;
    }

    var constraints = { video: true, audio: true };
    navigator.mediaDevices.getUserMedia(constraints)
    .then(function (stream) {
        var mediaControl = document.getElementById('videoPlayer');

        if ('srcObject' in mediaControl) {
            mediaControl.srcObject = stream;
        } else {
            mediaControl.src = URL.createObjectURL(stream);
        }

        theStream1 = stream;
        try {
            theRecorder = new MediaRecorder(stream, { mimeType: "video/webm" });
        } catch (e) {
            console.error('Exception while creating MediaRecorder: ' + e);
            return;
        }
        console.log('MediaRecorder created');
        theRecorder.ondataavailable = recorderOnDataAvailable;
        theRecorder.start(100);
    })
    .catch(function (err) {
        alert('Error: ' + err);
    });
}

function recorderOnDataAvailable(event) {
    if (event.data.size == 0) return;
    recordedChunks.push(event.data);
}

function download() {
    console.log('Saving data');
    theRecorder.stop();
    theStream1.getTracks().forEach(track => track.stop());

    var blob = new Blob(recordedChunks, { type: "video/webm" });
    var url = URL.createObjectURL(blob);
    var a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";
    a.href = url;
    a.download = 'test.webm';
    a.click();

    // setTimeout() here is needed for Firefox.
    setTimeout(function () {
        URL.revokeObjectURL(url);
    }, 100);
}

function getVideo() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('User Media API not supported.');
        return;
    }

    var constraints = {
        video: true
    };

    getUserMedia(constraints, function (stream) {
        var mediaControl = document.getElementById('videoPhoto');
        if ('srcObject' in mediaControl) {
            mediaControl.srcObject = stream;
        } else if (navigator.mozGetUserMedia) {
            mediaControl.mozSrcObject = stream;
        } else {
            mediaControl.src = (window.URL || window.webkitURL).createObjectURL(stream);
        }
        theStream = stream; // Stocker le flux de média pour une utilisation ultérieure
    }, function (err) {
        alert('Error: ' + err);
    });
}

function takePhoto() {
    if (!('ImageCapture' in window)) {
        alert('ImageCapture is not available');
        return;
    }

    if (!theStream) {
        alert('Grab the video stream first!');
        return;
    }

    var theImageCapturer = new ImageCapture(theStream.getVideoTracks()[0]);

    theImageCapturer.takePhoto()
        .then(blob => {
            var theImageTag = document.getElementById("imageTag");
            theImageTag.src = URL.createObjectURL(blob);
        })
        .catch(err => alert('Error: ' + err));
}

function getReadFile(reader, i, file) {
    return function () {
        var li = document.querySelector('[data-idx="' + i + '"]');

        if (file.type === 'image/png') {
            var img = document.createElement('img');
            img.src = reader.result;
            li.appendChild(img);
        }
    }
}

function readFiles(files) {

    var target = document.getElementById('target');
    target.innerHTML = '';

    for (var i = 0; i < files.length; ++i) {
        var item = document.createElement('li');
        item.setAttribute('data-idx', i);
        var file = files[i];

        var reader = new FileReader();
        reader.addEventListener('load', getReadFile(reader, i, file));
        reader.readAsDataURL(file);

        target.appendChild(item);
    };
}
