<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class MomActionAttachment extends Model
{
    use HasFactory;
    use SofrDeletes;

    protected $fillable = [
        'mom_action_id',
        'path',
        'remarks',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }
}
