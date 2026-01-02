<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="searchResults" class="mt-3"></div>

                            <div class="flex gap-2 mx-auto mt-3 justify-between align-items-center mb-8">
                                <input
                                    class="w-full px-4 py-3 rounded-lg bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                    autofocus placeholder="Pesquisar Filmes..." v-model="busca" type="text"
                                    @keyup.enter="searchMovies"></input>
                                <button type="submit" @click="searchMovies"
                                    class="px-4 py-2 text-sm rounded-lg text-light font-medium hover:text-white hover:bg-gray-400/20 transition ease-in-out duration-200">Buscar</button>
                            </div>

                            <div v-if="loading">Buscando...</div>

                            <div v-if="error" class="text-danger">{{ error }}</div>

                            <div v-if="movies.length" class="movies-grid">
                                <div v-for="movie in movies" :key="movie.imdbID" class="movie-card">
                                    <img class="rounded" :src="movie.Poster !== 'N/A' ? movie.Poster : placeholder"
                                        alt="poster" />
                                    <h4>{{ movie.Title }}</h4>
                                    <small>{{ movie.Year }}</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            busca: '',
            movies: [],
            loading: false,
            error: null,
            placeholder: 'https://placehold.co/200x300?text=No+Image',
        }
    },
    methods: {
        async searchMovies() {
            this.loading = true;
            console.log('Buscando filmes para:', this.busca);
            const { data } = await axios.get('/api/omdb/search', {
                params: { q: this.busca }
            }).catch(error => {
                this.error = 'Erro ao buscar filmes.';
                this.loading = false;
                console.error('Erro na requisição:', error);
            });

            console.log('data: ', data);

            this.movies = data.Search ?? [];

            this.loading = false;
        },

    },
}
</script>


<style>
.movies-grid {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.movie-card {
    width: 150px;
}

.movie-card img {
    width: 100%;
    height: auto;
}
</style>
