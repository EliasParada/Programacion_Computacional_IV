<template>
    <div class="w-full h-full flex justify-center items-center fixed" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-1/2 fixed flex flex-col justify-center items-center rounded-lg shadow-lg p-4">
            <div class="bg-gray-200 rounded-lg shadow-lg flex flex-col w-full">
                <span class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-full">
                    <p class="text-center text-2xl font-bold py-2 px-4">Usuario</p>
                </span>
                <div class="bg-gray-200 rounded-lg shadow-lg flex flex-col w-full">
                    <img :src="'storage/' + user_to.avatar" class="w-64 h-64 p-3 mx-auto">
                </div>
                <div class="bg-gray-200 rounded-lg shadow-lg flex flex-col w-full">
                    <span class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-full">
                        <p class="text-center text-2xl font-bold py-2 px-4">Nombre</p>
                    </span>
                    <p class="text-center text-2xl font-bold py-2 px-4">{{ user_to.name }}</p>
                </div>
                <div v-if="user_to.friend == false && user_to.request == false" class="bg-gray-200 rounded-lg shadow-lg flex justify-between items-center w-full">
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="addFriend">Agregar</button>
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="exit">Cancelar</button>
                </div>
                <div v-else-if="user_to.friend == true" class="bg-gray-200 rounded-lg shadow-lg flex justify-between items-center w-full">
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="goChat">Ir al chat</button>
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="delFriend">Eliminar</button>
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="exit">Cancelar</button>
                </div>
                <div v-else-if="user_to.request == true" class="bg-gray-200 rounded-lg shadow-lg flex justify-between items-center w-full">
                    <button v-if="user_to.me == true" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="cancelFriend">Cancelar</button>
                    <button v-if="user_to.me == false" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="acceptFriend">Aceptar</button>
                    <button v-if="user_to.me == false" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="rejectFriend">Rechazar</button>
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="exit">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user_by: {
                type: Object,
                required: true
            },
            user_to: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                // note: '',
            }
        },
        methods: {
            exit() {
                this.$root.$emit('close', 'profile');
                this.note = '';
            },
            addFriend() {
                Promise.resolve(queries('POST', '/requests', {
                    user_id: this.user_by.id,
                    friend_id: this.user_to.id
                })).then(res => {
                    console.log('Solicitud enviada');
                    this.$root.$emit('close', 'profile');
                });
            },
            delFriend() {
                //
                console.log('delFriend');
            },
            acceptFriend() {
                Promise.resolve(queries('POST', '/friends', {
                    user_id: this.user_by.id,
                    friend_id: this.user_to.id
                })).then(res => {
                    console.log('Solicitud aceptada');
                    this.$root.$emit('close', 'profile');
                });
            },
            rejectFriend() {
                this.user_to.for = 'friend';
                Promise.resolve(queries('DELETE', '/requests/reject/', this.user_to))
                .then(res => {
                    console.log('Solicitud rechazada');
                    this.$root.$emit('close', 'profile');
                });
            },
            cancelFriend() {
                this.user_to.for = 'sent';
                Promise.resolve(queries('DELETE', '/requests/cancel/', this.user_to))
                .then(res => {
                    console.log('Solicitud cancelada');
                    this.$root.$emit('close', 'profile');
                });
            },
            goChat() {
                //
                console.log('goChat');
            }
        },
        mounted() {
            // this.note = JSON.parse(JSON.stringify(this.get));
        },
    }
</script>