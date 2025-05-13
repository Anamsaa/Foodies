<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Province;
use App\Models\City;
class CitySeeder extends Seeder
{
    public function run(): void
    {
        $provinces = Cache::remember('provinces_list', 60 * 60, function () {
            return Province::all();
        });

        foreach ($provinces as $province) {
            $page = 1;

            do {
                $response = Http::get(config('services.geoapi.base_url') . 'municipios', [
                    'CPRO' => $province->codigo,
                    'type' => 'JSON',
                    'version' => '2025.01',
                    'key' => config('services.geoapi.key'),
                    'page' => $page,
                ]);

                if ($response->failed()) {
                    break;
                }

                $data = $response->json();

                $batch = [];
                foreach ($data['data'] as $item) {
                    $batch[] = [
                        'codigo' => $item['CMUN'],
                        'nombre' => $item['DMUN50'],
                        'province_id' => $province->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                City::insert($batch);
                $page++;

            } while ($data['next'] !== null);
        }
    }
}
