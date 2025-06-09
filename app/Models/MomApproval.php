<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class MomApproval extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'mom_id',
        'user_id',
        'status',
        'remarks',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }

    public function mom() {
       return $this->belongsTo('App\Models\Mom'); 
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
