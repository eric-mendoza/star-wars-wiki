<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['endpoint', 'duration', 'ip', 'location', 'browser', 'created_at'];
}
