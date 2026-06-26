<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Position extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'requirements',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;

        if (!isset($this->attributes['slug']) || $this->attributes['slug'] === '') {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}
