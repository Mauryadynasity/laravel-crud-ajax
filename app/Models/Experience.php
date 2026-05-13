<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['user_id', 'company_name', 'description'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
