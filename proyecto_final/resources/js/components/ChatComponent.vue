<template>
    <div>
        <div class="grid gap-4 w-2/3 mx-auto bg-second-50 rounded-lg shadow-lg">
            <div class="flex flex-row justify-center items-center w-full">
                <div class="bg-first-900 rounded-lg shadow-lg flex flex-row flex-wrap justify-between items-center w-full">
                    <p class="text-center text-white text-2xl font-bold py-2 px-4">{{friend.name}}</p>
                    <!-- Imagen en miniatura -->
                    <img :src="friend.avatar" alt="" class="w-24 h-24 rounded-full">
                    <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-full mr-4" @click="openNav('notes')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full p-3 flex flex-col space-y-4 max-h-full overflow-y-auto relative" style="height: calc(100vh - 200px);" ref="chat">
                <div v-for="msg in chat" class="bg-second-900 hover:bg-second-500 text-black font-bold py-2 px-4 self-start rounded-lg w-1/2" :key="msg._id" :class="{'self-end': msg.by == user.id}">
                    <span>{{msg.msg}}</span>
                </div>
            </div>

            <div class="bg-first-900 rounded-lg shadow-lg grid grid-cols-5 gap-2 w-full justify-left sticky inset-x-0 bottom-0 p-1">
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
        data() {
            return {
                chat: [],
                msg: '',
                ids: [],
            }
        },
        methods: {
            openWindow(window) {
                this.windows[window].open = true;
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
            }
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
