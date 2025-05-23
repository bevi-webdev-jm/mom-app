<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Elouqnt\SoftDeletes;
use Illuminate\Support\Facades\Session;

class MomAction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'mom_detail_id',
        'user_id',
        'action_taken',
        'remarks',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }
}
