<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealStateProperty extends Model
{
    use HasFactory;

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(Secretary::class);
    }

    public function acquisition_type(): BelongsTo
    {
        return $this->belongsTo(AcquisitionType::class);
    }
}
