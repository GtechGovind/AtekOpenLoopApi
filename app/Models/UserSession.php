<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed $otp
 * @property Carbon|mixed $otp_created_at
 * @property mixed $otp_expires_at
 * @property mixed $mobile_no
 * @method static where(string $string, mixed $otp)
 */
class UserSession extends Model
{
    use HasFactory;
    protected $primaryKey = "user_session_id";
}
