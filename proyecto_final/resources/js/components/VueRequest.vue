<template>
    <div>
        <section class="list-group mt-4">
            <div class="list-group-item bg-first-50">
                <span class="text-muted">Solicitudes</span>
            </div>
            <div v-if="(options.filter(option => option.show == true).length <= 0 && options.filter(option => option.request == true).length >= 1) && (options.filter(option => option.me == false).length == 0)" class="list-group-item bg-first-50">
                <span class="text-muted">No hay solicitudes</span>
            </div>
            <div v-else v-for="option in options" class="list-group-item flex items-center justify-between" :key="option[llave]" v-show="option.show == true && option.request == true">
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
                <div class="flex items-center justify-end">
                    <button type="button" class="py-4 px-6 bg-first-900 hover:bg-first-500 font-bold h-auto w-fit rounded-lg mr-4 text-white" @click="acceptFriend(option)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </button>
                    <button type="button" class="py-4 px-6 bg-gray-50 border-1 border-gray-400 hover:bg-gray-400 font-bold h-auto w-fit rounded-lg mr-4 text-black" @click="rejectFriend(option)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
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
    data() {
        return {
            search: '',
            keys: this.configLabel(this.label),
            keys_by: this.configLabel(this.by),
        }
    },
    methods: {
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
        acceptFriend(to) {
            Promise.resolve(queries('POST', '/friends', {
                user_id: this.userby.id,
                friend_id: to.id
            })).then(res => {
                console.log('Solicitud aceptada');
                changeRequest(-1);
                socketio.emit('accept', {
                    by: this.userby,
                    to: to,
                });
                this.options.forEach((item, key) => {
                    if (item.id == to.id) {
                        this.options.splice(key, 1);
                    }
                });
            });
        },
        rejectFriend(to) {
            to.for = 'friend';
            Promise.resolve(queries('DELETE', '/requests/reject/', to))
            .then(res => {
                changeRequest(-1);
                this.options.forEach((item, key) => {
                    if (item.id == to.id) {
                        this.options.splice(key, 1);
                    }
                });
            });
        },
        selectResource(item) {
            this.$root.$emit('goProfile', item);
            console.log(item);
        },
    },
    mounted() {
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