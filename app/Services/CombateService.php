<?php

namespace App\Services;

use App\Models\Entrenador;

class CombateService
{
	/**
     * Realiza un combate entre dos entrenadores
     * 
     * @param Entrenador $entrenador1
     * @param Entrenador $entrenador2
     * @return array Resultado del combate con puntos asignados
     */

     public function realizarCombate(Entrenador $entrenador1, Entrenador $entrenador2){

        $pokemonEntrenador1 = $entrenador1->pokemon;
        $pokemonEntrenador2 = $entrenador2->pokemon;

        $victoriasEntrenador1 = 0;
        $victoriasEntrenador2 = 0;

        for($i = 0; $i < min(count($pokemonEntrenador1), count($pokemonEntrenador2)); $i ++){

            $statsPokemon1 = $pokemonEntrenador1[$i]->stats;
            $statsPokemon2 = $pokemonEntrenador2[$i]->stats;

            if($statsPokemon1 > $statsPokemon2){
                $victoriasEntrenador1++;
            }else if($statsPokemon2 > $statsPokemon1){
                $victoriasEntrenador2++;
            }
        }
        $resultado = '';
        $puntosEntrenador1 = 0;
        $puntosEntrenador2 = 0;

        if($victoriasEntrenador1 > $victoriasEntrenador2){
            $resultado = 'entrenador1';
            $puntosEntrenador1 = 3;
        }else if($victoriasEntrenador2 > $victoriasEntrenador1){
            $resultado = 'entrenador2';
            $puntosEntrenador2 = 3;
        }else{
            $resultado = 'empate';
            $puntosEntrenador1 = 1;
            $puntosEntrenador2 = 1;
        }

        return [
            'resultado' => $resultado,
            'victorias_entrenador1' => $victoriasEntrenador1,
            'victorias_entrenador2' => $victoriasEntrenador2,
            'puntos_entrenador1' => $puntosEntrenador1,
            'puntos_entrenador2' => $puntosEntrenador2
        ];
     }
}

