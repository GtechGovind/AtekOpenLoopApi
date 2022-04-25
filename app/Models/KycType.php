<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $kyc_type_name
 */
class KycType extends Model
{
    use HasFactory;
    protected $primaryKey = "kyc_type_id";
}
