<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BvLog extends Model
{
    protected $table = 'bv_logs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
