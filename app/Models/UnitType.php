<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $unit_type_name
 */
class UnitType extends Model
{
    use HasFactory;
    protected $primaryKey = "unit_type_id";
}
