<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (blank($search)) {
            return $query;
        }

        return $query->where('name', 'like', "%{$search}%");
    }

    public function scopeActive(Builder $query, $active): Builder
    {
        if ($active === null || $active === '') {
            return $query;
        }

        return $query->where('is_active', filter_var($active, FILTER_VALIDATE_BOOLEAN));
    }

    public function scopeSort(
        Builder $query,
        string $sort = 'name',
        string $direction = 'asc'
    ): Builder {

        $allowed = [
            'id',
            'name',
            'created_at'
        ];

        if (! in_array($sort, $allowed)) {
            $sort = 'name';
        }

        $direction = strtolower($direction);

        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        return $query->orderBy($sort, $direction);
    }
}
