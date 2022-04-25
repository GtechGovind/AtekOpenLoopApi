<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $ovd_type_name
 */
class OvdType extends Model
{
    use HasFactory;
    protected $primaryKey = "ovd_type_id";
}
