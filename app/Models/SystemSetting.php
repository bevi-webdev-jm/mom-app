<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_per_page',
        'email_sending',
        'alarm_on',
        'fire_alarm_on',
        'notification_days_before',
    ];

    /**
     * Dynamically set the database connection based on the session.
     */
    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql'); // Default to 'mysql' if not set
    }
}
