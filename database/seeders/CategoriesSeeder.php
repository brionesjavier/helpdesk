<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // Datos de ejemplo para las categorías
        //categorias => descripcion
        $categories = [
            'Software' => 'Requerimientos relacionados con software y aplicaciones.',
            'Hardware' => 'Requerimientos relacionados con equipos y componentes físicos.',
            'Conectividad' => 'Requerimientos relacionados con redes y conexiones.',
            'Consultas y Sugerencias' => 'Requerimientos para consultas y sugerencias generales.',
            'Reclamos' => 'Requerimientos relacionados con quejas y reclamos.',
        ];

        // Insertar datos en la tabla 'categories'
        foreach ($categories as $name => $description) {
            Category::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }
    }
}

