<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $fillable = [
        'key',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}