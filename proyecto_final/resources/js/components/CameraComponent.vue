<template>
    <div class="absolute flex flex-wrap w-1/3">
        <div class="w-full p-3">
            <div class="bg-gray-300 rounded-lg shadow-lg flex justify-end">
                <a href="#" onclick="openNav('camera')" class="bg-red-500 text-white">Cerrar</a>
            </div>
            <div class="bg-gray-200 rounded-lg shadow-lg">
                <video id="video" class="w-full" autoplay muted ref="video"></video>
            </div>

            <div class="bg-transparent flex flex-wrap justify-center items-center">
                <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="capture">Capture</button>
            </div>

            <div class="bg-gray-200 rounded-lg shadow-lg flex w-full justify-between">
                <img id="right" class="h-auto w-1/4" src="storage/img/samples/left.jpg" alt="right" ref="right">
                <img id="front" class="h-auto w-1/4" src="storage/img/samples/front.jpg" alt="front" ref="front">
                <img id="left" class="h-auto w-1/4" src="storage/img/samples/left.jpg" alt="left" ref="left" style="transform: rotateY(180deg);">
            </div>
        </div>
    </div>


</template>

<script>
    import * as faceapi from 'face-api.js';
    export default {
        data() {
            return {
                img: 'right',
                file: false,
            }
        },
        methods: {
            startVideo() {
                const video = this.$refs.video;
                console.log(video, this.$refs.video);
                navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
                console.log(navigator.getUserMedia);
                if (navigator.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({
                        video: true
                    }).then(
                        stream => (video.srcObject = stream),
                        err => console.log(err)
                    );
                }
                // video.addEventListener('play', function () {
                //     const canvas = faceapi.createCanvasFromMedia(video);
                //     document.body.append(canvas);
                    // const displaySize = {
                    //     width: video.width,
                    //     height: video.height
                    // };
                    // faceapi.matchDimensions(canvas, displaySize);
                    // setInterval(async () => {
                    //     const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions();
                    //     console.log(detections);
                    //     const resizedDetections = faceapi.resizeResults(detections, displaySize);
                    //     canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                    //     faceapi.draw.drawDetections(canvas, resizedDetections);
                    //     faceapi.draw.drawFaceExpressions(canvas, resizedDetections);
                    //     faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
                    // }, 100);
                // });
            },
            loadModels() {
                Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri('/storage/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/storage/models'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/storage/models'),
                    faceapi.nets.faceExpressionNet.loadFromUri('/storage/models'),
                    faceapi.nets.ageGenderNet.loadFromUri('/storage/models'),
                ]).then(this.startVideo).catch(err => console.log(err));
            },
            async capture() {
                const video = this.$refs.video;
                const img = this.$refs[this.img];
                const canvas = faceapi.createCanvasFromMedia(video);
                const displaySize = {
                    width: video.videoWidth,
                    height: video.videoHeight
                };
                faceapi.matchDimensions(canvas, displaySize);
                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions();
                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                faceapi.draw.drawDetections(canvas, resizedDetections);
                faceapi.draw.drawFaceExpressions(canvas, resizedDetections);
                faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                if (resizedDetections.length === 0 || resizedDetections.length > 1) {
                    console.log(resizeDetections.length);
                    alert('No se detecto un rostro o mas de uno');
                    return;
                } else {
                    if (this.img === 'right') {
                        this.img = 'front';
                    } else if (this.img === 'front') {
                        this.img = 'left';
                    } else if (this.img === 'left') {
                        this.img = 'right';
                    }
                }
                img.src = canvas.toDataURL();

                // Guardar la imagen en el servidor
                // this.file = canvas.toDataURL();
                // console.log(this.file);
                // const formData = new FormData();
                // formData.append('file', this.file);
                // axios.post('/api/upload', formData).then(res => console.log(res)).catch(err => console.log(err));
            }
        },
        mounted() {
            this.loadModels();
        }
    }
</script>
