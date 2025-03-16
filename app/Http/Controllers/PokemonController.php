<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Entrenador;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pokemon::query();
    
        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        // Filtro por estado (capturado/disponible)
        if ($request->filled('estado')) {
            if ($request->estado == 'disponible') {
                $query->whereNull('entrenador_id');
            } elseif ($request->estado == 'capturado') {
                $query->whereNotNull('entrenador_id');
            }
        }
        
        // Filtro por búsqueda (nombre)
        if ($request->filled('busqueda')) {
            $query->where('nombre', 'LIKE', '%' . $request->busqueda . '%');
        }
        
        // Realizar la consulta y obtener resultados
        $pokemon = $query->with('entrenador')->get();
        
        return view('pokemon.index', compact('pokemon'));
    }

    /**
     * Show available pokemon.
     * Modificado para manejar mejor los diferentes casos de redirección.
     */
    public function available(Request $request)
    {
        // Log de diagnóstico
        \Log::info('Método available llamado con request: ' . json_encode($request->all()));
        
        $entrenador_id = $request->input('entrenador_id');
        $entrenador = null;

        if ($entrenador_id) {
            // Intenta encontrar el entrenador
            try {
                $entrenador = Entrenador::findOrFail($entrenador_id);
                
                if ($entrenador->pokemon->count() >= 3) {
                    return redirect()->route('entrenadores.show', $entrenador)
                        ->with('error', 'Este entrenador ya ha alcanzado el máximo permitido de pokemons.');
                }
            } catch (\Exception $e) {
                \Log::error('Error al buscar entrenador: ' . $e->getMessage());
                // Si no se encuentra el entrenador, continuamos sin él
            }
        }

        $pokemonDisponibles = Pokemon::whereNull('entrenador_id')->get();

        if ($pokemonDisponibles->isEmpty() && $entrenador) {
            return redirect()->route('entrenadores.show', $entrenador)
                ->with('info', 'No hay pokemon disponibles para capturar en este momento.');
        } elseif ($pokemonDisponibles->isEmpty()) {
            return redirect()->route('pokemon.index')
                ->with('info', 'No hay pokemon disponibles para capturar en este momento.');
        }

        try {
            // Intenta renderizar la vista
            return view('pokemon.available', compact('pokemonDisponibles', 'entrenador'));
        } catch (\Exception $e) {
            \Log::error('Error al renderizar vista available: ' . $e->getMessage());
            // Fallback a la vista index
            return redirect()->route('pokemon.index')
                ->with('error', 'Hubo un problema al mostrar los Pokémon disponibles. Por favor, inténtalo más tarde.');
        }
    }

    /**
     * Assign a Pokemon to a trainer
     */
    public function capture(Request $request, Pokemon $pokemon)
    {
        // Log para diagnóstico
        \Log::info('Método capture llamado para pokemon ID: ' . $pokemon->id);
        
        try {
            $validated = $request->validate([
                'entrenador_id' => 'required|exists:entrenadores,id'
            ]);

            $entrenador = Entrenador::findOrFail($validated['entrenador_id']);
            if ($entrenador->pokemon->count() >= 3) {
                return redirect()->route('entrenadores.show', $entrenador)
                    ->with('error', 'Este entrenador ya tiene el máximo de 3 Pokémon permitidos.');
            }

            if ($pokemon->entrenador_id !== null) {
                return redirect()->route('pokemon.available', ['entrenador_id' => $entrenador->id])
                    ->with('error', 'Este Pokemon ya ha sido capturado por otro entrenador.');
            }

            $pokemon->entrenador_id = $entrenador->id;
            $pokemon->save();

            return redirect()->route('entrenadores.show', $entrenador)
                ->with('success', 'Has capturado un ' . $pokemon->nombre . ' con éxito.');
        } catch (\Exception $e) {
            \Log::error('Error en método capture: ' . $e->getMessage());
            return redirect()->route('pokemon.index')
                ->with('error', 'Ha ocurrido un error al intentar capturar el Pokémon. Por favor, inténtalo más tarde.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pokemon $pokemon)
    {
        $pokemon->load('entrenador');
        return view('pokemon.show', compact('pokemon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pokemon $pokemon)
    {
        $entrenadores = Entrenador::all();
        return view('pokemon.edit', compact('pokemon', 'entrenadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pokemon $pokemon)
    {
        $validated = $request->validate([
            'nivel' => 'required|integer|min:1|max:100',
            'entrenador_id' => 'required|exists:entrenadores,id'
        ]);

        if (isset($validated['entrenador_id']) && $pokemon->entrenador_id != $validated['entrenador_id']){
            $entrenador = Entrenador::findOrFail($validated['entrenador_id']);
            if($entrenador->pokemon->count() >= 3){
                return back()->withErrors(['entrenador_id' => 'El entrenador ya ha alcanzado el máximo de pokemons'])
                    ->withInput();
            }
        }

        $pokemon->update($validated);

        return redirect()->route('pokemon.show', $pokemon)->with('success', 'Pokemon actualizado correctamente');
    }
    
    /**
     * Release a Pokemon from trainer
     */ 
    public function release(Pokemon $pokemon){
        if($pokemon->entrenador_id === null){
            return redirect()->route('pokemon.index')
            ->with('error', 'Este pokemon ya está liberado.');
        }

        $entrenador = $pokemon->entrenador;
        $pokemon->entrenador_id = null;
        $pokemon->save();

        return redirect()->route('entrenadores.show', $entrenador)
        ->with('success', 'Has liberado a ' . $pokemon->nombre . ' con éxito.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pokemon $pokemon)
    {
        if ($pokemon->entrenador_id !== null) {
            return $this->release($pokemon);
        }
        
        return redirect()->route('pokemon.index')
            ->with('info', 'Los Pokémon no pueden ser eliminados, solo liberados si tienen entrenador.');
    }
}