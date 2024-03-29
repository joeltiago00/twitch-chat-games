<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Duel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'duels';

    protected $fillable = [
        'chat',
        'type_id',
        'duration_time',
        'finished_at'
    ];

    protected $casts = [
        'type_id' => 'integer',
        'duration_time' => 'integer',
        'finished_at' => 'datetime',

    ];

    public function type(): HasOne
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class, 'duel_id', 'id');
    }
}
