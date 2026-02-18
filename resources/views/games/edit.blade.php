<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar: {{ $game->title }}
        </h2>
    </x-slot>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">

        @auth
            @if (auth()->user()->id !== $game->user_id && auth()->user()->role !== 'admin')

                <div class="alert alert-danger">
                    No tienes permiso para editar este contenido.
                </div>

                <a href="{{ route('games.show', $game) }}" class="btn btn-secondary">
                    Volver
                </a>

            @else

                <h1 class="mb-4">Editar juego</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('games.update', $game) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $game->title) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Desarrollador</label>
                        <input type="text"
                               name="developer"
                               class="form-control"
                               value="{{ old('developer', $game->developer) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Distribuidor</label>
                        <input type="text"
                               name="distributor"
                               class="form-control"
                               value="{{ old('distributor', $game->distributor) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  required>{{ old('description', $game->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Modo de juego</label>
                        <input type="text"
                               name="game_mode"
                               class="form-control"
                               value="{{ old('game_mode', $game->game_mode) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Clasificación</label>
                        <input type="text"
                               name="classification"
                               class="form-control"
                               value="{{ old('classification', $game->classification) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Género</label>
                        <input type="text"
                               name="genre"
                               class="form-control"
                               value="{{ old('genre', $game->genre) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Plataforma</label>
                        <input type="text"
                               name="platform"
                               class="form-control"
                               value="{{ old('platform', $game->platform) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Año de lanzamiento</label>
                        <input type="number"
                               name="release_year"
                               class="form-control"
                               value="{{ old('release_year', $game->release_year) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagen de portada (opcional)</label>
                        <input type="file" name="cover_image" class="form-control">

                        @if($game->cover_image)
                            <div class="mt-2">
                                <small class="text-muted d-block mb-2">Portada actual:</small>

                                {{-- Si guardas en storage --}}
                                <img src="{{ asset('storage/' . $game->cover_image) }}"
                                     alt="Portada actual"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 200px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a href="{{ route('games.show', $game) }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                </form>

            @endif
        @endauth

    </div>

</x-app-layout>
