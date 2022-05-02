<template>
    <div class="w-full h-full flex flex-wrap w-1/2 fixed overflow-auto items-center" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="w-full bg-second-500 absolute rounded-lg">
            <div class="bg-first-900 rounded-lg shadow-lg flex justify-between p-2">
                <p class="text-center text-white text-2xl font-bold py-2 px-4">Registrate para continuar</p>
                <button type="button" @click="close()" class="bg-first-900 text-white rounded-full hover:bg-first-500 h-8 w-8 ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="bg-second-50 rounded-lg shadow-lg p-4 flex flex-row justify-between">
                <div class="bg-transparent flex flex-wrap w-full justify-center items-center rounded-lg space-x-2">
                    <p class="bg-first-900 py-4 hover:bg-first-500 text-white font-bold rounded-lg">
                        <a href="/login" class="text-white font-bold py-2 px-4 self-end w-full">Ingresar</a>
                    </p>
                    <p class="bg-first-900 py-4 hover:bg-first-500 text-white font-bold rounded-lg">
                        <a href="/register" class="text-white font-bold py-2 px-4 self-end w-full">Registrarme</a>
                    </p>
                </div>
            </div>
            <div class="bg-first-900 rounded-lg shadow-lg flex w-full justify-around">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            close() {
                this.$root.$emit('close', 'login_message')
            }
        },
        mounted() {
        },
    }
</script>