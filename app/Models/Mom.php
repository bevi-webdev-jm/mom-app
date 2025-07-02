<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class Mom extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'mom_type_id',
        'user_id',
        'mom_number',
        'agenda',
        'meeting_date',
        'status',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }

    public function type() {
        return $this->belongsTo('App\Models\MomType', 'mom_type_id');
    }

    public function details() {
        return $this->hasMany('App\Models\MomDetail');
    }

    public function participants() {
        return $this->belongsToMany('App\Models\User', 'mom_participants');
    }

    public function approvals() {
        return $this->hasMany('App\Models\MomApproval');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
