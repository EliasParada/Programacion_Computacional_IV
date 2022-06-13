<template>
    <div>
        <div class="grid gap-4 w-2/3 mx-auto bg-second-50 rounded-lg shadow-lg">
            <div class="flex flex-row justify-center items-center w-full">
                <div class="bg-first-900 rounded-lg shadow-lg flex flex-row flex-wrap justify-between items-center w-full">
                    <p class="text-center text-white text-2xl font-bold py-2 px-4">¿Qué es un Experto Altruista?</p>
                    <!-- button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-full mr-4" @click="openWindow('new_news')" v-if="user && user.permissions == 2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button -->
                </div>
            </div>

            <div class="w-full p-3 flex flex-col space-y-4 max-h-full overflow-y-auto" style="height: calc(100vh - 200px);">
                <!-- Una sección con un boton para aplicar -->
                <div class="mb-2 flex flex-col justify-left items-left w-full">
                    <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold rounded-full mr-4 p-2" @click="expert" v-if="user && user.permissions !== 2">
                        Convertirse en Experto Altruista
                    </button>
                    <p v-else class="text-center text-black text-2xl font-bold py-2 px-4">
                        Ya eres un experto altruista
                    </p>
                </div>
                <h1 class="text-black text-2xl font-bold py-2 px-4">¿Qué es un Experto Altruista?</h1>
                <p class="text-black text-xs">
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                    Un experto altruista es una persona que tiene una visión y una filosofía de la vida que le permite aportar a la sociedad.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return { }
        },
        methods: {
            expert() {
                queries('POST', '/expert', {}).then(response => {
                    console.log(response);
                    window.location.reload();
                });
            }
        },
        mounted() {
        },
        beforeMount() {
            
        },
    }
</script>
