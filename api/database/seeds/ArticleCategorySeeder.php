<?php

use App\Models\Article\Category\Category;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Article',
            'tech_name' => 'article',
        ]);
        Category::create([
            'title' => 'Book',
            'tech_name' => 'book',
        ]);
        Category::create([
            'title' => 'Conference',
            'tech_name' => 'conference',
        ]);
        Category::create([
            'title' => 'Patent',
            'tech_name' => 'patent',
        ]);
        Category::create([
            'title' => 'Guidelines',
            'tech_name' => 'guidelines',
        ]);
        Category::create([
            'title' => 'Section',
            'tech_name' => 'section',
        ]);
    }
}
