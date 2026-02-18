<template>
    <!-- Pagination Wrapper -->
    <div v-if="pagination.last_page > 1"
        class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mt-6">
        <!-- Go To Page -->
        <div class="flex items-center gap-2">
            <span class="text-gray-300 text-sm">Página</span>
            <input v-model.number="inputPage" @keyup.enter="goToPage(inputPage)" type="number" min="1"
                @blur="goToPage(inputPage)" :max="pagination.last_page"
                class="w-14 flex-1 px-2 py-2 rounded-lg bg-gray-800 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary" />
            <span class="text-gray-300 text-sm">de {{ pagination.last_page }}</span>
        </div>

        <!-- Pagination Navigation -->
        <nav class="flex items-center gap-1" aria-label="Pagination">
            <!-- Previous Button -->
            <button @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
                class="p-2 rounded-lg text-gray-300 hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
                aria-label="Página anterior">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="currentColor" viewBox="0 0 640 640">
                    <path
                        d="M201.4 297.4C188.9 309.9 188.9 330.2 201.4 342.7L361.4 502.7C373.9 515.2 394.2 515.2 406.7 502.7C419.2 490.2 419.2 469.9 406.7 457.4L269.3 320L406.6 182.6C419.1 170.1 419.1 149.8 406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3L201.3 297.3z" />
                </svg>
            </button>

            <!-- Page Numbers -->
            <div class="flex items-center gap-1">
                <!-- First Page -->
                <button @click="goToPage(1)" :class="[
                    'px-3 py-2 rounded-lg text-sm transition',
                    pagination.current_page === 1 ? 'bg-gray-600 text-white' : 'text-gray-300 hover:bg-gray-700'
                ]">
                    1
                </button>

                <!-- Ellipsis Before Middle Pages -->
                <span v-if="pagination.current_page > 3" class="text-gray-400 px-1">...</span>

                <!-- Middle Pages -->
                <button v-for="page in middlePages" :key="page" @click="goToPage(page)" :class="[
                    'px-3 py-2 rounded-lg text-sm transition',
                    pagination.current_page === page ? 'bg-gray-600 text-white' : 'text-gray-300 hover:bg-gray-700'
                ]">
                    {{ page }}
                </button>

                <!-- Ellipsis After Middle Pages -->
                <span v-if="pagination.current_page < pagination.last_page - 2" class="text-gray-400 px-1">...</span>

                <!-- Last Page -->
                <button v-if="pagination.last_page > 1" @click="goToPage(pagination.last_page)" :class="[
                    'px-3 py-2 rounded-lg text-sm transition',
                    pagination.current_page === pagination.last_page ? 'bg-gray-600 text-white' : 'text-gray-300 hover:bg-gray-700'
                ]">
                    {{ pagination.last_page }}
                </button>
            </div>

            <!-- Next Button -->
            <button @click="goToPage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page"
                class="p-2 rounded-lg hover:bg-gray-700 text-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition"
                aria-label="Próxima página">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="currentColor" viewBox="0 0 640 640">
                    <path
                        d="M439.1 297.4C451.6 309.9 451.6 330.2 439.1 342.7L279.1 502.7C266.6 515.2 246.3 515.2 233.8 502.7C221.3 490.2 221.3 469.9 233.8 457.4L371.2 320L233.9 182.6C221.4 170.1 221.4 149.8 233.9 137.3C246.4 124.8 266.7 124.8 279.2 137.3L439.2 297.3z" />
                </svg>
            </button>
        </nav>
    </div>
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        /**
         * Objeto com dados de paginação
         * { current_page, per_page, total, last_page }
         */
        pagination: {
            type: Object,
            required: true,
            validator: (obj) => {
                return 'current_page' in obj && 'last_page' in obj;
            }
        },
    },
    data() {
        return {
            inputPage: 1,
        };
    },
    computed: {
        /**
         * Calcula quais páginas do meio devem ser exibidas
         * Mostra até 3 páginas no meio (próxima da atual e vizinhas)
         */
        middlePages() {
            const current = this.pagination.current_page;
            const last = this.pagination.last_page;
            const pages = [];

            // Se temos poucas páginas, mostrar todas
            if (last <= 5) {
                for (let i = 2; i < last; i++) {
                    pages.push(i);
                }
                return pages;
            }

            // Mostrar páginas ao redor da atual
            let start = Math.max(2, current - 1);
            let end = Math.min(last - 1, current + 1);

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            return pages;
        }
    },
    watch: {
        'pagination.current_page'(newPage) {
            this.inputPage = newPage;
        }
    },
    methods: {
        async goToPage(page) {
            if (page < 1 || page > this.pagination.last_page || page === this.pagination.current_page) {
                return;
            }

            this.$emit('page-changed', page);
        },
    },
    mounted() {
        this.inputPage = this.pagination.current_page;
    },
};
</script>