<template>
    <div class="w-full h-full flex justify-center items-center fixed z-50" style="top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(30, 30, 30, .8)">
        <div class="w-2/3 fixed flex flex-col justify-center items-center rounded-lg shadow-lg">
            <div class="bg-second-50 rounded-lg shadow-lg flex flex-col w-full">
                <div class="bg-second-50 rounded-lg shadow-lg flex flex-col w-full pb-2 py-4">
                    <div class="w-full flex flex-row justify-center items-center">
                        <span class="w-full flex flex-row justify-center items-center">
                            <p class="text-black text-lg font-bold py-2 px-4">
                                {{mensaje}}
                            </p>
                        </span>
                        <button @click="close" class="bg-transparent text-black text-2xl font-bold p-2 rounded-full shadow-lg">
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                        </button>
                    </div>

                    <div class="w-full flex flex-row justify-end items-center">
                        <span class="w-full flex flex-row justify-end items-center pr-48">
                            <form @submit.prevent="close" class="flex flex-col justify-start items-center pl-6">
                                <button class="py-6 px-4 bg-first-900 hover:bg-first-500 text-white text-2xl font-bold p-2 rounded-full shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </button>
                            </form>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['mensaje', 'emmiter'],
        data() {
            return {
                response: null
                
            }
        },
        methods: {
            close() {
                this.$root.$emit(this.emmiter, [false]);
            },
        },
        mounted() {
        },
    }
</script>