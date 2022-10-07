<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->hasMany(Company::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
