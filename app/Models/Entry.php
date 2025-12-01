<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Entry extends Model
{
    use SoftDeletes;
    protected $table = 'entries';
    protected $primaryKey = 'entry_id';
    public $timestamps = true;
    protected $fillable = [
    'user_id',
    'quote_id',
    'mood',
    'weather',
    'sleep_quality',
    'activities',
    'health_action',
    'note',
    'is_deleted'
];

public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}

public function quote()
{
    return $this->belongsTo(Quote::class, 'quote_id', 'quote_id');
}

}
