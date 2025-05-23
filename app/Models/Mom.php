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
        'mom_number',
        'agenda',
        'target_date',
        'status',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }
}
