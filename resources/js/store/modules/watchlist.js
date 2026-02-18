import axios from "axios";

export default {
    namespaced: true,

    state() {
        return {
            items: [],
            loading: false,
            error: null,
            addingMovieId: null,
            pagination: {
                current_page: 1,
                per_page: 10,
                total: 0,
                last_page: 1,
            },
        };
    },

    getters: {
        /**
         * Retorna todos os filmes na watchlist
         */
        all: (state) => state.items,

        /**
         * Verifica se um filme está na watchlist
         * @param {string} movieId - IMDB ID do filme
         */
        isInWatchlist: (state) => (movieId) => {
            if (!movieId) return false;
            return state.items.some(
                (m) => (m.movie_id || m.imdbID) === movieId,
            );
        },

        /**
         * Retorna o filme da watchlist pelo ID
         */
        getMovieById: (state) => (movieId) => {
            if (!movieId) return null;
            return state.items.find(
                (m) => (m.movie_id || m.imdbID) === movieId,
            );
        },

        /**
         * Retorna o total de filmes na watchlist
         */
        count: (state) => state.items.length,

        /**
         * Retorna status de carregamento
         */
        isLoading: (state) => state.loading,

        /**
         * Retorna o ID do filme sendo adicionado (para UI feedback)
         */
        addingMovieId: (state) => state.addingMovieId,

        /**
         * Retorna mensagem de erro
         */
        error: (state) => state.error,

        /**
         * Retorna dados de paginação
         */
        pagination: (state) => state.pagination,
    },

    mutations: {
        /**
         * Define a lista de filmes
         */
        SET_ITEMS(state, items) {
            state.items = Array.isArray(items) ? items : [];
        },

        /**
         * Adiciona um filme à lista
         */
        ADD_ITEM(state, movie) {
            if (
                !state.items.find(
                    (m) =>
                        (m.movie_id || m.imdbID) ===
                        (movie.movie_id || movie.imdbID),
                )
            ) {
                state.items.push(movie);
            }
        },

        /**
         * Remove um filme da lista
         */
        REMOVE_ITEM(state, entryId) {
            state.items = state.items.filter((m) => m.id !== entryId);
        },

        /**
         * Atualiza um filme existente
         */
        UPDATE_ITEM(state, updatedMovie) {
            const index = state.items.findIndex(
                (m) => m.id === updatedMovie.id,
            );
            if (index !== -1) {
                state.items.splice(index, 1, updatedMovie);
            }
        },

        /**
         * Define status de carregamento
         */
        SET_LOADING(state, loading) {
            state.loading = loading;
        },

        /**
         * Define erro
         */
        SET_ERROR(state, error) {
            state.error = error;
        },

        /**
         * Define ID do filme sendo adicionado
         */
        SET_ADDING_MOVIE_ID(state, movieId) {
            state.addingMovieId = movieId;
        },

        /**
         * Limpa erro
         */
        CLEAR_ERROR(state) {
            state.error = null;
        },

        /**
         * Define dados de paginação
         */
        SET_PAGINATION(state, pagination) {
            state.pagination = {
                current_page: pagination.current_page || 1,
                per_page: pagination.per_page || 10,
                total: pagination.total || 0,
                last_page: pagination.last_page || 1,
            };
        },
    },

    actions: {
        /**
         * Carrega a watchlist do servidor
         * @param {number} page - Número da página (padrão: 1)
         */
        async load({ commit }, page = 1) {
            commit("SET_LOADING", true);
            commit("CLEAR_ERROR");

            try {
                const { data } = await axios.get("/user-movies", {
                    params: { page },
                });

                // Handle resposta paginada do Laravel
                const items = Array.isArray(data.data) ? data.data : [];
                commit("SET_ITEMS", items);

                // Armazena informações de paginação (sempre, mesmo que vazio)
                const paginationData = data.meta || {
                    current_page: 1,
                    per_page: 10,
                    total: items.length,
                    last_page: 1,
                };
                commit("SET_PAGINATION", paginationData);

                console.log(
                    "Watchlist carregada:",
                    items,
                    "Paginação:",
                    paginationData,
                );
            } catch (err) {
                const errorMsg = "Erro ao carregar watchlist";
                commit("SET_ERROR", errorMsg);
                console.error(errorMsg, err);
                commit("SET_ITEMS", []);
            } finally {
                commit("SET_LOADING", false);
            }
        },

        /**
         * Adiciona um filme à watchlist
         * @param {object} movieDetails - Detalhes do filme (com Title, Year, Poster, imdbID, etc)
         */
        async add({ commit, getters }, movieDetails) {
            if (!movieDetails?.imdbID) {
                console.error("Filme sem imdbID:", movieDetails);
                return;
            }

            const imdbId = movieDetails.imdbID;

            // Previne duplicata
            if (getters.isInWatchlist(imdbId)) {
                console.log("Filme já está na watchlist");
                return;
            }

            commit("SET_ADDING_MOVIE_ID", imdbId);
            commit("CLEAR_ERROR");

            try {
                const { data } = await axios.post("/user-movies", movieDetails);
                console.log("Resposta do servidor ao adicionar:", data);

                // Garante que o objeto tenha a propriedade `movie` com dados
                const serverEntry = data;
                if (!serverEntry.movie) {
                    serverEntry.movie = {
                        Title: movieDetails.Title,
                        Year: movieDetails.Year,
                        Poster: movieDetails.Poster,
                        imdbID: movieDetails.imdbID,
                    };
                }

                commit("ADD_ITEM", serverEntry);
                console.log("Filme adicionado à watchlist");
            } catch (err) {
                const errorMsg = "Erro ao adicionar na lista. Tente novamente.";
                commit("SET_ERROR", errorMsg);
                console.error("Erro ao adicionar filme:", err);
            } finally {
                commit("SET_ADDING_MOVIE_ID", null);
            }
        },

        /**
         * Remove um filme da watchlist
         * @param {number} entryId - ID do registro na tabela user_movie
         */
        async remove({ commit }, entryId) {
            if (!entryId) return;

            commit("CLEAR_ERROR");

            try {
                await axios.delete(`/user-movies/${entryId}`);
                commit("REMOVE_ITEM", entryId);
                console.log("Filme removido da watchlist");
            } catch (err) {
                const errorMsg = "Não foi possível remover o filme.";
                commit("SET_ERROR", errorMsg);
                console.error("Erro ao remover filme:", err);
            }
        },

        /**
         * Atualiza a posição/ordem de um filme na watchlist
         * @param {number} entryId - ID do registro na tabela user_movie
         * @param {number} newPosition - Nova posição
         */
        async updatePosition({ commit }, { entryId, newPosition }) {
            try {
                const { data } = await axios.patch(`/user-movies/${entryId}`, {
                    position: newPosition,
                });
                commit("UPDATE_ITEM", data);
                console.log("Posição atualizada:", data);
            } catch (err) {
                const errorMsg = "Erro ao atualizar posição.";
                console.error(errorMsg, err);
                // Não comitamos erro aqui pois é uma operação secundária
            }
        },
    },
};
