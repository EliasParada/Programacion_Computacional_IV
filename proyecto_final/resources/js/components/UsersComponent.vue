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
            filterFind(objres, obj, key = 'friend_id', one = false) {
                if (objres)
                if (!one) {
                    if (key == 'friend_id') {
                        if (objres.find(objfind => objfind.user_id == obj.id || objfind[key] == obj.id))
                        return true;
                    } else {
                        if (objres.find(objfind => objfind.user_id == obj[0].id && objfind[key] == obj[1].id))
                        return true;
                    }
                } else {
                    if (objres.find(objfind => objfind.user_id == obj.id))
                    return true;
                }
                return false;
            },
            getUsers() {
                const users = Promise.resolve(queries('GET', '/users'));
                users.then(response => {
                    this.users = response;
                    this.users = this.users.filter(user => user.id != this.user.id);
                    const friends = Promise.resolve(queries('GET', '/friends'));
                    friends.then(resfriends => {
                        this.users = this.users.map(user => {
                            user.friend = this.filterFind(resfriends, user);
                            return user;
                        });
                        this.friends = resfriends.map(friend => {
                            if (friend.user_id == this.user.id) {
                                return friend.friend_id;
                            } else {
                                return friend.user_id;
                            }
                        });
                        socketio.emit('getFriendsMsg', {
                            friends: this.friends,
                            user: this.user.id
                        });
                        socketio.on('setFriendsMsg', data => {
                            console.log(data, data[0]);
                            this.users.map(user => {
                                let datatemp = data[0];
                                if (datatemp.to == user.id || datatemp.by == user.id) {
                                    user.msg = datatemp.msg;
                                }
                            });
                        });
                    });
                    const requests = Promise.resolve(queries('GET', '/requests'));
                    requests.then(resrrequests => {
                        this.users = this.users.map(user => {
                            user.request = this.filterFind(resrrequests, user, 'friend_id');
                            user.me = this.filterFind(resrrequests, this.user, '', true);
                            return user;
                        });
                    });
                    const blocks = Promise.resolve(queries('GET', '/blocks'));
                    blocks.then(resrblocks => {
                        console.log('bloqueados',resrblocks);
                        this.users = this.users.map(user => {
                            user.block_me = this.filterFind(resrblocks, [this.user, user], 'block_id');
                            user.block_for = this.filterFind(resrblocks, [user, this.user], 'block_id');
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