<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['id' => 1, 'name' => 'Pendiente'],
            ['id' => 2, 'name' => 'Asignado'],
            ['id' => 3, 'name' => 'En Proceso'],
            ['id' => 4, 'name' => 'Solucionado'],
            ['id' => 5, 'name' => 'Objetado'],
            ['id' => 6, 'name' => 'Derivado'],
            ['id' => 7, 'name' => 'Programado'],
            ['id' => 8, 'name' => 'Finalizado'],
            ['id' => 9, 'name' => 'Cancelado'],
        ];

        foreach ($states as $state) {
            State::updateOrCreate(
                ['id' => $state['id']], // Condición para encontrar el registro existente
                ['name' => $state['name'],
                'is_active'=>true ], // Datos a actualizar o crear
                
            );
        }
    }


}
