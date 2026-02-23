<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $game->title }}
        </h2>
    </x-slot>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">

        {{-- Título --}}
        <h1 class="mb-3">{{ $game->title }}</h1>

        {{-- Imagen --}}
        @if ($game->cover_image)
            <img src="{{ $game->cover_image }}" alt="{{ $game->title }}" class="img-fluid mb-4 rounded shadow"
                style="max-height: 350px;">
        @endif

        {{-- Información básica --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <p><strong>Género:</strong> {{ $game->genre }}</p>
                <p><strong>Plataforma:</strong> {{ $game->platform }}</p>
                <p><strong>Año de lanzamiento:</strong> {{ $game->release_year }}</p>
                <p><strong>Desarrollador:</strong> {{ $game->developer }}</p>
                <p><strong>Distribuidor:</strong> {{ $game->distributor }}</p>

                <hr>

                <p class="mb-1"><strong>Descripción:</strong></p>
                <p class="text-muted">{{ $game->description }}</p>
            </div>
        </div>

        {{-- ⭐ SISTEMA DE ESTRELLAS --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Valoración del juego</h5>

                <x-star-rating :game-id="$game->id" :user-rating="$userRating" :average="$game->average_rating ?? 0" :count="$ratingsCount" />
            </div>
        </div>
        {{-- 📝 RESEÑAS / COMENTARIOS --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Reseñas</h5>
                    <span class="badge bg-secondary">{{ $reviews->count() }}</span>
                </div>

                {{-- 6️⃣ Mensaje si no hay comentarios --}}
                @if ($reviews->isEmpty())
                    <div class="alert alert-light border mb-0">
                        Todavía no hay reseñas. ¡Sé el primero en comentar!
                    </div>
                @else
                    {{-- 2️⃣ Listar todos los comentarios del ítem --}}
                    <div class="d-flex flex-column gap-3">
                        @foreach ($reviews as $review)
                            <div class="border rounded p-3">

                                {{-- 3️⃣ Autor y fecha --}}
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $review->title ?? 'Reseña' }}
                                        </div>
                                        <div class="text-muted small">
                                            Por <strong>{{ $review->user->name ?? 'Usuario' }}</strong>
                                            · {{ $review->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>

                                    {{-- 5️⃣ Botones editar/eliminar (solo creador o admin) --}}
                                    @auth
                                        @if (auth()->id() === $review->user_id || auth()->user()->role === 'admin')
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-primary" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#editReview{{ $review->id }}">
                                                    Editar
                                                </button>

                                                <form method="POST" action="{{ route('reviews.destroy', $review) }}"
                                                    onsubmit="return confirm('¿Eliminar esta reseña?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>

                                <hr class="my-2">

                                <p class="mb-0">{{ $review->content }}</p>

                                {{-- Formulario de edición inline --}}
                                @auth
                                    @if (auth()->id() === $review->user_id || auth()->user()->role === 'admin')
                                        <div class="collapse mt-3" id="editReview{{ $review->id }}">
                                            <div class="card card-body bg-light">
                                                <form method="POST" action="{{ route('reviews.update', $review) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-2">
                                                        <label class="form-label small">Título (opcional)</label>
                                                        <input type="text" name="title" class="form-control"
                                                            value="{{ old('title', $review->title) }}">
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label small">Contenido</label>
                                                        <textarea name="content" class="form-control" rows="3" required>{{ old('content', $review->content) }}</textarea>
                                                    </div>

                                                    <button class="btn btn-primary btn-sm" type="submit">
                                                        Guardar cambios
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endauth

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- 4️⃣ Formulario para nuevo comentario (solo autenticados) --}}
        @auth
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Escribir una reseña</h5>

                    <form method="POST" action="{{ route('reviews.store', $game) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Título (opcional)</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contenido</label>
                            <textarea name="content" class="form-control" rows="4" required minlength="10" maxlength="1000">{{ old('content') }}</textarea>
                            <div class="form-text">Entre 10 y 1000 caracteres.</div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Publicar reseña
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Inicia sesión para escribir una reseña.
            </div>
        @endauth

        {{-- Botón volver --}}
        <a href="{{ route('games.index') }}" class="btn btn-secondary">
            ← Volver al listado
        </a>

        @auth
            @if (auth()->user()->isAdmin())
                <div class="d-flex gap-2 mb-3">
                    <a href="{{ route('games.edit', $game) }}" class="btn btn-warning">
                        Editar
                    </a>

                    <form method="POST" action="{{ route('games.destroy', $game) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            Eliminar
                        </button>
                    </form>
                </div>
            @endif
        @endauth


    </div>


</x-app-layout>
