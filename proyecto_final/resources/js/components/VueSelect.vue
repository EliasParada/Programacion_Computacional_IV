<template>
    <div>
        <notify v-if="openNotify" :mensaje="mensaje" :emmiter="emiter"></notify>
        <confirm v-if="openConfirm" :mensaje="mensaje" :emmiter="emiter"></confirm>
        <input type="text" v-model="search" class="form-control" placeholder="Buscar..." @keyup="searchResource" @click="hideMenu()">
        <section class="list-group">
            <div class="list-group-item bg-first-50" @click="hideMenu()">
                <span class="text-muted">Amigos</span>
            </div>
            <div v-if="(options.filter(option => option.show == true).length <= 0 && options.filter(option => option.friend == true).length >= 1) || (options.filter(option => option.friend == true).length == 0)" class="list-group-item bg-first-50" @click="hideMenu()">
                <span class="text-muted">No hay amigos</span>
            </div>
            <div v-else v-for="option in options" class="list-group-item flex items-center justify-between" :key="option[llave]" v-show="option.show == true && option.friend == true">
                <div class="flex items-center justify-start w-full transition-all duration-300" @click="selectResource(option)">
                    <span v-for="key in keys" :key="key.value">
                        <span v-if="key.type == 'txt'">{{option[key.value]}}</span>
                        <span v-if="key.type == 'img'">
                            <img :src="option[key.value]" :alt="option[key.value]" class="w-16 h-16 rounded-full mr-2">
                        </span>
                        <span v-if="key.type == 'url'">
                            <a :href="option[key.value]" target="_blank">{{option[key.value]}}</a>
                        </span>
                    </span>
                    <span>
                        <span class="ml-6 p-2">{{option.msg}}</span>
                    </span>
                </div>
                <button type="button" class="flex items-center justify-end bg-transparent hover:bg-third-900 font-bold w-8 h-8 rounded-full mr-4" @click="showMenu(option)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                    </svg>
                </button>
                <div class="absolute flex flex-col justify-between items-center py-6 bg-third-50 rounded-lg z-10" v-if="show == true && option[llave] == idmenu" style="right: 10px; top: 10px;">
                    <span class="w-full px-6 py-2 hover:bg-third-900" @click="notifyRemove(option)">Eliminar amigo</span>
                    <span class="w-full px-6 py-2 hover:bg-third-900" @click="notifyBlock(option)">Bloquear</span>
                </div>
            </div>
        </section>
        <section class="list-group mt-4" @click="hideMenu()">
            <div class="list-group-item bg-first-50">
                <span class="text-muted">Usuarios globales</span>
            </div>
            <div v-if="(options.filter(option => option.show == true).length <= 0 && options.filter(option => option.friend == false).length >= 1) || (options.filter(option => option.friend == false).length == 0)" class="list-group-item bg-first-50">
                <span class="text-muted">No hay usuarios</span>
            </div>
            <div v-else v-for="option in options" class="list-group-item flex items-center justify-between" :key="option[llave]" v-show="option.show == true && option.friend == false">
                <div class="flex items-center justify-start w-full transition-all duration-300">
                    <span v-for="key in keys" :key="key.value">
                        <span v-if="key.type == 'txt'">{{option[key.value]}}</span>
                        <span v-if="key.type == 'img'">
                            <img :src="option[key.value]" :alt="option[key.value]" class="w-16 h-16 rounded-full mr-2">
                        </span>
                        <span v-if="key.type == 'url'">
                            <a :href="option[key.value]" target="_blank">{{option[key.value]}}</a>
                        </span>
                    </span>
                </div>
                <button type="button" class="flex items-center justify-end bg-first-900 font-bold h-auto w-fit rounded-lg mr-4 text-white" @click="addFriend(option)" v-if="option.friend == false && option.block_for == false && option.block_me == false">
                    Enviar solicitud
                </button>
                <button type="button" class="flex items-center justify-end bg-first-900 font-bold h-auto w-fit rounded-lg mr-4 text-white" @click="notifyBlock(option)" v-if="option.friend == false && option.block_me == false && option.block_for == false">
                    Bloquear usuario
                </button>
                <button type="button" class="flex items-center justify-end bg-first-900 font-bold h-auto w-fit rounded-lg mr-4 text-white" @click="notifyUnblock(option)" v-if="option.block_me">
                    Desbloquear usuario
                </button>
            </div>
        </section>
    </div>
</template>

<script>
import notify from './emergents/Accept.vue';
import confirm from './emergents/Confirm.vue';
import { optionalCallExpression } from '@babel/types';

