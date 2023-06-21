<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'answers';

    protected $fillable = [
        'name',
        'type_id',
        'short_url',
        'medium_url',
        'large_url',
        'full_url',
        'is_active'
    ];
}
