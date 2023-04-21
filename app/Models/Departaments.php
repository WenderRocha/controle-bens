<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departaments extends Model
{
    use HasFactory;

    public function movable_property(): HasMany
    {
        return $this->hasMany(MovablePropertys::class);
    }

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(Secretary::class);
    }
}
