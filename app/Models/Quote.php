<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;
    
    protected $table = 'quotes';
    protected $primaryKey = 'quote_id';
    public $timestamps = true;
    
    protected $fillable = [
        'quote_category',
        'quote_text',
        'author',
    ];
    
    // Kapcsolat Entry-vel
    public function entries()
    {
        return $this->hasMany(Entry::class, 'quote_id', 'quote_id');
    }
}
