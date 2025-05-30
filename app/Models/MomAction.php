<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function detail() {
        return $this->belongsTo('App\Models\MomDetail');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function attachments() {
        return $this->hasMany('App\Models\MomActionAttachment');
    }
}
