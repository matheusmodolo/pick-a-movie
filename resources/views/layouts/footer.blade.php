<footer class="py-8 px-4 border-t border-gray-400/20">
    <div class="container mx-auto">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                {{-- Film icon small --}}
                <x-logo class="w-6 h-6 text-primary" />
                <span class="font-display text-xl text-primary">Pick a Movie</span>
            </div>
            <p class="text-sm text-gray-500">© {{ date('Y') }} Pick a Movie. Todos os direitos reservados.
            </p>
        </div>
    </div>
</footer>
