<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Pages\Page::create([
            'key' => 'contacts',
            'title' => [
                'en' => 'Contacts',
                'ua' => 'Контакти',
            ],
            'content' => [
                'en' => '',
                'ua' => '',
            ],
        ]);
    }
}
