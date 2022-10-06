<template>
    <div class="container mx-auto bg-second-50 p-2 rounded-lg">
        <vue-select :options="users" :llave="'id'" :label="'img:avatar,name'" :value="'x'" :by="'name'" :userby="user"></vue-select>
        <profiles :user_by="user" :user_to="user_target" v-if="show_profiles"></profiles>
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
                show_profiles: false,
                friends: [],
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
                            user.friend = false;
                            user.friend = response.find(friend => friend.user_id == user.id || friend.friend_id == user.id) ? true : false;
                            return user;
                        });
                        this.friends = response.map(friend => friend.user_id == this.user.id ? friend.friend_id : friend.user_id);
                        socketio.emit('getFriendsMsg', {
                            friends: this.friends,
                            user: this.user.id
                        });
                        socketio.on('setFriendsMsg', data => {
                            console.log(data, data[0]);
                            this.users.map(user => {
                                if (data[0].to == user.id || data[0].by == user.id) {
                                    user.msg = data[0].msg;
                                }
                            });
                        });
                    });
                    const requests = Promise.resolve(queries('GET', '/requests'));
                    requests.then(response => {
                        this.users = this.users.map(user => {
                            user.request = false;
                            user.me = false;
                            user.request = response.find(request => request.user_id == user.id || request.friend_id == user.id) ? true : false;
                            user.me = response.find(request => request.user_id == this.user.id) ? true : false;
                            return user;
                        });
                    });
                    const blocks = Promise.resolve(queries('GET', '/blocks'));
                    blocks.then(response => {
                        console.log('bloqueados',response);
                        this.users = this.users.map(user => {
                            user.block_me = false;
                            user.block_for = false;
                            user.block_me = response.find(block => block.user_id == this.user.id && block.block_id == user.id) ? true : false;
                            user.block_for = response.find(block => block.user_id == user.id && block.block_id == this.user.id) ? true : false;
                            return user;
                        });
                    });
                });
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
                console.log(newValue);
            }
        },
        beforeMount() {
            this.$root.$on('goProfile', (value) => {
                this.user_target = value;
                this.show_profiles = true;
            });
            this.$root.$on('close_profile', () => {
                this.show_profiles = false;
            });
            this.$root.$on('close_action', (values) => {
                switch (values.action) {
                    case 'add_friend':
                        this.users.find(user => user.id == values.user_id).me = true;
                        break;
                    case 'accept_friend':
                        this.users.find(user => user.id == this.user_target.user_id).friend = true;
                        break;
                    case 'reject_friend':
                        this.users.find(user => user.id == this.user_target.user_id).request = false;
                        break;
                    case 'cancel_request':
                        this.users.find(user => user.id == this.user_target.user_id).me = false;
                        break;
                    case 'block_user':
                        this.users.find(user => user.id == this.user_target.user_id).block_me = true;
                        break;
                    case 'unblock_user':
                        this.users.find(user => user.id == this.user_target.user_id).block_me = false;
                        break;
                    default:
                        break;
                }
                this.show_profiles = false;
                this.$forceUpdate();
            });
        }
    }
</script>