<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de juegos') }}
        </h2>
    </x-slot>

    {{-- Bootstrap CDN (porque tu layout usa Tailwind por defecto) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            background: radial-gradient(1200px circle at 10% 10%, rgba(13,110,253,.25), transparent 55%),
                        radial-gradient(1200px circle at 90% 20%, rgba(32,201,151,.18), transparent 55%),
                        #0b1220;
            color: #fff;
            border-radius: 1rem;
            overflow: hidden;
        }
        .hero .subtitle { color: rgba(255,255,255,.75); }
        .game-card { transition: transform .12s ease, box-shadow .12s ease; }
        .game-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1.25rem rgba(0,0,0,.12); }
        .cover {
            aspect-ratio: 16 / 9;
            object-fit: cover;
            background: #f1f3f5;
        }
        .rating-pill {
            font-variant-numeric: tabular-nums;
        }
    </style>

    <div class="container py-4">

        {{-- HERO --}}
        <div class="hero p-4 p-md-5 mb-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <h1 class="mb-1">Listado de juegos</h1>
                    <div class="subtitle">Explora, entra al detalle y valora con estrellas ⭐</div>
                </div>
            </div>

            {{-- Buscador --}}
            <form class="mt-4" method="GET" action="{{ route('games.index') }}">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text"
                               name="q"
                               value="{{ request('q') }}"
                               class="form-control form-control-lg"
                               placeholder="Buscar por título, género, plataforma…">
                    </div>

                    <div class="col-md-3">
                        <select name="genre" class="form-select form-select-lg">
                            <option value="">Todos los géneros</option>
                            @php
                                $genres = collect($games)->pluck('genre')->filter()->unique()->sort()->values();
                            @endphp
                            @foreach($genres as $g)
                                <option value="{{ $g }}" @selected(request('genre') === $g)>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-grid">
                        <button class="btn btn-primary btn-lg" type="submit">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- CONTENIDO --}}
        @if($games->count())
            <div class="row g-3">
                @foreach($games as $game)
                    @php
                        $avg = (float)($game->average_rating ?? 0);
                    @endphp

                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card game-card h-100 border-0 shadow-sm">
                            @if($game->cover_image)
                                <img src="{{ $game->cover_image }}" class="card-img-top cover" alt="{{ $game->title }}">
                            @endif

                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title mb-1">{{ $game->title }}</h5>
                                    <span class="badge bg-dark rating-pill">
                                        ⭐ {{ number_format($avg, 2) }}
                                    </span>
                                </div>

                                <div class="text-muted small mb-2">
                                    {{ $game->platform }} · {{ $game->release_year }}
                                </div>

                                <p class="card-text text-muted">
                                    {{ \Illuminate\Support\Str::limit($game->description, 110) }}
                                </p>
                            </div>

                            <div class="card-footer bg-white border-0">
                                <a href="{{ route('games.show', $game) }}" class="btn btn-primary w-100">
                                    Ver detalle y valorar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(method_exists($games, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $games->links() }}
                </div>
            @endif
        @else
            <div class="alert alert-warning">
                No hay juegos disponibles todavía.
            </div>
        @endif

    </div>

    @auth
    @if(auth()->user()->isAdmin())
        <a href="{{ route('games.create') }}" class="btn btn-success mb-3">
            + Nuevo juego
        </a>
    @endif
@endauth


</x-app-layout>
