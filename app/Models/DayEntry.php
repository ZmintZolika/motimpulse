<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'mood',
        'weather',
        'sleep_quality',
        'activity',
        'health_action',
        'score',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'mood' => 'integer',
        'score' => 'integer',
    ];

    // KAPCSOLAT: Egy day_entry egy user-hez tartozik
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
