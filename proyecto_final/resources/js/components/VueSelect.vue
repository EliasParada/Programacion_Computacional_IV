<template>
    <div>
        <input type="text" v-model="search" class="form-control" placeholder="Buscar..." @keyup="searchResource">
        <section class="list-group">
            <div class="list-group-item">
                <span class="text-muted">Amigos</span>
            </div>
            <div v-if="(options.filter(option => option.show == true).length <= 0 && options.filter(option => option.friend == true).length >= 1) || (options.filter(option => option.friend == true).length == 0)" class="list-group-item">
                <span class="text-muted">No hay amigos</span>
            </div>
            <div v-else v-for="option in options" class="list-group-item hover:bg-gray-400 transition-all delay-500" :key="option[llave]" v-show="option.show == true && option.friend == true" @click="selectResource(option)">
                <span v-for="key in keys" :key="key.value">
                    <span v-if="key.type == 'txt'">{{option[key.value]}}</span>
                    <span v-if="key.type == 'img'">
                        <img :src="'storage/' + option[key.value]" :alt="option[key.value]" class="w-16 h-16 rounded-full mr-2">
                    </span>
                    <span v-if="key.type == 'url'">
                        <a :href="option[key.value]" target="_blank">{{option[key.value]}}</a>
                    </span>
                </span>
            </div>
        </section>
        <section class="list-group mt-4">
            <div class="list-group-item">
                <span class="text-muted">Usuarios globales</span>
            </div>
            <div v-if="(options.filter(option => option.show == true).length <= 0 && options.filter(option => option.friend == false).length >= 1) || (options.filter(option => option.friend == false).length == 0)" class="list-group-item">
                <span class="text-muted">No hay usuarios</span>
            </div>
            <div v-else v-for="option in options" class="list-group-item hover:bg-gray-400 transition-all delay-500" :key="option[llave]" v-show="option.show == true && option.friend == false" @click="selectResource(option)">
                <span v-for="key in keys" :key="key.value">
                    <span v-if="key.type == 'txt'">{{option[key.value]}}</span>
                    <span v-if="key.type == 'img'">
                        <img :src="'storage/' + option[key.value]" :alt="option[key.value]" class="w-16 h-16 rounded-full mr-2">
                    </span>
                    <span v-if="key.type == 'url'">
                        <a :href="option[key.value]" target="_blank">{{option[key.value]}}</a>
                    </span>
                </span>
            </div>
        </section>
        <button @click="console.log(options);">Purta</button>
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