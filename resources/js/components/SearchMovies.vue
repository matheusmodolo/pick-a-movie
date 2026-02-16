<template>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Search -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row gap-3 items-center">
                <input v-model="busca" @keyup.enter="searchMovies" placeholder="Pesquisar Filmes..."
                    class="flex-1 w-full px-4 py-3 rounded-lg bg-gray-800 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary"
                    autofocus />
                <button @click="searchMovies" :disabled="loading"
                    class="px-4 py-3 text-sm rounded-lg bg-primary-600 text-dark font-medium hover:bg-primary-600/90 hover:scale-105 shadow hover:shadow-lg hover:shadow-primary-600/50 shadow-primary-600/50 transition ease-in-out disabled:opacity-50 duration-200">
                    Buscar
                </button>
            </div>
            <p v-if="loading" class="mt-2 text-sm text-gray-500">Buscando...</p>
            <p v-if="error" class="mt-2 text-sm text-red-400">{{ error }}</p>
        </div>

        <!-- Movies grid -->
        <div v-if="movies.length"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <div v-for="movie in movies" :key="movie.imdbID"
                class="bg-white/5 rounded-lg overflow-hidden shadow-lg flex flex-col" role="article"
                :aria-label="`Filme ${movie.Title} (${movie.Year})`">
                <div class="w-full">
                    <img :src="movie.Poster !== 'N/A' ? movie.Poster : placeholder" :alt="movie.Title"
                        class="w-full h-64 object-cover" />
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <div class="mb-2">
                        <h4 class="text-white text-lg font-semibold truncate">{{ movie.Title }}</h4>
                        <small class="text-gray-400">{{ movie.Year }}</small>
                    </div>

                    <div class="mt-auto flex gap-2 items-center">
                        <button @click="toggleWatchlist(movie)" :disabled="isInWatchlist(movie)"
                            class="flex-1 px-3 py-2 text-sm rounded-lg font-medium hover:scale-105 shadow hover:shadow-lg transition ease-in-out disabled:opacity-50 duration-200"
                            :class="isInWatchlist(movie) ? 'bg-gray-600 text-gray-300 cursor-not-allowed' : 'bg-green-600 text-white hover:bg-green-700 shadow shadow-green-600/50 hover:shadow-green-600/50'"
                            :aria-pressed="isInWatchlist(movie) ? 'true' : 'false'">
                            {{ isInWatchlist(movie) ? 'Adicionado' : 'Adicionar' }}
                        </button>

                        <button @click="viewDetails(movie)"
                            class="px-4 py-2 text-sm rounded-lg text-light font-medium hover:text-white hover:bg-blue-400/20 transition ease-in-out duration-200">
                            Detalhes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-gray-400 mt-8">
            Tente pesquisar um filme.
        </div>
    </div>

    <MovieModal :show="showModal" :details="selectedMovie" :loading="loadingDetails"
        :isAdded="selectedMovie ? isInWatchlist(selectedMovie) : false" @close="onModalClose" @add="onModalAdd" />
</template>

<script>
import axios from 'axios';
import MovieModal from './MovieModal.vue';

export default {
    components: { MovieModal },
    data() {
        return {
            busca: '',
            movies: [],
            loading: false,
            error: null,
            placeholder: 'https://placehold.co/300x450?text=No+Image',
            watchlist: [],
            localStorageKey: 'meu_watchlist_v1',

            // modal
            showModal: false,
            selectedMovie: null,
            loadingDetails: false,
        };
    },
    created() {
        // carrega watchlist do localStorage
        const raw = localStorage.getItem(this.localStorageKey);
        if (raw) {
            try {
                this.watchlist = JSON.parse(raw);
            } catch (e) {
                console.warn('Erro ao ler watchlist do localStorage', e);
                this.watchlist = [];
            }
        }
    },
    methods: {
        async searchMovies() {
            if (!this.busca || this.busca.trim().length < 1) {
                this.error = 'Digite algo para pesquisar.';
                return;
            }

            this.loading = true;
            this.error = null;

            try {
                const { data } = await axios.get('/api/omdb/search', {
                    params: { q: this.busca }
                });

                // segurança: garantimos que movies seja array
                this.movies = Array.isArray(data.Search) ? data.Search : [];
            } catch (err) {

                if (err.response) {
                    if (err.response.status === 404) {
                        this.error = 'Nenhum filme encontrado para essa busca.';
                        this.movies = [];
                        return;
                    }
                }
                console.error('Erro na requisição:', err);

                this.error = 'Erro ao buscar filmes. Tente novamente.';
                this.movies = [];
            } finally {
                this.loading = false;
            }
        },

        // verifica se já está na lista (usa imdbID)
        isInWatchlist(movie) {
            return this.watchlist.some(m => m.imdbID === movie.imdbID);
        },

        // adiciona / remove (toggle) — aqui apenas adiciona, botão fica desabilitado se já adicionado
        toggleWatchlist(movie) {
            if (this.isInWatchlist(movie)) return;
            this.watchlist.push({
                imdbID: movie.imdbID,
                Title: movie.Title,
                Year: movie.Year,
                Poster: movie.Poster
            });
            this.saveWatchlist();
        },

        saveWatchlist() {
            try {
                localStorage.setItem(this.localStorageKey, JSON.stringify(this.watchlist));
            } catch (e) {
                console.warn('Não foi possível salvar watchlist', e);
            }
        },

        // exemplo de função para abrir detalhes (você pode adaptar)
        async viewDetails(movie) {
            this.loadingDetails = true;
            this.selectedMovie = null;
            try {
                const { data } = await axios.get('/api/omdb/details/' + movie.imdbID);
                // data é o objeto com detalhes (como no seu console)
                this.selectedMovie = data;
                // abrir modal
                this.showModal = true;
            } catch (err) {
                console.error('Erro na requisição de detalhes:', err);
                // opcional: mostrar erro para o usuário
                this.error = 'Erro ao carregar detalhes do filme.';
            } finally {
                this.loadingDetails = false;
            }
        },

        // handlers para o modal
        onModalClose() {
            this.showModal = false;
            this.selectedMovie = null;
        },

        async onModalAdd(details) {
            // reutiliza sua função de adicionar
            this.toggleWatchlist(details);
            // opcional: fecha modal após adicionar
            this.showModal = false;
        }
    }
};
</script>