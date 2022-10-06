<template>
    <div class="w-full h-full flex flex-wrap w-1/2 fixed overflow-auto" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-full bg-second-500 absolute rounded-lg">
            <div class="bg-first-900 rounded-lg shadow-lg flex justify-between p-2">
                <p class="text-center text-white text-2xl font-bold py-2 px-4">Enseñanos tu cara</p>
                <button type="button" @click="close()" class="bg-second-900 text-white rounded-full hover:bg-second-500 h-8 w-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="bg-transparent rounded-lg shadow-lg p-4">
                <video id="video" class="w-full rounded-lg shadow-lg mb-2" autoplay muted ref="video"></video>
                <div class="bg-transparent flex flex-wrap w-full justify-center items-center">
                    <button v-if="two" type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold  h-14 w-14 rounded-full" @click="capture">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    <button v-else type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold  h-14 w-14 rounded-full" @click="compare">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="bg-first-900 rounded-lg shadow-lg flex w-full justify-around">
                <img class="h-auto rounded-lg w-1/4 border-2 border-black border-solid" src="storage/img/samples/front.jpg" alt="front" ref="front" :class="{'border-dashed border-first-50': img === 'front'}">
                <img v-if="two" class="h-auto rounded-lg w-1/4 border-2 border-black border-solid" src="storage/img/samples/left.jpg" alt="profile" ref="profile" :class="{'border-dashed border-first-50': img === 'profile'}">
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
            },
            findLabels() {
                const labels = ['front.png', 'profile.png'];
                const folder = 'storage/images/' + this.email;
                return Promise.all(labels.map(async label => {
                    const descriptions = [];
                    const img = await faceapi.fetchImage(folder + '/' + label);
                    const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                    console.log(detections);
                    if (detections) {
                        descriptions.push(detections.descriptor);
                    }
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