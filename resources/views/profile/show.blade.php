<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-amber-200 leading-tight">
            {{ __('Perfil de Jugador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-lime-600 dark:bg-blue-600 shadow sm:rounded-lg border-l-4 border-indigo-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="bi bi-person-badge text-4xl text-indigo-600"></i>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-2 capitalize">
                            Rol: {{ $user->role }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-lime-600 dark:bg-blue-600 shadow sm:rounded-lg">
                <header class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            <i class="bi bi-disc text-indigo-500 mr-2"></i>{{ __('Mi Colección de Juegos') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Explora los juegos de tu colección.
                        </p>
                    </div>
                    @if($games->count() == 0)
                        <span class="bg-indigo-800 text-red-600 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $games->count() }} Juegos
                        </span>
                    @else
                        <span class="bg-indigo-800 text-green-600 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $games->count() }} Juegos
                        </span>
                    @endif

                </header>

                @if($games->isEmpty())
                    <div class="text-center py-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl">
                        <i class="bi bi-music-note-beamed text-4xl text-gray-400"></i>
                        <p class="mt-2 text-gray-500 italic font-mono">Parece que tu estantería está vacía...</p>
                        <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-indigo-500 hover:underline">¡Empieza a coleccionar!</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($games as $game)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition">
                                <h4 class="font-bold text-gray-900 dark:text-white truncate">{{ $game->title }}</h4>
                                <p class="text-indigo-400 text-sm">{{ $game->developer }}</p>
                                <div class="mt-3 flex justify-between items-center text-xs text-gray-500">
                                    <span>{{ $game->genre }}</span>
                                    <span>{{ $game->year }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
