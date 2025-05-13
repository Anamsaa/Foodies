<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Region;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get(config('services.geoapi.base_url') . 'provincias', [
            'type' => 'JSON',
            'version' => '2025.01',
            'key' => config('services.geoapi.key'),
        ]);

        #dd($response->json());

        if ($response->failed()) {
            throw new \Exception('Error al intentar cargar las provincias');
        }

        foreach ($response->json()['data'] as $item) {

            $region = Region::where('codigo', $item['CCOM']) ->first();

            if($region) {
                Province::updateOrCreate(
                    ['codigo' => $item['CPRO']],
                    [
                        'nombre' => $item['PRO'],
                        'region_id' => $region->id,
                    ]
                );
            }
            
        }
    }
}
