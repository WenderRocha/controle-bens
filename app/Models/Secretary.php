<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Secretary extends Model
{
    use HasFactory;

    public function locals(): HasMany
    {
        return $this->hasMany(Local::class);
    }

    public function movable_propertys(): HasMany
    {
        return $this->hasMany(MovablePropertys::class);
    }

    public function real_state_propertys(): HasMany
    {
        return $this->hasMany(MovablePropertys::class);
    }

}
