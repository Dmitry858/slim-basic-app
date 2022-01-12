<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'title',
        'link',
        'parent_id',
    ];
}