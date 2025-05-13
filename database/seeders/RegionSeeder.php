<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get(config('services.geoapi.base_url') . 'comunidades', [
            'type' => 'JSON',
            'version' => '2025.01',
            'key' => config('services.geoapi.key'),
        ]);

        //dd($response->status(),$response->json());

        if ($response->successful()) {
            foreach ($response->json()['data'] as $item) {
                //dd($item);
                Region::updateOrCreate(
                    ['codigo' => $item['CCOM']],
                    ['nombre' => $item['COM']]
                );
            }
        } else {
            echo "Error al obtener los datos de la API.";
        }
    }
}
