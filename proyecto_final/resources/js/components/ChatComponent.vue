<template>
    <div>
        <notify v-if="openNotify" :mensaje="mensaje" :emmiter="emiter"></notify>
        <confirm v-if="openConfirm" :mensaje="mensaje" :emmiter="emiter"></confirm>
        <div class="grid gap-4 w-2/3 mx-auto bg-second-50 rounded-lg shadow-lg">
            <div class="flex flex-row justify-center items-center w-full">
                <div class="bg-first-900 rounded-lg shadow-lg flex flex-row flex-wrap justify-between items-center w-full">
                    <div class="flex flex-row justify-right items-center" @click="hideMenu()">
                        <img :src="friend.avatar" alt="" class="w-24 h-24 rounded-full">
                        <p class="text-center text-white text-2xl font-bold py-2 px-4">{{friend.name}}</p>
                    </div>
                    <div class="flex flex-row justify-left items-center">
                        <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-full mr-4" @click="showMenu()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                            </svg>
                        </button>
                        <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-full mr-4" @click="closeNav('notes')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="white" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="absolute flex flex-col justify-between items-center py-6 bg-third-50 rounded-lg z-10" v-if="show == true" style="right: 20%; top: 18%;">
                        <span class="w-full px-6 py-2 hover:bg-third-900" @click="notifyRemove()">Eliminar</span>
                        <span class="w-full px-6 py-2 hover:bg-third-900" @click="notifyBlock()">Bloquear</span>
                    </div>
                </div>
            </div>

            <div class="w-full p-3 flex flex-col space-y-4 max-h-full overflow-y-auto relative" style="height: calc(100vh - 200px);" ref="chat" @click="hideMenu()">
                <div v-for="msg in chat" class="bg-second-900 hover:bg-second-500 text-black font-bold py-2 px-4 self-start rounded-lg w-1/2" :key="msg._id" :class="{'self-end': msg.by == user.id}">
                    <span>{{msg.msg}}</span>
                </div>
            </div>

            <div class="bg-first-900 rounded-lg shadow-lg grid grid-cols-5 gap-2 w-full justify-left sticky inset-x-0 bottom-0 p-1" @click="hideMenu()">
                <input type="text" v-model="msg" @keyup.enter="sendMsg" class="col-span-4 p-2 bg-second-900 hover:bg-second-500 text-black font-bold rounded-lg" placeholder="Escribe un mensaje">
                <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-full h-auto rounded-full mr-4 col-start-5" @click="sendMsg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import notify from './emergents/Accept.vue';
    import confirm from './emergents/Confirm.vue';

    export default {
        props: {
            user: {
                type: Object,
                required: false
            },
            friend: {
                type: Object,
                required: false
            }
        },
        components: {
            notify,
            confirm
        },
        data() {
            return {
                chat: [],
                msg: '',
                ids: [],
                show: false,
                mensaje: '',
                emiter: '',
                openNotify: false,
                openConfirm: false
            }
        },
        methods: {
            showMenu() {
                this.show = true;
            },
            hideMenu() {
                this.show = false;
            },
            closeNav(window) {
                openNav(window);
            },
            sendMsg() {
                if (this.msg.length > 0) {
                    socketio.emit('sendMsg', {
                        msg: this.msg,
                        name: this.user.name,
                        by: this.user.id,
                        to: this.friend.id,
                        date: new Date(),
                        icon: this.user.avatar
                    });
                    this.chat.push({
                        msg: this.msg,
                        by: this.user.id,
                        to: this.friend.id,
                        date: new Date()
                    });
                    this.msg = '';
                }
            },
            getMsg() {
                this.ids = [this.user.id, this.friend.id].sort((a, b) => a - b);
                console.log(this.ids, `${this.ids.join('_')}Chat`);
                socketio.emit('chats', {
                    ids: this.ids
                });
                socketio.on(`${this.ids.join('_')}Chat`, (data) => {
                    this.chat = data;
                });
            },
            notifyRemove() {
                this.emiter = 'remove';
                this.openNotify = true;
                this.mensaje = '¿Estás seguro de eliminar a ' + this.friend.name + ' de tu lista de amigos?';

                this.$root.$on('remove', (data) => {
                    if (data) {
                        if (data[0]) {
                            Promise.resolve(queries('post', '/friends/delete', {
                                user_id: this.user.id,
                                friend_id: this.friend.id
                            })).then(response => {
                                this.openNotify = false;
                                this.emiter = 'confirm';
                                this.mensaje = `¡${this.friend.name} y tu ya no son amigos`;
                                this.openConfirm = true;

                                this.$root.$on('confirm', (res) => {
                                    if (res) {
                                        this.closeNav('profiles');
                                    }
                                });
                                this.$forceUpdate();
                            });
                        } else {
                            this.openNotify = false;
                            this.emiter = '';
                            this.mensaje = '';
                        }
                    } else {
                        this.openNotify = false;
                        this.emiter = '';
                        this.mensaje = '';
                    }
                });
            },
            notifyBlock() {
                this.emiter = 'block';
                this.openNotify = true;
                this.mensaje = '¿Estás seguro de bloquear a ' + this.friend.name + '?';

                this.$root.$on('block', (data) => {
                    if (data) {
                        if (data[0]) {
                            Promise.resolve(queries('POST', '/blocks', {
                                user_id: this.user.id,
                                blocked_id: this.friend.id
                            })).then(data => {
                                Promise.resolve(queries('post', '/friends/delete', {
                                user_id: this.user.id,
                                friend_id: this.friend.id
                                })).then(res => {
                                    this.openNotify = false;
                                    this.emiter = 'confirm';
                                    this.mensaje = `¡${this.friend.name} ha sido bloqueado!`;
                                    this.openConfirm = true;

                                    this.$root.$on('confirm', (data) => {
                                        if (data) {
                                            this.closeNav('profiles');
                                        }
                                    });
                                });
                                this.$forceUpdate();
                            });
                        } else {
                            this.openNotify = false;
                            this.emiter = '';
                            this.mensaje = '';
                        }
                    } else {
                        this.openNotify = false;
                        this.emiter = '';
                        this.mensaje = '';
                    }
                });
            },
        },
        mounted() {
            this.getMsg();

            socketio.on(`${this.friend.id}${this.user.id}Chan`, (data) => {
                console.log(data);
                this.chat = this.chat.concat(data);
            });
        },
        watch: {
            chat: {
                handler(newVal, oldVal) {
                    this.$nextTick(() => {
                        this.$refs.chat.scrollTop = this.$refs.chat.scrollHeight;
                    });
                },
                deep: true
            }
        }
    }
</script>
