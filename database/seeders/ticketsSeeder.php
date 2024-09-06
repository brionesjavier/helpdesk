<?php

namespace Database\Seeders;

use App\Models\Element;
use App\Models\State;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ticketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::inRandomOrder()->first(); // Selecciona un usuario aleatorio
        $state = State::inRandomOrder()->first(); // Selecciona un estado aleatorio de los existentes
        $element = Element::inRandomOrder()->first(); // Selecciona un elemento aleatorio

        // Crea 10 tickets utilizando los estados, usuarios y elementos existentes
        Ticket::factory()->count(200)->create([
            'created_by' => $user->id,
            'state_id' => $state->id,
            'element_id' => $element->id,
        ]);
    }
}
