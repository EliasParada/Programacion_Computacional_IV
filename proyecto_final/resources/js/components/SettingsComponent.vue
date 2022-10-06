<template>
    <div>
        <notify v-if="open" :mensaje="mensaje" :emmiter="'del_account'"></notify>
        <passcomp v-if="openpass" :mensaje="'Ingresa tu contraseña'" :emmiter="'del_account'"></passcomp>
        <div class="grid w-2/3 mx-auto bg-second-50 rounded-lg shadow-lg">
            <div class="flex flex-row justify-center items-center w-full">
                <div class="bg-first-900 rounded-lg shadow-lg flex flex-row flex-wrap justify-between items-center w-full">
                    <p class="text-center text-white text-2xl font-bold py-2 px-4">Ajustes</p>
                    
                <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-full h-auto rounded-full mr-4 col-start-5" @click="sendMsg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
                </div>
            </div>

            <div class="w-full flex flex-col space-y-4 max-h-full overflow-y-auto px-2" style="height: calc(100vh - 200px);">
                <section class="list-group">
                    <div class="list-group-item bg-first-50">
                        <span class="text-black">Mi cuenta</span>
                    </div>
                    <div class="list-group-item grid gap-4 grid-cols-3 px-2">
                        <div class="flex flex-col justify-center items-center col-span-1">
                            <span class="justify-center items-center relative block">
                                <img :src="user.avatar" alt="Avatar" class="w-4/5 h-lg rounded-lg mr-2">
                                <button class="bg-first-900 text-white text-2xl font-bold p-2 rounded-full shadow-lg absolute botom-0 right-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="flex flex-col justify-center items-center col-span-2 text-right col-start-2">
                            <span class="w-full flex flex-row justify-center items-center">
                                <input type="text" class="bg-transparent border-none text-black text-2xl font-bold py-2 px-4" v-model="user.name" placeholder="Nombre" :disabled="!edit">
                                <button class="bg-transparent border-none text-black text-2xl font-bold" @click="editName">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-transparent stroke-black" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </span>
                            <span class="w-full flex flex-row justify-left items-center">
                                <p class="text-black text-2xl font-bold py-2 px-4">{{user.email}}</p>
                            </span>
                            <span class="w-full flex flex-row justify-left items-center">
                                <p class="text-black text-2xl font-bold py-2 px-4">
                                    {{user.permissions === 1 ? 'Cibernauta' : 'Experto Altruista'}}
                                </p>
                            </span>
                            <span class="w-full flex flex-row justify-left items-center">
                                <form @submit.prevent="updateAccount" class="flex flex-col justify-center items-center py-2 px-4">
                                    <button class="bg-first-900 text-white text-2xl font-bold p-2 rounded-full shadow-lg">
                                        Guardar
                                    </button>
                                </form>
                            </span>
                        </div>
                    </div>
                </section>
                <section class="list-group">
                    <div class="list-group-item bg-first-50">
                        <span class="text-black">Experto Altruista</span>
                    </div>
                    <div class="list-group-item">
                        <span class="w-full flex flex-row justify-left items-center">
                            <form @submit.prevent="openExpert" class="flex flex-col justify-center items-center">
                                <button class="bg-first-900 text-white text-2xl font-bold p-2 rounded-lg shadow-lg" v-if="user.permissions === 1">
                                    ¿Qué es un Experto Altruista?
                                </button>
                                <p class="text-black text-2xl font-bold py-2 px-4" v-else>
                                    Ya eres un Experto Altruista
                                </p>
                            </form>
                        </span>
                    </div>
                </section>
                <section class="list-group">
                    <div class="list-group-item bg-first-50">
                        <span class="text-black">Eliminar Cuenta</span>
                    </div>
                    <div class="list-group-item">
                        <span class="w-full flex flex-row justify-left items-center">
                            <form @submit.prevent="deleteAccount" class="flex flex-col justify-center items-center">
                                <button class="bg-warning-900 text-white text-2xl font-bold p-2 rounded-lg shadow-lg">
                                    Eliminar
                                </button>
                            </form>
                        </span>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    import notify from './emergents/Accept.vue';
    import passcomp from './emergents/PassComp.vue';
    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        components: {
            notify,
            passcomp
        },
        data() {
            return {
                changes: {
                    name: '',
                    password: ''
                },
                edit: false,
                open: false,
                openpass: false,
                mensaje: '',
            }
        },
        methods: {
            changeName() {
                queries('PUT', '/users/' + this.user.id, this.changes).then(response => {
                    console.log(response);
                    window.location.reload();
                });
            },
            deleteAccount() {
                this.mensaje = '¿Estás seguro de que quieres eliminar tu cuenta?';
                this.openpass = true;

                this.$root.$on('del_account', (res) => {
                    if (res) {
                        queries('DELETE', '/users/' + this.user.id, {}).then(response => {
                            console.log(response);
                            window.location.reload();
                        });
                    } else {
                        this.openpass = false;
                    }
                });
            },
            closeNav() {
                openNav();
            },
            editName() {
                this.edit = !this.edit;
            },
            updateAccount() {
                queries('PUT', '/users/' + this.user.id, this.user).then(response => {
                    console.log(response);
                    window.location.reload();
                });
            },
            openExpert() {
                openNav('expert');
            },
        },
    }
</script>
