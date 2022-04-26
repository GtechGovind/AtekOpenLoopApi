<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed cust_id
 * @property mixed card_pan_no
 * @property mixed card_cvv_no
 * @property mixed card_expiry
 * @property bool|mixed is_blocked
 */
class IssueCard extends Model
{
    use HasFactory;
    protected $primaryKey = "issue_card_id";
}
