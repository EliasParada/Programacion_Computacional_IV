<template>
    <div class="container mx-auto">
        <!-- <div class="flex justify-center">
            <div class="w-full max-w-sm">
                <div class="flex flex-col break-words bg-white border-2 rounded shadow-md">
                    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                        <h1 class="text-xl font-bold">Perfil</h1>
                    </div>
                    <div class="w-full p-6">
                        <div v-for="profile in users" class="flex flex-col break-words bg-white border-2 rounded shadow-md" :key="profile.id">
                            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                                <h1 class="text-xl font-bold">{{profile.name}}</h1>
                            </div>
                            <div v-if="profile.id != user.id" class="flex flex-col break-words bg-white border-2 rounded shadow-md">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="sendRequest(profile.id)">Enviar Solicitud</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <vue-select :options="users" :llave="'id'" :label="'img:avatar,name'" :value="'x'" :by="'name'"></vue-select>
        <profiles :user_by="user" :user_to="user_target" v-if="show_profiles"></profiles>
        <!-- Solo crear el componente de profiles si show_profiles es true -->
        <!-- <profiles :user_by="user" :user_to="user_target" v-bind="show_profiles"></profiles> -->
    </div>
</template>

<script>
    import vueSelect from './VueSelect.vue';
    import profiles from './emergents/Profile.vue';
    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                users: [],
                user_target: {},
                show_profiles: false
            }
        },
        methods: {
            getUsers() {
                const users = Promise.resolve(queries('GET', '/users'));
                users.then(response => {
                    this.users = response;
                    this.users = this.users.filter(user => user.id != this.user.id);
                    const friends = Promise.resolve(queries('GET', '/friends'));
                    friends.then(response => {
                        this.users = this.users.map(user => {
                            user.friend = response.find(friend => friend.user_id == user.id || friend.friend_id == user.id) ? true : false;
                            return user;
                        });
                    });
                    const requests = Promise.resolve(queries('GET', '/requests'));
                    requests.then(response => {
                        this.users = this.users.map(user => {
                            user.request = response.find(request => request.user_id == user.id || request.friend_id == user.id) ? true : false;
                            user.me = response.find(request => request.user_id == this.user.id) ? true : false;
                            return user;
                        });
                    });
                });
            },
            sendRequest(id) {
                // const request = Promise.resolve(queries('POST', '/requests', {
                //     user_id: id,
                //     user_requested_id: this.user.id
                // }));
                // request.then(response => {
                //     console.log(response);
                // });
            },
        },
        components: {
            'vue-select': vueSelect,
            'profiles': profiles
        },
        mounted() {
            this.getUsers();
        },
        watch: {
            user_target(newValue) {
                // this.$emit('input', newValue);
                console.log(newValue);
            }
        },
        beforeMount() {
            this.$root.$on('goProfile', (value) => {
                this.user_target = value;
                this.show_profiles = true;
            });
            this.$root.$on('close', () => {
                this.show_profiles = false;
            });
        }
    }
</script>