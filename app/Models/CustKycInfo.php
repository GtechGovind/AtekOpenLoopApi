<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $mobile_no)
 * @method create(array $data)
 * @property mixed $cust_id
 */
class CustKycInfo extends Model
{
    use HasFactory;
    protected $primaryKey = "cust_id";
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'mobile_no',
        'date_of_birth',
        'kyc_type_id',
        'ovd_type_id',
        'ovd_no',
    ];
}
