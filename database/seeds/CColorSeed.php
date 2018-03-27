<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CColorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseColors = ['white','black','space grey','rose','rose gold','brown','red','blue','dark sky','light blue'];
        if (Schema::hasTable('colors'))
        {
            foreach ($baseColors as $baseColor) {
                \App\Color::create([
                    'name' => $baseColor,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
            }
        }
    }
}
