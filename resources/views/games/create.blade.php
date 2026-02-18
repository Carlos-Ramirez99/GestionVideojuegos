<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear nuevo juego
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Desarrollador</label>
                <input type="text" name="developer" class="form-control" value="{{ old('developer') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Distribuidor</label>
                <input type="text" name="distributor" class="form-control" value="{{ old('distributor') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Modo de juego</label>
                <input type="text" name="game_mode" class="form-control" value="{{ old('game_mode') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Clasificación</label>
                <input type="text" name="classification" class="form-control" value="{{ old('classification') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Género</label>
                <input type="text" name="genre" class="form-control" value="{{ old('genre') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Plataforma</label>
                <input type="text" name="platform" class="form-control" value="{{ old('platform') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Año de lanzamiento</label>
                <input type="number" name="release_year" class="form-control" value="{{ old('release_year') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen de portada</label>
                <input type="file" name="cover_image" class="form-control" nullable>
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('games.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-app-layout>
