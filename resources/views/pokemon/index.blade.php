@extends('layouts.app')

@section('title', 'Listado de Pokémon')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pokédex de la Liga</h1>
                <p class="text-gray-600 mt-1">Todos los Pokémon registrados en la liga, capturados y salvajes</p>
            </div>
            <!-- Link correcto sin parámetros query -->
            <a href="{{ url('/pokemon/available') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                </svg>
                Ver Pokémon disponibles
            </a>
        </div>

        <!-- Filtros (versión funcional) -->
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-2">Filtros</h2>
            <form action="{{ route('pokemon.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select id="tipo" name="tipo" class="w-full rounded border-gray-300 shadow-sm">
                            <option value="">Todos los tipos</option>
                            <option value="Fuego" {{ request('tipo') == 'Fuego' ? 'selected' : '' }}>Fuego</option>
                            <option value="Agua" {{ request('tipo') == 'Agua' ? 'selected' : '' }}>Agua</option>
                            <option value="Planta" {{ request('tipo') == 'Planta' ? 'selected' : '' }}>Planta</option>
                            <option value="Eléctrico" {{ request('tipo') == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                            <option value="Normal" {{ request('tipo') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Volador" {{ request('tipo') == 'Volador' ? 'selected' : '' }}>Volador</option>
                            <option value="Veneno" {{ request('tipo') == 'Veneno' ? 'selected' : '' }}>Veneno</option>
                            <option value="Tierra" {{ request('tipo') == 'Tierra' ? 'selected' : '' }}>Tierra</option>
                            <option value="Psíquico" {{ request('tipo') == 'Psíquico' ? 'selected' : '' }}>Psíquico</option>
                            <option value="Lucha" {{ request('tipo') == 'Lucha' ? 'selected' : '' }}>Lucha</option>
                            <option value="Roca" {{ request('tipo') == 'Roca' ? 'selected' : '' }}>Roca</option>
                            <option value="Hielo" {{ request('tipo') == 'Hielo' ? 'selected' : '' }}>Hielo</option>
                            <option value="Fantasma" {{ request('tipo') == 'Fantasma' ? 'selected' : '' }}>Fantasma</option>
                            <option value="Dragón" {{ request('tipo') == 'Dragón' ? 'selected' : '' }}>Dragón</option>
                            <option value="Siniestro" {{ request('tipo') == 'Siniestro' ? 'selected' : '' }}>Siniestro</option>
                            <option value="Acero" {{ request('tipo') == 'Acero' ? 'selected' : '' }}>Acero</option>
                            <option value="Hada" {{ request('tipo') == 'Hada' ? 'selected' : '' }}>Hada</option>
                            <option value="Bicho" {{ request('tipo') == 'Bicho' ? 'selected' : '' }}>Bicho</option>
                        </select>
                    </div>
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select id="estado" name="estado" class="w-full rounded border-gray-300 shadow-sm">
                            <option value="">Todos</option>
                            <option value="disponible" {{ request('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="capturado" {{ request('estado') == 'capturado' ? 'selected' : '' }}>Capturado</option>
                        </select>
                    </div>
                    <div>
                        <label for="busqueda" class="block text-sm font-medium text-gray-700 mb-1">Búsqueda</label>
                        <div class="flex">
                            <input type="text" id="busqueda" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar por nombre..." class="w-full rounded-l border-gray-300 shadow-sm">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 rounded-r">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Aplicar filtros
                    </button>
                    <a href="{{ route('pokemon.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        @if($pokemon->isEmpty())
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                No hay Pokémon registrados en la liga todavía.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pokemon as $poke)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <a href="{{ route('pokemon.show', $poke) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                        {{ $poke->nombre }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($poke->tipo == 'Fuego') bg-red-500 text-white
                                    @elseif($poke->tipo == 'Agua') bg-blue-500 text-white
                                    @elseif($poke->tipo == 'Planta') bg-green-500 text-white
                                    @elseif($poke->tipo == 'Eléctrico') bg-yellow-500 text-black
                                    @elseif($poke->tipo == 'Tierra') bg-yellow-700 text-white
                                    @elseif($poke->tipo == 'Roca') bg-gray-600 text-white
                                    @elseif($poke->tipo == 'Veneno') bg-purple-500 text-white
                                    @elseif($poke->tipo == 'Psíquico') bg-pink-500 text-white
                                    @elseif($poke->tipo == 'Hielo') bg-blue-300 text-white
                                    @elseif($poke->tipo == 'Dragón') bg-indigo-500 text-white
                                    @elseif($poke->tipo == 'Fantasma') bg-purple-600 text-white
                                    @elseif($poke->tipo == 'Siniestro') bg-gray-800 text-white
                                    @elseif($poke->tipo == 'Acero') bg-gray-500 text-white
                                    @elseif($poke->tipo == 'Hada') bg-pink-400 text-white
                                    @elseif($poke->tipo == 'Volador') bg-blue-400 text-white
                                    @elseif($poke->tipo == 'Lucha') bg-orange-500 text-white
                                    @elseif($poke->tipo == 'Bicho') bg-green-600 text-white
                                    @elseif($poke->tipo == 'Normal') bg-gray-400 text-white
                                    @else bg-gray-300 text-gray-800
                                    @endif">
                                        {{ $poke->tipo }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="font-semibold">Nv. {{ $poke->nivel }}</span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" 
                                             style="width: {{ min(100, ($poke->stats / 780) * 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $poke->stats }}/780</span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($poke->entrenador)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                            </svg>
                                            Capturado por <a href="{{ route('entrenadores.show', $poke->entrenador) }}" class="ml-1 underline">{{ $poke->entrenador->nombre }}</a>
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.736 6.979C9.208 6.193 9.696 6 10 6c.304 0 .792.193 1.264.979a1 1 0 001.715-1.029C12.279 4.784 11.232 4 10 4s-2.279.784-2.979 1.95c-.285.475-.507 1-.67 1.55H6a1 1 0 000 2h.013a9.358 9.358 0 000 1H6a1 1 0 000 2h.351a8.394 8.394 0 00.67 1.55C7.721 15.216 8.768 16 10 16s2.279-.784 2.979-1.95a1 1 0 10-1.715-1.029c-.472.786-.96.979-1.264.979-.304 0-.792-.193-1.264-.979a4.265 4.265 0 01-.264-.521H10a1 1 0 100-2H8.017a7.36 7.36 0 010-1H10a1 1 0 100-2H8.472c.08-.185.167-.36.264-.521z" clip-rule="evenodd" />
                                            </svg>
                                            Disponible
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('pokemon.show', $poke) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        @if($poke->entrenador)
                                            <a href="{{ route('pokemon.edit', $poke) }}" class="text-yellow-600 hover:text-yellow-900" title="Entrenar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('pokemon.release', $poke) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('¿Estás seguro de querer liberar a este Pokémon?')" title="Liberar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Enlace directo a la URL absoluta para evitar problemas con la ruta -->
                                            <a href="{{ url('/pokemon/available') }}" class="text-green-600 hover:text-green-900" title="Capturar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection