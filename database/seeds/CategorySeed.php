<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseCategories = ['New Brands','Second Hand','Parts','Hardware','Specials','Sales'];
        if (Schema::hasTable('categories'))
        {
            foreach ($baseCategories as $baseCategory) {
                \App\Category::create([
                    'CategoryName' => $baseCategory,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
            }
        }
    }
}
