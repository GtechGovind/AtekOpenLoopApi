<?php

namespace Database\Seeders;

use App\Models\OvdType;
use Illuminate\Database\Seeder;

class OvdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ovdType1 = new OvdType();
        $ovdType1->ovd_type_name = "Aadhar Card";
        $ovdType1->save();

        $ovdType2 = new OvdType();
        $ovdType2->ovd_type_name = "Pan Card";
        $ovdType2->save();

        $ovdType3 = new OvdType();
        $ovdType3->ovd_type_name = "Voter Card";
        $ovdType3->save();
    }
}
