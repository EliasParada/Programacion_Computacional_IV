<template>
    <div class="w-full h-full flex justify-center items-center">
        <div class="w-1/3 absolute flex flex-col justify-center items-center rounded-lg shadow-lg p-4">
            <div class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-full">
                <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded" @click="$root.$emit('close', 'login')">Cerrar</button>
            </div>
            <div class="bg-gray-200 rounded-lg shadow-lg flex flex-col w-full">
                <a href="/login" class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-full">Login</a>
                <a href="/register" class="bg-blue-400 text-black font-bold py-2 px-4 rounded ring-1 ring-cyan-400 self-end w-full">Registro</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
    }
</script>