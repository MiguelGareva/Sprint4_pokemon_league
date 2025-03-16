@extends('layouts.app')

@section('title', 'Detalles del Combate')

@section('content')
<div class="container mx-auto px-4 py-6">
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

    <div class="mb-6 flex items-center">
        <a href="{{ route('combates.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a la lista de combates
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detalles del Combate</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del Combate -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="border-b pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Información del Combate</h2>
                    <p class="text-gray-600">
                        <span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($combate->fecha)->format('d/m/Y') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Entrenador 1 -->
                    <div class="border-r pr-4">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-red-100 text-red-800 flex items-center justify-center text-2xl font-bold mr-4">
                                {{ substr($combate->entrenador1->nombre, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">
                                    <a href="{{ route('entrenadores.show', $combate->entrenador1) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $combate->entrenador1->nombre }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm">Puntos: {{ $combate->entrenador1->puntos }}</p>
                            </div>
                            @if($combate->resultado == 'entrenador1')
                                <div class="ml-auto">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Ganador
                                    </span>
                                </div>
                            @endif
                        </div>

                        <h4 class="font-semibold text-gray-700 mb-2">Equipo Pokémon:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                            @foreach($combate->entrenador1->pokemon->take(3) as $pokemon)
                                <div class="border rounded-lg overflow-hidden hover:shadow-md">
                                    <div class="p-3
                                        @if($pokemon->tipo == 'Fuego') bg-red-100
                                        @elseif($pokemon->tipo == 'Agua') bg-blue-100
                                        @elseif($pokemon->tipo == 'Planta') bg-green-100
                                        @elseif($pokemon->tipo == 'Eléctrico') bg-yellow-100
                                        @elseif($pokemon->tipo == 'Tierra') bg-yellow-800 text-white
                                        @elseif($pokemon->tipo == 'Roca') bg-gray-400
                                        @elseif($pokemon->tipo == 'Veneno') bg-purple-100
                                        @elseif($pokemon->tipo == 'Psíquico') bg-pink-100
                                        @elseif($pokemon->tipo == 'Hielo') bg-blue-50
                                        @elseif($pokemon->tipo == 'Dragón') bg-indigo-100
                                        @elseif($pokemon->tipo == 'Fantasma') bg-purple-200
                                        @elseif($pokemon->tipo == 'Siniestro') bg-gray-900 text-white
                                        @elseif($pokemon->tipo == 'Acero') bg-gray-300
                                        @elseif($pokemon->tipo == 'Hada') bg-pink-200
                                        @elseif($pokemon->tipo == 'Volador') bg-blue-200
                                        @elseif($pokemon->tipo == 'Lucha') bg-orange-100
                                        @elseif($pokemon->tipo == 'Bicho') bg-green-200
                                        @elseif($pokemon->tipo == 'Normal') bg-gray-100
                                        @else bg-gray-50
                                        @endif">
                                        <div class="flex items-center justify-between">
                                            <h5 class="font-bold">{{ $pokemon->nombre }}</h5>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($pokemon->tipo == 'Fuego') bg-red-500 text-white
                                                @elseif($pokemon->tipo == 'Agua') bg-blue-500 text-white
                                                @elseif($pokemon->tipo == 'Planta') bg-green-500 text-white
                                                @elseif($pokemon->tipo == 'Eléctrico') bg-yellow-500 text-black
                                                @elseif($pokemon->tipo == 'Tierra') bg-yellow-700 text-white
                                                @elseif($pokemon->tipo == 'Roca') bg-gray-600 text-white
                                                @elseif($pokemon->tipo == 'Veneno') bg-purple-500 text-white
                                                @elseif($pokemon->tipo == 'Psíquico') bg-pink-500 text-white
                                                @elseif($pokemon->tipo == 'Hielo') bg-blue-300 text-white
                                                @elseif($pokemon->tipo == 'Dragón') bg-indigo-500 text-white
                                                @elseif($pokemon->tipo == 'Fantasma') bg-purple-600 text-white
                                                @elseif($pokemon->tipo == 'Siniestro') bg-gray-800 text-white
                                                @elseif($pokemon->tipo == 'Acero') bg-gray-500 text-white
                                                @elseif($pokemon->tipo == 'Hada') bg-pink-400 text-white
                                                @elseif($pokemon->tipo == 'Volador') bg-blue-400 text-white
                                                @elseif($pokemon->tipo == 'Lucha') bg-orange-500 text-white
                                                @elseif($pokemon->tipo == 'Bicho') bg-green-600 text-white
                                                @elseif($pokemon->tipo == 'Normal') bg-gray-400 text-white
                                                @else bg-gray-300 text-gray-800
                                                @endif">
                                                {{ $pokemon->tipo }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 text-sm">Nivel:</span>
                                            <span class="font-semibold text-sm">{{ $pokemon->nivel }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 text-sm">Stats:</span>
                                            <span class="font-semibold text-sm">{{ $pokemon->stats }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Entrenador 2 -->
                    <div class="pl-4">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-2xl font-bold mr-4">
                                {{ substr($combate->entrenador2->nombre, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">
                                    <a href="{{ route('entrenadores.show', $combate->entrenador2) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $combate->entrenador2->nombre }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm">Puntos: {{ $combate->entrenador2->puntos }}</p>
                            </div>
                            @if($combate->resultado == 'entrenador2')
                                <div class="ml-auto">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Ganador
                                    </span>
                                </div>
                            @endif
                        </div>

                        <h4 class="font-semibold text-gray-700 mb-2">Equipo Pokémon:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                            @foreach($combate->entrenador2->pokemon->take(3) as $pokemon)
                                <div class="border rounded-lg overflow-hidden hover:shadow-md">
                                    <div class="p-3
                                        @if($pokemon->tipo == 'Fuego') bg-red-100
                                        @elseif($pokemon->tipo == 'Agua') bg-blue-100
                                        @elseif($pokemon->tipo == 'Planta') bg-green-100
                                        @elseif($pokemon->tipo == 'Eléctrico') bg-yellow-100
                                        @elseif($pokemon->tipo == 'Tierra') bg-yellow-800 text-white
                                        @elseif($pokemon->tipo == 'Roca') bg-gray-400
                                        @elseif($pokemon->tipo == 'Veneno') bg-purple-100
                                        @elseif($pokemon->tipo == 'Psíquico') bg-pink-100
                                        @elseif($pokemon->tipo == 'Hielo') bg-blue-50
                                        @elseif($pokemon->tipo == 'Dragón') bg-indigo-100
                                        @elseif($pokemon->tipo == 'Fantasma') bg-purple-200
                                        @elseif($pokemon->tipo == 'Siniestro') bg-gray-900 text-white
                                        @elseif($pokemon->tipo == 'Acero') bg-gray-300
                                        @elseif($pokemon->tipo == 'Hada') bg-pink-200
                                        @elseif($pokemon->tipo == 'Volador') bg-blue-200
                                        @elseif($pokemon->tipo == 'Lucha') bg-orange-100
                                        @elseif($pokemon->tipo == 'Bicho') bg-green-200
                                        @elseif($pokemon->tipo == 'Normal') bg-gray-100
                                        @else bg-gray-50
                                        @endif">
                                        <div class="flex items-center justify-between">
                                            <h5 class="font-bold">{{ $pokemon->nombre }}</h5>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($pokemon->tipo == 'Fuego') bg-red-500 text-white
                                                @elseif($pokemon->tipo == 'Agua') bg-blue-500 text-white
                                                @elseif($pokemon->tipo == 'Planta') bg-green-500 text-white
                                                @elseif($pokemon->tipo == 'Eléctrico') bg-yellow-500 text-black
                                                @elseif($pokemon->tipo == 'Tierra') bg-yellow-700 text-white
                                                @elseif($pokemon->tipo == 'Roca') bg-gray-600 text-white
                                                @elseif($pokemon->tipo == 'Veneno') bg-purple-500 text-white
                                                @elseif($pokemon->tipo == 'Psíquico') bg-pink-500 text-white
                                                @elseif($pokemon->tipo == 'Hielo') bg-blue-300 text-white
                                                @elseif($pokemon->tipo == 'Dragón') bg-indigo-500 text-white
                                                @elseif($pokemon->tipo == 'Fantasma') bg-purple-600 text-white
                                                @elseif($pokemon->tipo == 'Siniestro') bg-gray-800 text-white
                                                @elseif($pokemon->tipo == 'Acero') bg-gray-500 text-white
                                                @elseif($pokemon->tipo == 'Hada') bg-pink-400 text-white
                                                @elseif($pokemon->tipo == 'Volador') bg-blue-400 text-white
                                                @elseif($pokemon->tipo == 'Lucha') bg-orange-500 text-white
                                                @elseif($pokemon->tipo == 'Bicho') bg-green-600 text-white
                                                @elseif($pokemon->tipo == 'Normal') bg-gray-400 text-white
                                                @else bg-gray-300 text-gray-800
                                                @endif">
                                                {{ $pokemon->tipo }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 text-sm">Nivel:</span>
                                            <span class="font-semibold text-sm">{{ $pokemon->nivel }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 text-sm">Stats:</span>
                                            <span class="font-semibold text-sm">{{ $pokemon->stats }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Resultado del Combate -->
                <div class="mt-6 p-4 rounded-lg 
                    @if($combate->resultado == 'empate') bg-yellow-50 border border-yellow-200
                    @else bg-blue-50 border border-blue-200
                    @endif">
                    <h3 class="text-lg font-bold mb-2 
                        @if($combate->resultado == 'empate') text-yellow-800
                        @else text-blue-800
                        @endif">
                        Resultado del Combate
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="text-center">
                            <span class="block text-xl font-bold">{{ $combate->entrenador1->nombre }}</span>
                            @if($combate->resultado == 'entrenador1')
                                <span class="text-green-600 font-semibold">Ganador</span>
                                <span class="block text-sm text-gray-600">+3 puntos</span>
                            @elseif($combate->resultado == 'empate')
                                <span class="text-yellow-600 font-semibold">Empate</span>
                                <span class="block text-sm text-gray-600">+1 punto</span>
                            @else
                                <span class="text-red-600 font-semibold">Derrotado</span>
                                <span class="block text-sm text-gray-600">+0 puntos</span>
                            @endif
                        </div>

                        <div class="text-center">
                            <div class="flex items-center justify-center">
                                <span class="text-2xl font-bold text-gray-700 mr-2">VS</span>
                                @if($combate->resultado == 'empate')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Empate</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-center">
                            <span class="block text-xl font-bold">{{ $combate->entrenador2->nombre }}</span>
                            @if($combate->resultado == 'entrenador2')
                                <span class="text-green-600 font-semibold">Ganador</span>
                                <span class="block text-sm text-gray-600">+3 puntos</span>
                            @elseif($combate->resultado == 'empate')
                                <span class="text-yellow-600 font-semibold">Empate</span>
                                <span class="block text-sm text-gray-600">+1 punto</span>
                            @else
                                <span class="text-red-600 font-semibold">Derrotado</span>
                                <span class="block text-sm text-gray-600">+0 puntos</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="mt-6 flex justify-end">
                    <form action="{{ route('combates.destroy', $combate) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded flex items-center"
                                onclick="return confirm('¿Estás seguro de querer eliminar este combate? Se restarán los puntos otorgados a los entrenadores.')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Eliminar Combate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection