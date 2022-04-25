<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $tnx_type_name
 */
class TnxType extends Model
{
    use HasFactory;
    protected $primaryKey = "tnx_type_id";
}
