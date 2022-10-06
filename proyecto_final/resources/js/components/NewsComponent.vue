<template>
    <div>
        <div class="grid gap-4 w-2/3 mx-auto bg-second-50 rounded-lg shadow-lg">
            <div class="flex flex-row justify-center items-center w-full">
                <div class="bg-first-900 rounded-lg shadow-lg flex flex-row flex-wrap justify-between items-center w-full">
                    <p class="text-center text-white text-2xl font-bold py-2 px-4">Noticias</p>
                    <button type="button" class="bg-first-900 hover:bg-first-500 text-white font-bold w-8 h-8 rounded-full mr-4" @click="closeNav('notes')" v-if="user && user.permissions == 2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full p-3 flex flex-col space-y-4 max-h-full overflow-y-auto" style="height: calc(100vh - 200px);">
                <div v-if="news.length > 0" class="mb-2">
                    <div v-for="news in news" class="text-black py-2 mb-2 px-auto rounded-lg self-end w-3/3 grid gap-2 grid-cols-3" :key="news.id">
                        <div class="flex flex-col justify-center items-center w-full p-2">
                            <img class="w-full h-auto mb-2" :src="news.image ? (news.image.endsWith('.mp3') ? 'default-news.jpeg' : (news.image.endsWith('.mp4') ? 'default-news.jpeg' : news.image )) : 'default-news.jpeg'"/>
                        </div>
                        <span class="text-white text-xs col-span-2 col-start-2">
                            <p class="text-left text-black font-bold block w-full">
                                {{news.title.substring(0, 150)}}<span v-if="news.title.length > 150">...</span>
                            </p>
                            <p class="text-left text-black block w-full">
                                {{news.description}}
                            </p>
                            <p class="text-left text-black block w-full">
                                Autor: {{news.author}}
                            </p>
                            <div class="flex flex-row justify-center items-center w-full">
                                <a :href="news.url" target="_blank" class="bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 rounded-lg">
                                    Ver más
                                </a>
                            </div>
                        </span>
                    </div>
                </div>
                <div v-else class="bg-second-900 text-white font-bold py-2 px-4 rounded self-end w-full">
                    <p class="text-center text-2xl font-bold py-2 px-4">No hay noticias</p>
                </div>
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
            return {
                isAuthenticated: false,
                news: [],
                windows: {
                    new_news: {open: false},
                },
                news: {
                    user_id: '',
                    content: '',
                    multimedia: null
                }
            }
        },
        methods: {
            closeNav(nav) {
                openNav(nav);
            },
            obtenerNews() {
                Promise.resolve(fetch('http://api.mediastack.com/v1/news?access_key=2633996eb49d2453260658d936e09dad&languages=es,-de&keywords=psicologia&limit=100')
                    .then(response => response.json())
                    .then(data => {
                        this.news = data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                );
            }
        },
        mounted() {
            if (this.user) {
                this.isAuthenticated = true;
                this.news.user_id = this.user.id;
                this.obtenerNews();
                if (localStorage.getItem('news')) {
                    localStorage.removeItem('news');
                }
            } else {
                console.log('no user');
                this.isAuthenticated = false;
                let news = JSON.parse(localStorage.getItem('news'));
                if (!(!news || news.length == 0 || news == '')) {
                    this.news = news;
                } else {
                    this.news = [];
                }
            }
        },
        beforeMount() {
            
        },
    }
</script>
