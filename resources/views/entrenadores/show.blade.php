@extends('layouts.app')

@section('title', 'Perfil de Entrenador: ' . $entrenador->nombre)

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Información del Entrenador -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="h-24 w-24 bg-red-100 text-red-800 rounded-full flex items-center justify-center text-4xl font-bold mb-4">
                        {{ substr($entrenador->nombre, 0, 1) }}
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $entrenador->nombre }}</h1>
                    <p class="text-gray-600">{{ $entrenador->email }}</p>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Puntos:</span>
                        <span class="font-semibold {{ $entrenador->puntos > 50 ? 'text-green-600' : 'text-gray-800' }}">
                            {{ $entrenador->puntos }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Fecha de registro:</span>
                        <span class="font-semibold">{{ $entrenador->fecha_registro ? $entrenador->fecha_registro->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Total de Pokémon:</span>
                        <span class="font-semibold text-blue-600">{{ $entrenador->pokemon->count() }}</span>
                    </div>
                </div>
                
                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('entrenadores.edit', $entrenador) }}" 
                       class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('entrenadores.destroy', $entrenador) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded"
                                onclick="return confirm('¿Estás seguro de querer eliminar este entrenador?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
                
                <a href="{{ route('entrenadores.index') }}" class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver al listado
                </a>
            </div>
        </div>
        
        <!-- Lista de Pokémon del Entrenador -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Pokémon de {{ $entrenador->nombre }}</h2>
                    <a href="{{ route('pokemon.available', ['entrenador_id' => $entrenador->id]) }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded inline-flex items-center">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                             <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                         </svg>
                         Agregar Pokémon
                     </a>
                </div>
                
                @if($entrenador->pokemon->isEmpty())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                        Este entrenador aún no tiene ningún Pokémon registrado.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($entrenador->pokemon as $pokemon)
                            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                <div class="p-4 
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
                                        <h3 class="text-lg font-bold">{{ $pokemon->nombre }}</h3>
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
                                <div class="p-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Nivel:</span>
                                        <span class="font-semibold">{{ $pokemon->nivel }}</span>
                                    </div>
                                    
                                    @if(isset($pokemon->stats))
                                        <div class="mt-2">
                                            <h4 class="text-sm font-semibold text-gray-600 mb-1">Estadísticas:</h4>
                                            <div class="text-sm">{{ $pokemon->stats }}</div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-4 flex space-x-2">
                                        <a href="{{ route('pokemon.show', $pokemon) }}" class="text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('pokemon.edit', $pokemon) }}" class="text-yellow-600 hover:text-yellow-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('pokemon.destroy', $pokemon) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" 
                                                    onclick="return confirm('¿Estás seguro de querer eliminar este Pokémon?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection