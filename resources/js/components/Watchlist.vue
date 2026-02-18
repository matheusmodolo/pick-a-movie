<template>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h2 class="font-display text-3xl text-white mb-4">
            Minha Lista
            <span v-if="watchlist.length" class="text-lg text-gray-400">({{ pagination.total }})</span>
        </h2>

        <div v-if="loading" class="text-center text-gray-400">
            Carregando watchlist...
        </div>

        <div v-else-if="watchlist.length" class="flex flex-col gap-4">
            <!-- Grid de filmes -->
            <div class="grid grid-cols-1 gap-4">
                <div v-for="entry in watchlist" :key="entry.id"
                    class="flex items-center justify-between bg-gray-800/50 rounded-lg p-4">

                    <div class="flex gap-4 flex-1">
                        <!-- Poster -->
                        <img v-if="entry.movie?.poster && entry.movie.poster !== 'N/A'" :src="entry.movie.poster"
                            :alt="entry.movie?.title" class="w-16 h-24 object-cover rounded" />
                        <div v-else class="w-16 h-24 bg-gray-700 rounded flex items-center justify-center">
                            <span class="text-xs text-gray-400">Sem imagem</span>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-white font-semibold">{{ entry.movie?.title || 'Título desconhecido' }}
                                </h3>
                                <p class="text-sm text-gray-400">{{ entry.movie?.year }}</p>
                            </div>
                            <p class="text-sm text-gray-400">Adicionado em {{ datetime_format(entry.created_at) }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col justify-between gap-2">
                        <button @click="viewDetails(entry.movie)"
                            class="px-4 py-2  text-sm rounded-lg text-light font-medium hover:text-white hover:bg-blue-400/20 transition ease-in-out duration-200">
                            Detalhes
                        </button>
                        <button @click="removeMovie(entry.id)"
                            class="px-4 py-2 text-sm rounded-lg font-medium rounded bg-red-600/20 hover:bg-red-600/40 text-red-400 hover:text-red-300 transition ease-in-out duration-200">
                            Remover
                        </button>
                    </div>
                </div>
            </div>

            <!-- Componente de Paginação -->
            <Pagination :pagination="pagination" @page-changed="onPageChanged" />
        </div>

        <div v-else class="text-center text-gray-400 py-8">
            Nenhum filme na sua lista. Pesquise e adicione alguns!
        </div>
    </div>

    <MovieModal :show="showModal" :details="selectedMovie" :loading="loadingDetails"
        :isAdded="selectedMovie ? isInWatchlist(selectedMovie) : false" @close="onModalClose" @add="onModalAdd" />
</template>

<script>
import axios from 'axios';
import MovieModal from './MovieModal.vue';
import Pagination from './Pagination.vue';

export default {
    components: { MovieModal, Pagination },
    data() {
        return {
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
        loading() {
            return this.$store.getters['watchlist/isLoading'];
        },
        pagination() {
            return this.$store.getters['watchlist/pagination'];
        },
    },
    created() {
        // Carrega a watchlist quando o componente é criado
        this.$store.dispatch('watchlist/load', 1);
    },
    methods: {
        datetime_format(value) {
            return new Intl.DateTimeFormat("pt-BR", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
                hour: "2-digit",
                minute: "2-digit",
                hour12: false,
            })
                .format(new Date(value))
                .replace(",", " às");
        },
        isInWatchlist(movie) {
            if (!movie) return false;
            const id = movie.imdbID || movie.movie_id || movie.imdbId;
            return this.$store.getters['watchlist/isInWatchlist'](id);
        },

        async removeMovie(entryId) {
            const confirmed = window.confirm('Tem certeza que deseja remover este filme?');
            if (!confirmed) return;

            await this.$store.dispatch('watchlist/remove', entryId);

            // Recarrega a página atual após remover
            this.$store.dispatch('watchlist/load', this.pagination.current_page);
        },

        async onPageChanged(page) {
            await this.$store.dispatch('watchlist/load', page);
        },

        async onModalAdd(details) {
            console.log('Adicionando filme:', details);

            if (this.isInWatchlist(details)) {
                console.log('Filme já adicionado');
                this.showModal = false;
                return;
            }

            await this.$store.dispatch('watchlist/add', details);
            this.showModal = false;

            // Recarrega a primeira página após adicionar
            this.$store.dispatch('watchlist/load', 1);
        },

        async viewDetails(movie) {
            console.log('movie:', movie);
            this.loadingDetails = true;
            this.selectedMovie = null;
            try {
                const { data } = await axios.get('/api/omdb/details/' + movie.imdb_id);
                this.selectedMovie = data;
                this.showModal = true;
                console.log('Detalhes do filme:', data);
            } catch (err) {
                console.error('Erro na requisição de detalhes:', err);
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