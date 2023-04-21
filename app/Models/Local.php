<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Local extends Model
{
    use HasFactory;

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(Secretary::class);
    }
    public function movable_propertys(): HasMany
    {
        return $this->hasMany(MovablePropertys::class);
    }

}
