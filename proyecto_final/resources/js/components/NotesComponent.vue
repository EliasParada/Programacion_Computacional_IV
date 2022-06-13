<template>
    <div>
        <new-note v-bind:form="windows" ref="new_notes" v-if="windows['new_notes'].open" :get="note.content"></new-note>
        <div class="grid gap-4 w-2/3 mx-auto bg-second-50 rounded-lg shadow-lg">
            <login v-bind:form="windows" ref="login_message" v-if="windows['login_message'].open"></login>
            <div class="flex flex-row justify-center items-center w-full">
                <div class="bg-first-900 rounded-lg shadow-lg flex flex-row flex-wrap justify-between items-center w-full">
                    <p class="text-center text-white text-2xl font-bold py-2 px-4">Notas</p>
                    <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-full mr-4" @click="openWindow('new_notes')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full p-3 flex flex-col space-y-4 max-h-full overflow-y-auto" style="height: calc(100vh - 200px);">
                <div v-for="note in notes" class="bg-second-900 hover:bg-second-500 text-black font-bold py-2 px-4 rounded-lg self-end w-1/2" :key="note.id">
                    <span>{{note.content.substring(0, 150)}}<span v-if="note.content.length > 150">...</span></span>
                    <a href="#" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-lg mr-4 p-1" @click="openNote(note)">Abrir</a>
                </div>
            </div>
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
                    new_notes: {open: false},
                    login_message: {open: false}
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
                    this.windows.new_notes.open = false;
                    this.windows.login_message.open = true;
                } else {
                    this.windows[window].open = !this.windows[window].open;
                }
            },
            addNote(note) {
                this.notes.push(note);
            },
            openNote(note) {
                this.note.content = note.content
                this.openWindow('new_notes');
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
                if (localStorage.getItem('notes')) {
                    localStorage.removeItem('notes');
                }
            } else {
                console.log('no user');
                this.isAuthenticated = false;
                let notes = JSON.parse(localStorage.getItem('notes'));
                if (!(!notes || notes.length == 0 || notes == '')) {
                    this.notes = notes;
                } else {
                    this.notes = [];
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
                this.openWindow('new_notes');
                if (this.isAuthenticated) {
                    Promise.resolve(queries('POST', '/notes', this.note))
                    .then(response => {
                        this.obtenerNotas();
                    });
                } else {
                    this.notes.push({
                        user_id: '',
                        content: this.note.content,
                        multimedia: '',
                    });
                    localStorage.setItem('notes', JSON.stringify(this.notes));
                }
                this.note.content = '';
            });
            this.$root.$on('close_note', (value) => {
                console.log(value);
                this.windows[value].open = false;
                this.note.content = '';
            });
        },
    }
</script>
