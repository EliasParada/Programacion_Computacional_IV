<template>
    <div class="w-full h-full flex justify-center items-center absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-1/3 absolute flex flex-col justify-center items-center rounded-lg shadow-lg p-4">
            <form class="bg-gray-200 rounded-lg shadow-lg flex flex-col w-full" @submit.prevent="addNote">
                <div class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-full">
                    <p v-if="note == ''" class="text-center text-2xl font-bold py-2 px-4">Agregar nota</p>
                    <p v-else class="text-center text-2xl font-bold py-2 px-4">Mostrar nota</p>
                </div>
                <div class="bg-gray-200 rounded-lg shadow-lg flex flex-col w-full">
                    <textarea class="w-full h-64 p-3" v-model="note" :disabled="get != ''"></textarea>
                </div>
                <div v-if="get == ''" class="bg-gray-200 rounded-lg shadow-lg flex justify-between items-center w-full">
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" type="submit">Agregar</button>
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="cancelNote">Cancelar</button>
                </div>
                <div v-else class="bg-gray-200 rounded-lg shadow-lg flex justify-between items-center w-full">
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="cancelNote">Salir</button>
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
            }
        },
        methods: {
            addNote() {
                this.$root.$emit('note', this.note);
                this.note = '';
            },
            cancelNote() {
                this.$root.$emit('close', 'notes');
                this.note = '';
            }
        },
        mounted() {
            this.note = JSON.parse(JSON.stringify(this.get));
        },
    }
</script>