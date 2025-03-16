@extends('layouts.app')

@section('title', 'Bienvenido a la Liga Pokémon')

@section('content')
<div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Liga Pokémon</h1>
        <p class="text-xl mb-8">¡Forma tu equipo, entrena a tus Pokémon y conviértete en el mejor entrenador!</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('entrenadores.index') }}" class="bg-white text-blue-600 hover:bg-blue-100 font-bold py-3 px-6 rounded-lg transition duration-300">
                Ver Entrenadores
            </a>
            <a href="{{ route('combates.create') }}" class="bg-yellow-400 text-gray-800 hover:bg-yellow-300 font-bold py-3 px-6 rounded-lg transition duration-300">
                Iniciar Combate
            </a>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <!-- Estadísticas Generales -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Estadísticas de la Liga</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-5xl font-bold text-blue-600 mb-2">{{ \App\Models\Entrenador::count() }}</div>
                <div class="text-gray-600 text-lg">Entrenadores</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-5xl font-bold text-green-600 mb-2">{{ \App\Models\Pokemon::count() }}</div>
                <div class="text-gray-600 text-lg">Pokémon</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-5xl font-bold text-red-600 mb-2">{{ \App\Models\Combate::count() }}</div>
                <div class="text-gray-600 text-lg">Combates</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-5xl font-bold text-purple-600 mb-2">
                    @php
                        $tipos = \App\Models\Pokemon::select('tipo')->distinct()->count();
                    @endphp
                    {{ $tipos }}
                </div>
                <div class="text-gray-600 text-lg">Tipos de Pokémon</div>
            </div>
        </div>
    </div>
    
    <!-- Entrenadores Top -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Mejores Entrenadores</h2>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posición
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Entrenador
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pokémon
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Puntos
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $topEntrenadores = \App\Models\Entrenador::orderBy('puntos', 'desc')->take(5)->get();
                        $posicion = 1;
                    @endphp
                    
                    @foreach($topEntrenadores as $entrenador)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br 
                                        @if($posicion == 1) from-yellow-300 to-yellow-500
                                        @elseif($posicion == 2) from-gray-300 to-gray-400
                                        @elseif($posicion == 3) from-yellow-600 to-yellow-800
                                        @else from-blue-300 to-blue-500
                                        @endif 
                                        rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $posicion }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('entrenadores.show', $entrenador) }}" class="hover:text-blue-600">
                                                {{ $entrenador->nombre }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $entrenador->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $entrenador->pokemon->count() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $entrenador->puntos }} puntos
                                </span>
                            </td>
                        </tr>
                        @php $posicion++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Últimos Combates -->
    <div>
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Combates Recientes</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $combatesRecientes = \App\Models\Combate::with(['entrenador1', 'entrenador2'])
                    ->orderBy('fecha', 'desc')
                    ->take(4)
                    ->get();
            @endphp
            
            @if($combatesRecientes->isEmpty())
                <div class="md:col-span-2 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    No hay combates registrados en el sistema.
                </div>
            @else
                @foreach($combatesRecientes as $combate)
                    <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-center mb-4">
                            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($combate->fecha)->format('d/m/Y') }}</div>
                            <a href="{{ route('combates.show', $combate) }}" class="text-sm text-blue-600 hover:text-blue-800">Ver detalles</a>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-center flex-1">
                                <a href="{{ route('entrenadores.show', $combate->entrenador1) }}" class="text-blue-600 hover:text-blue-800 font-semibold block">
                                    {{ $combate->entrenador1->nombre }}
                                </a>
                                <span class="text-sm text-gray-600">{{ $combate->entrenador1->pokemon->count() }} Pokémon</span>
                            </div>
                            
                            <div class="text-center mx-4">
                                <span class="font-bold text-lg">VS</span>
                            </div>
                            
                            <div class="text-center flex-1">
                                <a href="{{ route('entrenadores.show', $combate->entrenador2) }}" class="text-blue-600 hover:text-blue-800 font-semibold block">
                                    {{ $combate->entrenador2->nombre }}
                                </a>
                                <span class="text-sm text-gray-600">{{ $combate->entrenador2->pokemon->count() }} Pokémon</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            @if($combate->resultado == 'entrenador1')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Victoria para {{ $combate->entrenador1->nombre }}
                                </span>
                            @elseif($combate->resultado == 'entrenador2')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Victoria para {{ $combate->entrenador2->nombre }}
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Empate
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('combates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Ver Todos los Combates
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Sección Informativa con Iconos -->
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">¿Cómo funciona la Liga Pokémon?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Registra Entrenadores</h3>
                <p class="text-gray-600">Añade entrenadores a la liga con sus datos personales y establece su perfil.</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Captura Pokémon</h3>
                <p class="text-gray-600">Los entrenadores pueden capturar y entrenar Pokémon para formar su equipo de batalla.</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">¡Combate!</h3>
                <p class="text-gray-600">Organiza combates entre entrenadores, gana puntos y escala en el ranking de la liga.</p>
            </div>
        </div>
    </div>
</div>
@endsection