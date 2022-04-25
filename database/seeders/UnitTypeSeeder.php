<?php

namespace Database\Seeders;

use App\Models\UnitType;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitType1 = new UnitType();
        $unitType1->unit_type_name = "Hour";
        $unitType1->save();

        $unitType2 = new UnitType();
        $unitType2->unit_type_name = "Minute";
        $unitType2->save();

        $unitType3 = new UnitType();
        $unitType3->unit_type_name = "Second";
        $unitType3->save();

    }
}
