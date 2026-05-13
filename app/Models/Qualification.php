<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = ['user_id', 'qualification_name'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
