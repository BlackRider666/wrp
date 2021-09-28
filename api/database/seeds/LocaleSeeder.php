<?php

use Illuminate\Database\Seeder;
use App\Models\Locale\Locale;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Locale::create([
            'name' => 'English',
            'iso_code' => 'en',
            'is_active' => true,
        ]);
    }
}
