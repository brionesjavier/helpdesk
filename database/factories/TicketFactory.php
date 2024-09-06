<?php

namespace Database\Factories;

use App\Models\Element;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,  // Genera un título aleatorio
            'description' => $this->faker->paragraph,  // Genera una descripción aleatoria

            // En lugar de generar nuevos, selecciona registros existentes
            'created_by' => User::inRandomOrder()->first()->id,  // Usuario existente aleatorio
            'state_id' => State::inRandomOrder()->first()->id,  // Estado existente aleatorio
            'element_id' => Element::inRandomOrder()->first()->id,  // Elemento existente aleatorio

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