export default {
    props: {
        options: {
            type: Array,
            required: true
        },
        llave: {
            type: String,
            required: true
        },
        value: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: true
        },
        by: {
            type: String,
            required: true
        },
        userby: {
            type: Object,
            required: true
        },
    },
    components: {
        notify,
        confirm
    },
    data() {
        return {
            search: '',
            keys: this.configLabel(this.label),
            keys_by: this.configLabel(this.by),
            idmenu: '',
            show: false,
            mensaje: '',
            emiter: '',
            openNotify: false,
            openConfirm: false,
        }
    },
    methods: {
        addFriend(to) {
            Promise.resolve(queries('POST', '/requests', {
                user_id: this.userby.id,
                friend_id: to.id
            })).then(res => {
                console.log('Solicitud enviada');
                socketio.emit('request', {
                    by: this.userby,
                    to: to
                });
            });
        },
        notifyRemove(to) {
            this.emiter = 'remove';
            this.openNotify = true;
            this.mensaje = '¿Estás seguro de eliminar a ' + to.name + ' de tu lista de amigos?';

            this.$root.$on('remove', (data) => {
                if (data) {
                    if (data[0]) {
                        if (to.friend) {
                            Promise.resolve(queries('post', '/friends/delete', {
                                user_id: this.userby.id,
                                friend_id: to.id
                            })).then(res => {
                                console.log('Amigo eliminado');
                            });
                        }
                        this.$root.$on('confirm', (data) => {
                            if (data) {
                                this.openConfirm = false;
                            }
                        });
                        this.$forceUpdate();
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
        notifyBlock(to) {
            this.emiter = 'block';
            this.openNotify = true;
            this.mensaje = '¿Estás seguro de bloquear a ' + to.name + '?';

            this.$root.$on('block', (data) => {
                if (data) {
                    if (data[0]) {
                        Promise.resolve(queries('POST', '/blocks', {
                            user_id: this.userby.id,
                            blocked_id: to.id
                        })).then(res => {
                            Promise.resolve(queries('post', '/friends/delete', {
                                user_id: this.userby.id,
                                friend_id: to.id
                            })).then(res => {
                                to.friend = false;
                                this.openNotify = false;
                                this.emiter = 'confirm';
                                this.mensaje = `${to.name} ha sido bloqueado`;
                                this.openConfirm = true;

                                this.$root.$on('confirm', (data) => {
                                    if (data) {
                                        this.openConfirm = false;
                                    }
                                });
                                this.$forceUpdate();
                            });
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
        notifyUnblock(to) {
            this.emiter = 'confirm';
            this.openConfirm = true;
            this.mensaje = `${to.name} ha sido desbloqueado`;

            this.$root.$on('confirm', (data) => {
                if (data) {
                    Promise.resolve(queries('DELETE', '/blocks/cancel', {
                        user_id: this.userby.id,
                        blocked_id: to.id
                    })).then(res => {
                        this.openConfirm = false;
                        to.block_me = false;

                        this.$forceUpdate();
                    });
                } else {
                    this.openConfirm = false;
                    this.emiter = '';
                    this.mensaje = '';
                }
            });
        },
        showMenu(option) {
            this.idmenu = option.id;
            this.show = true;
            console.log(option, this.idmenu, this.show);
        },
        hideMenu() {
            this.idmenu = '';
            this.show = false;
        },
        configLabel(label) {
            let newLabel = [];
            if (label.includes(',')) {
                newLabel = label.split(',');
                newLabel = newLabel.map(item => {
                    return item = this.setResourse(item);
                });
                return newLabel;
            } else if (label.includes('*')) {
                newLabel = this.options.map(item, key => {
                    return item = {
                        type: 'txt',
                        value: item[Object.keys(item)[key]],
                    }
                });
                return newLabel;
            } else {
                newLabel = [this.setResourse(label)];
                return newLabel;
            }
        },
        setResourse(item) {
            item = item.trim();
            if (item.includes('img:') || item.includes('url:')) {
                let newItem = item.split(':');
                if (newItem[0] === 'img') {
                    item = {
                        type: 'img',
                        value: newItem[1]
                    }
                } else if (newItem[0] === 'url') {
                    item = {
                        type: 'url',
                        value: newItem[1]
                    }
                } else {
                    item = {
                        type: 'txt',
                        value: item
                    }
                }
            } else {
                item = {
                    type: 'txt',
                    value: item
                }
            }
            return item;
        },
        searchResource() {
            if (this.search.length > 0) {
                this.options.forEach(item => {
                    item.show = false;
                });
                this.options.filter(item => {
                    let newItem = this.keys_by.map(key => {
                        return item[key.value];
                    }); 
                    newItem = newItem.join(' ');
                    return newItem.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
                }).forEach(item => {
                    item.show = true;
                });
            } else {
                this.options.forEach(item => {
                    item.show = true;
                });
            }
            this.$forceUpdate();
        },
        selectResource(item) {
            this.$root.$emit('go_chat', item);
        },
    },
    mounted() {
        console.log(this.userby);
        this.options.forEach(item => {
            item.show = true;
        });
    },
    watch: {
        options: (newOptions) => {
            newOptions.forEach(item => {
                item.show = true;
            });
        },
    },
}
</script>