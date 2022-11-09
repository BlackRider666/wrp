<?php

use App\Models\Country\City\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = \App\Models\Country\Country::where('name','Україна')->first();

        City::create([
            'country_id' => $country->getKey(),
            'name'       => 'Київ'
        ]);
        City::create([
            'country_id' => $country->getKey(),
            'name'       => 'Харків'
        ]);
        City::create([
            'country_id' => $country->getKey(),
            'name'       => 'Львів'
        ]);
        City::create([
            'country_id' => $country->getKey(),
            'name'       => 'Одеса'
        ]);
    }
}
