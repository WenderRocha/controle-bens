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

}
