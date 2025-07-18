<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class MomDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'mom_id',
        'topic',
        'next_step',
        'target_date',
        'completed_date',
        'remarks',
        'status',
    ];

    protected $casts = [
        'target_date' => 'datetime',
        'completed_date' => 'datetime',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }

    public function mom() {
        return $this->belongsTo('App\Models\Mom');
    }

    public function actions() {
        return $this->hasMany('App\Models\MomAction');
    }

    public function responsibles() {
        return $this->belongsToMany('App\Models\User', 'mom_responsibles');
    }
}
