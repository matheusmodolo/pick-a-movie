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
                        <button @click="onModalAdd(movie)"
                            :disabled="addingMovieId === movie.imdbID || isInWatchlist(movie)" class="...">
                            {{ isInWatchlist(movie) ? 'Adicionado' : (addingMovieId === movie.imdbID ? 'Adicionando...'
                                : 'Adicionar') }}
                        </button>

                        <button @click="viewDetails(movie)"
                            class="px-4 py-2 text-sm rounded-lg text-light font-medium hover:text-white hover:bg-blue-400/20 transition ease-in-out duration-200">
                            Detalhes
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-red-500 p-4">Paginação*</div>
            <p class="text-gray-400 mt-4">
                Total de resultados: {{ totalResults }}
            </p>
        </div>

        <div v-else class="text-center text-gray-400 mt-8">
            Tente pesquisar um filme.
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-6">
        <Watchlist />
    </div>

    <MovieModal :show="showModal" :details="selectedMovie" :loading="loadingDetails"
        :isAdded="selectedMovie ? isInWatchlist(selectedMovie) : false" @close="onModalClose" @add="onModalAdd" />
</template>

<script>
import axios from 'axios';
import MovieModal from './MovieModal.vue';
import Watchlist from './Watchlist.vue';

export default {
    components: { MovieModal, Watchlist },
    data() {
        return {
            busca: '',
            movies: [],
            totalResults: 0,
            loading: false,
            error: null,
            placeholder: 'https://placehold.co/300x450?text=No+Image',

            // modal
            showModal: false,
            selectedMovie: null,
            loadingDetails: false,
        };
    },
    computed: {
        watchlist() {
            return this.$store.state.watchlist.items;
        },
        addingMovieId() {
            return this.$store.getters['watchlist/addingMovieId'];
        },
        storeError() {
            return this.$store.getters['watchlist/error'];
        },
    },
    created() {
        // Carrega a watchlist quando o componente é criado
        this.$store.dispatch('watchlist/load');
    },
    methods: {
        isInWatchlist(movie) {
            if (!movie) return false;
            const id = movie.imdbID || movie.movie_id || movie.imdbId;
            return this.$store.getters['watchlist/isInWatchlist'](id);
        },

        async onModalAdd(details) {
            console.log('Adicionando filme:', details);

            // Previne duplicata
            if (this.isInWatchlist(details)) {
                console.log('Filme já adicionado');
                this.showModal = false;
                return;
            }

            // Usa a ação do store para adicionar
            await this.$store.dispatch('watchlist/add', details);

            // Fechar modal após adicionar com sucesso
            if (!this.storeError) {
                this.showModal = false;
            }
        },

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

                this.movies = Array.isArray(data.Search) ? data.Search : [];
                this.totalResults = parseInt(data.totalResults) || 0;

                console.log('Resposta da API:', data);
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

        async viewDetails(movie) {
            this.loadingDetails = true;
            this.selectedMovie = null;
            try {
                const { data } = await axios.get('/api/omdb/details/' + movie.imdbID);
                this.selectedMovie = data;
                this.showModal = true;
                console.log('Detalhes do filme:', data);
            } catch (err) {
                console.error('Erro na requisição de detalhes:', err);
                this.error = 'Erro ao carregar detalhes do filme.';
            } finally {
                this.loadingDetails = false;
            }
        },

        onModalClose() {
            this.showModal = false;
            this.selectedMovie = null;
        },
    }
};
</script>