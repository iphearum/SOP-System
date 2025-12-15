<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'version',
        'description',
        'sections_schema',
        'required_metadata',
        'status',
    ];

    protected $casts = [
        'sections_schema' => 'array',
        'required_metadata' => 'array',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
