@extends('layouts.app')

@section('content')
    <div class="min-h-screen container">

        <section class="relative pt-32 pb-20 px-4 overflow-hidden">
            <div class="container py-4">
                {{-- <h1 class="mb-4">Minha Lista — Pick a Movie</h1> --}}

                <search-movies></search-movies>

                <hr class="border-gray-700/50 max-w-6xl mx-auto p-0 rounded-lg" />

                <Watchlist></Watchlist>

                {{-- <div class="card mb-4">
                    <div class="card-body">
                        <div id="searchResults" class="mt-3"></div>

                        <form id="searchForm" action="" method="GET"
                            class="flex gap-2 mx-auto mt-3 justify-between align-items-center">
                            <x-input class="" autofocus id="q" placeholder="Pesquisar..."></x-input>
                            <x-btn-secondary type="submit" id="addMovieButton" class="">Buscar</x-btn-secondary>
                        </form>

                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>Sua Lista</strong>
                            <small id="listCount" class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <ul id="myList" class="list-group"></ul>
                        </div>
                    </div>
                </div> --}}

            </div>
        </section>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        // const TOKEN = localStorage.getItem('api_token') || null; // defina no login
        const TOKEN = "{{ env('OMDBAPI_KEY') }}";
        const API_BASE = '/api';

        function authHeaders() {
            return TOKEN ? {
                'Authorization': 'Bearer ' + TOKEN
            } : {};
        }

        async function doSearch(q) {
            const res = await fetch(`${API_BASE}/movies/search?q=${encodeURIComponent(q)}`, {
                headers: {
                    ...authHeaders(),
                    'Accept': 'application/json'
                }
            });
            if (!res.ok) {
                const txt = await res.text();
                console.error('Search error', txt);
                return null;
            }
            return res.json();
        }

        // function renderSearch(results) {
        //     const container = document.getElementById('searchResults');
        //     container.innerHTML = '';
        //     if (!results || !results.Search) {
        //         container.innerHTML = '<div class="text-muted">Nenhum resultado.</div>';
        //         return;
        //     }

        //     const ul = document.createElement('div');
        //     results.Search.forEach(item => {
        //         const card = document.createElement('div');
        //         card.className = 'd-flex align-items-center gap-3 mb-2';

        //         const img = document.createElement('img');
        //         img.src = item.Poster && item.Poster !== 'N/A' ? item.Poster :
        //             'https://via.placeholder.com/60x90?text=No+Poster';
        //         img.style.width = '60px';
        //         img.style.height = '90px';
        //         img.style.objectFit = 'cover';

        //         const info = document.createElement('div');
        //         info.innerHTML =
        //             `<strong>${item.Title}</strong> <small class="text-muted">(${item.Year})</small><br><small class="text-muted">${item.Type}</small>`;

        //         const btn = document.createElement('button');
        //         btn.className = 'btn btn-sm btn-outline-success ms-auto';
        //         btn.textContent = 'Adicionar';
        //         btn.onclick = () => importAndAttach(item.imdbID, btn);

        //         card.appendChild(img);
        //         card.appendChild(info);
        //         card.appendChild(btn);
        //         container.appendChild(card);
        //     });
        // }

        // async function importAndAttach(imdbId, btnEl) {
        //     btnEl.disabled = true;
        //     btnEl.textContent = 'Adicionando...';
        //     const res = await fetch(`${API_BASE}/movies/import`, {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             ...authHeaders(),
        //             'Accept': 'application/json'
        //         },
        //         body: JSON.stringify({
        //             imdb_id: imdbId
        //         })
        //     });
        //     if (!res.ok) {
        //         const err = await res.json().catch(() => null);
        //         console.error('Erro import', err);
        //         btnEl.textContent = 'Erro';
        //         setTimeout(() => btnEl.textContent = 'Adicionar', 2000);
        //         btnEl.disabled = false;
        //         return;
        //     }
        //     await loadMyList();
        //     btnEl.textContent = 'Adicionado';
        //     btnEl.disabled = true;
        // }

        // async function loadMyList() {
        //     const res = await fetch(`${API_BASE}/me/movies`, {
        //         headers: {
        //             ...authHeaders(),
        //             'Accept': 'application/json'
        //         }
        //     });
        //     if (!res.ok) {
        //         console.error('Erro carregando lista');
        //         return;
        //     }
        //     const json = await res.json();
        //     const list = json.data || json; // paginate or array
        //     const ul = document.getElementById('myList');
        //     ul.innerHTML = '';
        //     document.getElementById('listCount').textContent = `${json.total ?? list.length} filmes`;

        //     list.forEach(item => {
        //         // item may be a movie object (if paginated: item is movie resource)
        //         const li = document.createElement('li');
        //         li.className = 'list-group-item d-flex align-items-center';
        //         const img = document.createElement('img');
        //         img.src = item.poster ?? 'https://via.placeholder.com/50x75?text=No';
        //         img.style.width = '50px';
        //         img.style.height = '75px';
        //         img.style.objectFit = 'cover';
        //         img.className = 'me-3';

        //         const title = document.createElement('div');
        //         title.innerHTML =
        //             `<strong>${item.title}</strong> <small class="text-muted">(${item.year ?? ''})</small><br><small class="text-muted">${item.genre ?? ''}</small>`;

        //         const controls = document.createElement('div');
        //         controls.className = 'ms-auto btn-group';
        //         const up = document.createElement('button');
        //         up.className = 'btn btn-sm btn-outline-secondary';
        //         up.textContent = '↑';
        //         up.title = 'Mover para cima';
        //         up.onclick = () => move(item.id, 'up');

        //         const down = document.createElement('button');
        //         down.className = 'btn btn-sm btn-outline-secondary';
        //         down.textContent = '↓';
        //         down.title = 'Mover para baixo';
        //         down.onclick = () => move(item.id, 'down');

        //         const remove = document.createElement('button');
        //         remove.className = 'btn btn-sm btn-outline-danger';
        //         remove.textContent = 'Remover';
        //         remove.onclick = () => removeFromList(item.id);

        //         controls.appendChild(up);
        //         controls.appendChild(down);
        //         controls.appendChild(remove);

        //         li.appendChild(img);
        //         li.appendChild(title);
        //         li.appendChild(controls);
        //         ul.appendChild(li);
        //     });
        // }

        // async function removeFromList(movieId) {
        //     if (!confirm('Remover este filme da sua lista?')) return;
        //     const res = await fetch(`${API_BASE}/me/movies/${movieId}`, {
        //         method: 'DELETE',
        //         headers: {
        //             ...authHeaders(),
        //             'Accept': 'application/json'
        //         }
        //     });
        //     if (res.ok) {
        //         await loadMyList();
        //     } else {
        //         alert('Erro ao remover');
        //     }
        // }

        // async function move(movieId, direction) {
        //     const res = await fetch(`${API_BASE}/me/movies/${movieId}/move`, {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             ...authHeaders(),
        //             'Accept': 'application/json'
        //         },
        //         body: JSON.stringify({
        //             direction
        //         })
        //     });
        //     if (res.ok) await loadMyList();
        //     else alert('Erro ao mover');
        // }

        document.getElementById('searchForm').addEventListener('submit', async (e) => {
            console.log('enviando form');
            e.preventDefault();
            console.log('enviando form 2');
            const q = document.getElementById('q').value.trim();
            if (!q) return;
            const data = await doSearch(q);
            // renderSearch(data);
        });

        // window.addEventListener('load', () => {
        //     loadMyList();
        // });
    </script>
@endpush --}}
