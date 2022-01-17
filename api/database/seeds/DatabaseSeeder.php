<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            SuperAdminSeeder::class,
            ArticleCategorySeeder::class,
            LocaleSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            TransactionStatusSeeder::class,
        ]);
    }
}
