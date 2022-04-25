<?php

namespace Database\Seeders;

use App\Models\TnxType;
use Illuminate\Database\Seeder;

class TnxTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tnxType1 = new TnxType();
        $tnxType1->tnx_type_name = "Credit";
        $tnxType1->save();

        $tnxType2 = new TnxType();
        $tnxType2->tnx_type_name = "Debit";
        $tnxType2->save();
    }
}
