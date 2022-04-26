<template>
    <div class="w-full h-full flex flex-wrap w-1/2 fixed" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-full p-3">
            <div class="bg-gray-300 rounded-lg shadow-lg flex justify-end">
                <a href="#" @click="close()" class="bg-red-500 text-white">Cerrar</a>
                <input type="email" class="w-full p-3 rounded-lg" placeholder="Email" v-model="email">
            </div>
            <div class="bg-gray-200 rounded-lg shadow-lg p-4">
                <video id="video" class="w-full rounded-lg shadow-lg" autoplay muted ref="video"></video>
            </div>

            <div class="bg-transparent flex flex-wrap justify-center items-center">
                <button v-if="two" type="button" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="capture">Capture</button>
                <button v-else type="button" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="compare">Capture</button>
            </div>

            <div class="bg-gray-200 rounded-lg shadow-lg flex w-full justify-around">
                <img class="h-auto rounded-lg w-1/4" src="storage/img/samples/front.jpg" alt="front" ref="front" :class="{'drop-shadow-lg': img === 'front'}">
                <img v-if="two" class="h-auto rounded-lg w-1/4" src="storage/img/samples/left.jpg" alt="profile" ref="profile" :class="{'drop-shadow-lg': img === 'profile'}">
            </div>
        </div>
    </div>


</template>

<script>
    import * as faceapi from 'face-api.js';
    export default {
        props: {
            two: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                img: 'front',
                file: false,
                email: '',
                images: {
                    front: '',
                    profile: '',
                }
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
            },
            loadModels() {
                Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri('/storage/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/storage/models'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/storage/models'),
                    faceapi.nets.faceExpressionNet.loadFromUri('/storage/models'),
                    faceapi.nets.ageGenderNet.loadFromUri('/storage/models'),
                    faceapi.nets.faceExpressionNet.loadFromUri('/storage/models'),
                    faceapi.nets.ssdMobilenetv1.loadFromUri('/storage/models'),
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
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions();
                const resizedDetections = faceapi.resizeResults(detections, displaySize);

                if (resizedDetections.length != 1) {
                    if (resizedDetections.length <= 0) {
                        alert('No se ha detectado ninguna cara');
                    } else {
                        alert('Asegurate de estar solo');
                    }
                    return;
                } else {
                    if (this.img === 'profile') {
                        this.img = 'front';
                        this.images.profile = canvas.toDataURL('image/png');
                    } else if (this.img === 'front') {
                        this.img = 'profile';
                        this.images.front = canvas.toDataURL('image/png');
                    }
                }
                img.src = canvas.toDataURL();
                if (this.images.front != '' && this.images.profile != '') {
                    this.sendImages();
                }
            },
            sendImages() {
                this.$root.$emit('images', this.images);
            },
            close() {
                this.$root.$emit('close', 'camera');
            },
            async compare(){
                const video = this.$refs.video;
                const img = this.$refs[this.img];
                const canvas = faceapi.createCanvasFromMedia(video);
                const labelDescriptors = await this.findLabels();
                const faceMatcher = new faceapi.FaceMatcher(labelDescriptors, 0.6);
                const displaySize = {
                    width: video.videoWidth,
                    height: video.videoHeight
                };
                faceapi.matchDimensions(canvas, displaySize);
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                const detections = await faceapi.detectAllFaces(video).withFaceLandmarks().withFaceDescriptors();
                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));
                results.forEach((result, i) => {
                    const box = resizedDetections[i].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() });
                    drawBox.draw(canvas);
                });
                img.src = canvas.toDataURL();
                console.log(results);
                // if (results.filter(r => r.label == 'unknown').length == 0 && results.filter(r => r.label == 'unknown').length == 0) {
                //     this.$root.$emit('images', true);
                // }
            },
            findLabels() {
                const labels = ['front.png', 'profile.png'];
                const folder = 'storage/images/' + this.email;
                return Promise.all(labels.map(async label => {
                    const descriptions = [];
                    const img = await faceapi.fetchImage(folder + '/' + label);
                    const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                    console.log(detections);
                    descriptions.push(detections.descriptor);
                    console.log(descriptions);
                    return new faceapi.LabeledFaceDescriptors(label, descriptions);
                }));
            }
        },
        mounted() {
            this.loadModels();
        }
    }
</script>

<style>
.drop-shadow-lg {
    filter: drop-shadow(0 0px 22px rgb(61, 117, 250));
}
</style>