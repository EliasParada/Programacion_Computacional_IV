<template>
    <div class="w-full h-full flex justify-center items-center fixed" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-2/3 fixed flex flex-col justify-center items-center rounded-lg shadow-lg">
            <div class="bg-second-50 rounded-lg shadow-lg flex flex-col w-full">
                <span class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded-lg self-end w-full">
                    <p class="text-center text-2xl font-bold py-2 px-4">¿Conoces a {{ user_to.name }}?</p>
                </span>
                <div class="bg-second-50 rounded-lg shadow-lg flex flex-col w-full pb-2">
                    <img :src="user_to.avatar" class="w-64 h-64 p-3 mx-auto">
                </div>
                <div v-if="!user_to.block_me && !user_to.block_for">
                    <div v-if="user_to.friend == false && user_to.request == false" class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full space-x-4">
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="addFriend">Enviar Solicitud</button>
                        <button class="bg-warning-900 hocer:bg-warning-500 text-white font-bold py-2 px-4 rounded" @click="blockUser">Bloquear</button>
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="exit">Salir</button>
                    </div>
                    <div v-else-if="user_to.friend == true" class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full">
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="goChat">Ir al chat</button>
                        <button class="bg-warning-900 hocer:bg-warning-500 text-white font-bold py-2 px-4 rounded" @click="delFriend">Eliminar Amigo</button>
                        <button class="bg-warning-900 hocer:bg-warning-500 text-white font-bold py-2 px-4 rounded" @click="blockUser">Bloquear</button>
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="exit">Salir</button>
                    </div>
                    <div v-else-if="user_to.request == true" class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full">
                        <button v-if="user_to.me == true" class="bg-warning-900 hocer:bg-warning-500 text-white font-bold py-2 px-4 rounded" @click="cancelFriend">Cancelar Solicitud</button>
                        <button v-if="user_to.me == false" class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="acceptFriend">Aceptar Solicitud</button>
                        <button v-if="user_to.me == false" class="bg-warning-900 hocer:bg-warning-500 text-white font-bold py-2 px-4 rounded" @click="rejectFriend">Rechazar Solicitud</button>
                        <button class="bg-warning-900 hocer:bg-warning-500 text-white font-bold py-2 px-4 rounded" @click="blockUser">Bloquear</button>
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="exit">Salir</button>
                    </div>
                </div>
                <div v-else>
                    <div v-if="user_to.block_me" class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full">
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="unblock">Desbloquear</button>
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="exit">Salir</button>
                    </div>
                    <div v-else-if="user_to.block_for" class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full">
                        <p class="text-center text-2xl font-bold py-2 px-4">No tienes acciones permitidas</p>
                        <button class="bg-first-900 hocer:bg-first-500 text-white font-bold py-2 px-4 rounded" @click="exit">Salir</button>
                    </div>
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
                
            }
        },
        methods: {
            exit() {
                this.$root.$emit('close_profile', 'profile');
                this.note = '';
            },
            addFriend() {
                Promise.resolve(queries('POST', '/requests', {
                    user_id: this.user_by.id,
                    friend_id: this.user_to.id
                })).then(res => {
                    console.log('Solicitud enviada');
                    socketio.emit('request', this.user_by);
                    this.$root.$emit('close_action', {
                        action: 'add_friend',
                        user_id: this.user_to.id
                    });
                });
            },
            delFriend() {
                Promise.resolve(queries('post', '/friends/delete', {
                    user_id: this.user_by.id,
                    friend_id: this.user_to.id
                })).then(res => {
                    console.log('Amigo eliminado');
                    this.$root.$emit('close_action', {
                        action: 'del_friend',
                        user_id: this.user_to.id
                    });
                });
                console.log('delFriend');
            },
            acceptFriend() {
                Promise.resolve(queries('POST', '/friends', {
                    user_id: this.user_by.id,
                    friend_id: this.user_to.id
                })).then(res => {
                    console.log('Solicitud aceptada');
                    socketio.emit('accept', this.user_by);
                    this.$root.$emit('close_action', {
                        action: 'accept_friend',
                        user_id: this.user_to.id
                    });
                });
            },
            rejectFriend() {
                this.user_to.for = 'friend';
                Promise.resolve(queries('DELETE', '/requests/reject/', this.user_to))
                .then(res => {
                    console.log('Solicitud rechazada');
                    this.$root.$emit('close_action', {
                        action: 'reject_friend',
                        user_id: this.user_to.id
                    });
                });
            },
            cancelFriend() {
                this.user_to.for = 'sent';
                Promise.resolve(queries('DELETE', '/requests/cancel/', this.user_to))
                .then(res => {
                    console.log('Solicitud cancelada');
                    this.$root.$emit('close_action', {
                        action: 'cancel_friend',
                        user_id: this.user_to.id
                    });
                });
            },
            blockUser() {
                Promise.resolve(queries('POST', '/blocks', {
                    user_id: this.user_by.id,
                    blocked_id: this.user_to.id
                })).then(res => {
                    console.log('Usuario bloqueado');
                    this.$root.$emit('close_action', {
                        action: 'block_user',
                        user_id: this.user_to.id
                    });
                });
            },
            unblock() {
                Promise.resolve(queries('DELETE', '/blocks/cancel', {
                    user_id: this.user_by.id,
                    blocked_id: this.user_to.id
                })).then(res => {
                    console.log('Usuario desbloqueado');
                    this.$root.$emit('close_action', {
                        action: 'unblock_user',
                        user_id: this.user_to.id
                    });
                });
            },
            goChat() {
                this.$root.$emit('go_chat', this.user_to);
            }
        },
        mounted() {
            // this.note = JSON.parse(JSON.stringify(this.get));
        },
    }
</script>