<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcquisitionType extends Model
{
    use HasFactory;

    public function movable_propertys(): HasMany
    {
        return $this->hasMany(MovablePropertys::class);
    }
}
