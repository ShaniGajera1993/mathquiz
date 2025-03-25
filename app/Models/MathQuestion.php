<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MathQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'game',
        'difficulty',
        'level',
        'question',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
