<template>
    <div class="w-full h-full flex justify-center items-center fixed" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-1/2 absolute flex flex-col justify-center items-center rounded-lg shadow-lg">
            <form class="bg-second-50 rounded-lg shadow-lg flex flex-col w-full" @submit.prevent="addNote">
                <div class="bg-first-900 text-white font-bold py-2 px-4 rounded self-end w-full">
                    <p class="text-center text-2xl font-bold py-2 px-4">{{ title }}</p>
                </div>
                <div class="bg-second-50 rounded-lg shadow-lg flex flex-col w-full">
                    <!-- <textarea class="w-full h-64 p-3" v-model="note" :disabled="get != ''"></textarea> -->
                    <textarea class="w-full h-64 p-3 bg-second-50 rounded-lg shadow-lg text-black" v-model="note" :disabled="title !== 'Agregar nota'"></textarea>
                </div>
                <!-- Espacio en medio de 4 -->
                <div v-if="get == ''" class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full space-x-4">
                    <button class="bg-first-900 text-white font-bold py-2 px-4 rounded self-end w-full" type="submit">Agregar Nota</button>
                    <button class="bg-first-900 text-white font-bold py-2 px-4 rounded self-end w-full" @click="cancelNote">Salir</button>
                </div>
                <div v-else class="bg-second-50 rounded-lg shadow-lg flex justify-between items-center w-full space-x-4">
                    <button class="bg-first-900 text-white font-bold py-2 px-4 rounded self-end w-1/3" @click="cancelNote">Salir</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['get'],
        data() {
            return {
                note: '',
                title: '',
            }
        },
        methods: {
            addNote() {
                this.$root.$emit('note', this.note);
                this.note = '';
            },
            cancelNote() {
                this.$root.$emit('close', 'new_notes');
                this.note = '';
            }
        },
        mounted() {
            this.note = JSON.parse(JSON.stringify(this.get));
            if (this.get == '') {
                this.title = 'Agregar nota';
            } else {
                this.title = 'Mostrar nota';
            }
        },
    }
</script>