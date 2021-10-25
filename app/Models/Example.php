<?php

namespace App\Models;

use App\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Resource
{
    protected $fillable = [
        'field2',
        'field3',
        'field4',
    ];    
}
