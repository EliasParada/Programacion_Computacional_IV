<template>
    <div class="grid gap-4 w-1/2 mx-auto">
        <new-note v-bind:form="windows" ref="notes" v-if="windows['notes'].open" :get="note.content"></new-note>
        <login v-bind:form="windows" ref="login" v-if="windows['login'].open"></login>
        <div class="flex flex-row justify-center items-center w-full">
            <div class="bg-gray-200 rounded-lg shadow-lg flex flex-wrap justify-center items-center">
                <p class="text-center text-2xl font-bold py-2 px-4">Notas</p>
                <a href="#" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="openWindow('notes')">Agregar</a>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="bg-gray-200 rounded-lg shadow-lg flex flex-row w-full">
                <div class="w-full p-3 flex flex-col space-y-4">
                    <div v-for="note in notes" class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-26" :key="note.created_at">
                        {{note.content.substring(0, 150)}}<span v-if="note.content.length > 30">...</span>
                        <a href="#" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="openNote(note)">Abrir</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-200 rounded-lg shadow-lg flex justify-between items-center">
            <p class="text-center text-2xl font-bold py-2 px-4">Agregar</p>
            <a href="#" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Agregar</a>
        </div>
    </div>
</template>

<script>
    import newNote from './emergents/NewNote.vue';
    import login from './emergents/Login.vue';
    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                isAuthenticated: false,
                notes: [],
                windows: {
                    notes: {open: false},
                    login: {open: false}
                },
                note: {
                    user_id: '',
                    content: '',
                    multimedia: null
                }
            }
        },
        methods: {
            openWindow(window) {
                if ((!this.isAuthenticated) && this.notes.length >= 1) {
                    this.windows.notes.open = false;
                    this.windows.login.open = true;
                } else {
                    this.windows[window].open = !this.windows[window].open;
                }
            },
            addNote(note) {
                this.notes.push(note);
            },
            openNote(note) {
                this.note.content = note.content
                this.openWindow('notes');
            },
            obtenerNotas() {
                Promise.resolve(queries('GET', '/notes'))
                .then(response => {
                    this.notes = response;
                });
            }
        },
        mounted() {
            if (this.user) {
                this.isAuthenticated = true;
                this.note.user_id = this.user.id;
                this.obtenerNotas();
            } else {
                console.log('no user');
                this.isAuthenticated = false;
                let notes = JSON.parse(localStorage.getItem('notes'));
                if (!(!notes || notes.length == 0 || notes == '')) {
                    this.notes = notes;
                }
            }
        },
        components: {
            'new-note': newNote,
            'login': login
        },
        beforeMount() {
            this.$root.$on('note', (value) => {
                this.note.content = value;
                this.openWindow('notes');
                if (this.isAuthenticated) {
                    Promise.resolve(queries('POST', '/notes', this.note))
                    .then(response => {
                        this.obtenerNotas();
                    });
                } else {
                    this.notes.push(this.note);
                    localStorage.setItem('notes', JSON.stringify(this.notes));
                }
                this.note.content = '';
            });
            this.$root.$on('close', (value) => {
                this.windows[value].open = false;
                this.note.content = '';
            });
        },
    }
</script>
