<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $card_pan_no)
 */
class CardInventory extends Model
{
    use HasFactory;
    protected $primaryKey = "card_inventory_id";
}
