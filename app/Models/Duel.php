<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Duel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'duels';

    protected $fillable = [
        'chat',
        'duel_type_id'
    ];

    public function duelType(): HasOne
    {
        return $this->hasOne(Type::class);
    }
}
