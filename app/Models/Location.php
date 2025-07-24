<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'location_name',
        'address',
    ];

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
