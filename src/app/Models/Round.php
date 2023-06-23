<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Round extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rounds';

    protected $fillable = [
        'duel_id',
        'answer_id',
        'answer_number'
    ];

    public function duel(): HasOne
    {
        return $this->hasOne(Duel::class, 'id', 'duel_id');
    }

    public function answer(): HasOne
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
    }
}
