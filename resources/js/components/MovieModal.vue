<template>
    <teleport to="body">
        <transition name="modal-fade" appear>
            <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4">
                <!-- backdrop -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click.self="close" aria-hidden="true"></div>

                <!-- modal container -->
                <div class="relative bg-gray-900 text-white rounded-2xl shadow-xl max-w-4xl w-full mx-auto overflow-hidden transform transition-all"
                    role="dialog" aria-modal="true" :aria-labelledby="'modal-title-' + id">
                    <div class="flex flex-col md:flex-row">
                        <!-- poster -->
                        <div class="md:w-1/3 w-full">
                            <img v-if="details && details.Poster && details.Poster !== 'N/A'" :src="details.Poster"
                                :alt="details.Title" class="w-full h-80 md:h-full object-cover" />
                            <div v-else class="w-full h-80 md:h-full bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-300">No Image</span>
                            </div>
                        </div>

                        <!-- content -->
                        <div class="p-5 md:w-2/3 w-full flex flex-col">
                            <header class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 :id="'modal-title-' + id" class="text-2xl font-semibold">{{ details?.Title ||
                                        'Carregando...' }}</h2>
                                    <p class="text-sm text-gray-400">{{ details?.Year }} • {{ details?.Runtime }} • {{
                                        details?.Genre }}</p>
                                </div>

                                <button @click="close" class="ml-2 rounded-full p-2 hover:bg-white/5 focus:outline-none"
                                    aria-label="Fechar modal">
                                    <!-- simples X -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </header>

                            <main class="mt-4 flex-1 overflow-auto">
                                <p v-if="details" class="text-gray-200 leading-relaxed">{{ details.Plot }}</p>

                                <div v-if="details"
                                    class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-400">
                                    <div>
                                        <p><strong class="text-gray-200">Diretor:</strong> {{ details.Director }}</p>
                                        <p><strong class="text-gray-200">Escritor:</strong> {{ details.Writer }}</p>
                                        <p><strong class="text-gray-200">Atores:</strong> {{ details.Actors }}</p>
                                    </div>
                                    <div>
                                        <p><strong class="text-gray-200">Idiomas:</strong> {{ details.Language }}</p>
                                        <p><strong class="text-gray-200">País:</strong> {{ details.Country }}</p>
                                        <p><strong class="text-gray-200">BoxOffice:</strong> {{ details.BoxOffice }}</p>
                                    </div>
                                </div>

                                <div v-if="details && details.Ratings?.length" class="mt-4">
                                    <h4 class="text-sm text-gray-300 mb-2">Ratings</h4>
                                    <ul class="space-y-1 text-sm text-gray-400">
                                        <li v-for="(r, i) in details.Ratings" :key="i">
                                            <strong class="text-gray-200">{{ r.Source }}:</strong> {{ r.Value }}
                                        </li>
                                    </ul>
                                </div>

                                <div v-if="!details && loading" class="mt-4 text-center text-gray-400">
                                    Carregando detalhes...
                                </div>
                            </main>

                            <footer class="mt-4 flex items-center gap-3">
                                <button @click="handleAdd" :disabled="isAdded || addingMovieId === details?.imdbID"
                                    class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition" :class="isAdded
                                        ? 'bg-gray-600 text-gray-300 cursor-not-allowed'
                                        : addingMovieId === details?.imdbID
                                            ? 'bg-yellow-600 text-white'
                                            : 'bg-green-600 hover:bg-green-700 text-white'">
                                    {{ isAdded ? 'Adicionado' : addingMovieId === details?.imdbID ? 'Adicionando...' :
                                    'Adicionar à lista' }}
                                </button>

                                <button @click="close"
                                    class="px-4 py-2 rounded-md text-sm bg-white/5 hover:bg-white/10">
                                    Fechar
                                </button>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script>
export default {
    name: 'MovieModal',
    props: {
        show: { type: Boolean, default: false },
        details: { type: Object, default: null },
        id: { type: String, default: () => `${Math.random().toString(36).slice(2, 9)}` },
        isAdded: { type: Boolean, default: false },
        loading: { type: Boolean, default: false }
    },
    emits: ['close', 'add'],
    computed: {
        addingMovieId() {
            return this.$store.getters['watchlist/addingMovieId'];
        },
    },
    mounted() {
        // fecha com Esc
        this._handleKey = (e) => {
            if (e.key === 'Escape' && this.show) this.$emit('close');
        };
        window.addEventListener('keydown', this._handleKey);
    },
    beforeUnmount() {
        window.removeEventListener('keydown', this._handleKey);
    },
    methods: {
        close() {
            this.$emit('close');
        },
        handleAdd() {
            if (!this.details) return;
            this.$emit('add', this.details);
        },
    }
};
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: all 180ms ease;
}

.modal-fade-enter-from {
    opacity: 0;
    transform: translateY(8px) scale(.98);
}

.modal-fade-enter-to {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.modal-fade-leave-from {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.modal-fade-leave-to {
    opacity: 0;
    transform: translateY(8px) scale(.98);
}
</style>
