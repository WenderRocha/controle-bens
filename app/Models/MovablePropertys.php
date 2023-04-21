<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MovablePropertys extends Model
{
    use HasFactory;

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(Secretary::class);
    }

    public function conservation_type(): BelongsTo
    {
        return $this->belongsTo(ConservationState::class);
    }

    public function acquisition_type(): BelongsTo
    {
        return $this->belongsTo(AcquisitionType::class);
    }

    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departaments::class);
    }

    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class);
    }
}
