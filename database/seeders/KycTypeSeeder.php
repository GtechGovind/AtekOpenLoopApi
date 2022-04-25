<?php

namespace Database\Seeders;

use App\Models\KycType;
use Illuminate\Database\Seeder;

class KycTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kycType1 = new KycType();
        $kycType1->kyc_type_name = "Min KYC";
        $kycType1->save();

        $kycType2 = new KycType();
        $kycType2->kyc_type_name = "Full KYC";
        $kycType2->save();
    }
}
