/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.openNav = (nav) => {
    for (let key in app.navs) {
        app.navs[key].open = key === nav;
    }
}
window.socketio = io('http://localhost:3000');
socketio.on('connect', function(e){
    console.log('Connected to server');
});
if (!Notification) {
    console.log('Notifications are not supported');
}
window.notificable = 'default';
if (Notification.permission !== "denied") {
    Notification.requestPermission(function (status) {
        console.log('Notification permission status:', status);
        notificable = status;
    });
} else {
    console.log('Notification permission is denied');
    notificable = 'denied';
}
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import example from './components/ExampleComponent.vue';
import camera from './components/CameraComponent.vue';
import notes from './components/NotesComponent.vue';
import profiles from './components/UsersComponent.vue';
import requests from './components/RequestComponent.vue';
import news from './components/NewsComponent.vue';
import setting from './components/SettingsComponent.vue';
import toast from './components/vToast.vue';
import expert from './components/ExpertComponent.vue';
import chat from './components/ChatComponent.vue';
import * as faceapi from 'face-api.js';

window.queries = async (method = 'POST', url = '', data = null) => {
    const response = await axios({
        method,
        url,
        data,
    })
    .then(res => {
        return res.data;
    })
    .catch(error => {
        console.log(error);
        return {err: error.response.data, status: 'error'};
    });
    return response;
};
window.changeRequest = (num) => {
    app.numRequest += num;
    if (app.numRequest < 0) {
        app.numRequest = 0;
    }
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        dark: false,
        navs: {
            notes: {open: true},
            profiles: {open: false},
            camera: {open: false},
            requests: {open: false},
            news: {open: false},
            settings: {open: false},
            expert: {open: false},
            chat: {open: false},
        },
        front: '',
        profile: '',
        is_request: false,
        user: null,
        friend: null,
        numRequest: 0,
        video: null,
    },
    components: {
        'example-component': example,
        'camera-component': camera,
        'notes-component': notes,
        'profiles-component': profiles,
        'requests-component': requests,
        'news-component': news,
        'setting-component': setting,
        'tast': toast,
        'expert-component': expert,
        'chat-component': chat,
    },
    methods: {
        getRequest: async (id) => {
            const response = await queries('GET', '/requests/')
            .then(res => {
                console.log(res, res.length);
                if (res.length == 0) {
                    app.is_request = false;
                }
                app.numRequest = res.length;
                app.is_request = true;
            })
            .catch(error => {
                console.log(error);
                app.is_request = false;
            });
        },
        getUser() {
            let userDiv = document.getElementById('user');
            let id = userDiv.getElementsByTagName('ul')[0].getElementsByTagName('li')[0].innerHTML;
            let name = userDiv.getElementsByTagName('ul')[0].getElementsByTagName('li')[1].innerHTML;
            let email = userDiv.getElementsByTagName('ul')[0].getElementsByTagName('li')[2].innerHTML;
            this.user = {id, name, email};
            console.log(this.user);
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
        startVideo() {
            const video = this.$refs.analizer;
            console.log(video, this.$refs.analizer);
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
            console.log(navigator.getUserMedia);
            if (navigator.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                    video: true
                }).then(
                    stream => (video.srcObject = stream),
                    err => console.log(err)
                )
            }

            video.addEventListener('play', function () {
                setInterval(async () => {
                    // Detectar rostros y obtener las expresiones
                    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceExpressions();
        
                    // Asegurarse de que haya detecciones y expresiones
                    if (detections.length > 0 && detections[0]?.expressions) {
                        const expressions = detections[0].expressions;
        
                        // Obtener la emoción con el valor más alto
                        const highestEmotion = Object.entries(expressions).reduce((highest, current) => {
                            return current[1] > highest[1] ? current : highest;
                        }, ["", -Infinity]);
        
                        const [emotion, value] = highestEmotion;
        
                        console.log(`Emoción dominante: ${emotion}, Valor: ${value}`);
                    }
                }, 100);
            
            });
        },
    },
    mounted() {
        Promise.all([
            this.getRequest(),
            this.getUser()]);
        console.log(`Personal chanel: ${this.user.id}Chan`)
        socketio.on(`${this.user.id}Chan`, function(data){
            if (notificable === 'granted') {
                var notification = new Notification(data.title, {
                    body: data.body,
                    icon: data.icon,
                });

                notification.onclick = function () {
                    window.open(data.url);
                }
            }
        });
        this.loadModels();
    },
    beforeMount() {
        this.$root.$on('images', (value) => {
            this.front = value.front;
            this.profile = value.profile;
            this.navs.camera.open = false;
        });
        this.$root.$on('close', (value) => {
            this.navs[value].open = false;
        });
        this.$root.$on('go_chat', (value) => {
            this.friend = value;
            openNav('chat');
        });
    }
});
