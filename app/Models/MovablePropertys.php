<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovablePropertys extends Model
{
    use HasFactory;

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(Secretary::class);
    }

    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departaments::class);
    }

    public function conservationState(): BelongsTo
    {
        return $this->belongsTo(ConservationState::class);
    }

    public function aquisitionType(): BelongsTo
    {
        return $this->belongsTo(AcquisitionType::class);
    }
}
