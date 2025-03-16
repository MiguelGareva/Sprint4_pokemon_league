@extends('layouts.app')

@section('title', 'Crear Nuevo Combate')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex items-center">
        <a href="{{ route('combates.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a combates
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Combate</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <p class="font-bold">Por favor corrige los siguientes errores:</p>
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 mb-6">
            Para crear un combate se necesita seleccionar dos entrenadores con al menos 3 Pokémon cada uno. 
            El combate se realizará automáticamente comparando los stats de los primeros 3 Pokémon de cada entrenador.
        </p>

        <form action="{{ route('combates.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Selección de Entrenador 1 -->
                <div class="mb-4">
                    <label for="entrenador1_id" class="block text-gray-700 font-bold mb-2">Entrenador 1</label>
                    <select name="entrenador1_id" id="entrenador1_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('entrenador1_id') border-red-500 @enderror" required>
                        <option value="">Selecciona un entrenador</option>
                        @foreach($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}" {{ old('entrenador1_id') == $entrenador->id ? 'selected' : '' }}>
                                {{ $entrenador->nombre }} ({{ $entrenador->pokemon->count() }} Pokémon)
                            </option>
                        @endforeach
                    </select>
                    @error('entrenador1_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Selección de Entrenador 2 -->
                <div class="mb-4">
                    <label for="entrenador2_id" class="block text-gray-700 font-bold mb-2">Entrenador 2</label>
                    <select name="entrenador2_id" id="entrenador2_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('entrenador2_id') border-red-500 @enderror" required>
                        <option value="">Selecciona un entrenador</option>
                        @foreach($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}" {{ old('entrenador2_id') == $entrenador->id ? 'selected' : '' }}>
                                {{ $entrenador->nombre }} ({{ $entrenador->pokemon->count() }} Pokémon)
                            </option>
                        @endforeach
                    </select>
                    @error('entrenador2_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-600 text-xs mt-1">Selecciona un entrenador diferente al primero.</p>
                </div>
            </div>

            <!-- Fecha del Combate -->
            <div class="mb-6">
                <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha del Combate</label>
                <input type="date" name="fecha" id="fecha" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('fecha') border-red-500 @enderror"
                       value="{{ old('fecha', date('Y-m-d')) }}" 
                       required>
                @error('fecha')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Reglas del Combate</h3>
                <ul class="list-disc pl-5 text-gray-600">
                    <li class="mb-1">Se compararán los stats de los primeros 3 Pokémon de cada entrenador.</li>
                    <li class="mb-1">El entrenador con más victorias individuales gana el combate.</li>
                    <li class="mb-1">El ganador recibe 3 puntos, en caso de empate ambos reciben 1 punto.</li>
                    <li class="mb-1">Los Pokémon se comparan en el orden en que aparecen en el perfil del entrenador.</li>
                </ul>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('combates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Iniciar Combate
                </button>
            </div>
        </form>
    </div>
</div>
@endsection