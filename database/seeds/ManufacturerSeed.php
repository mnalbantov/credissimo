<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ManufacturerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseManufacturers = ['Apple','Samsung','Lenovo','Microsoft','Huawei','Nokia'];
        if (Schema::hasTable('manufacturers'))
        {
            foreach ($baseManufacturers as $baseManufacturer) {
                \App\Manufacturer::create([
                    'name' => $baseManufacturer,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
            }
        }
    }
}
