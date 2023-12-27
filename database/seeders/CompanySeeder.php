<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'nombre_de_la_compañia' => 'Empresa 1',
        ]);

        Company::create([
            'nombre_de_la_compañia' => 'Empresa 2',
        ]);

        Company::create([
            'nombre_de_la_compañia' => 'Empresa 3',
        ]);

        Company::create([
            'nombre_de_la_compañia' => 'Empresa 4',
        ]);

        Company::create([
            'nombre_de_la_compañia' => 'Empresa 5',
        ]);
    }
}
