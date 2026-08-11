<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'stock',
        'minimum_stock',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relaciones para obtener la categoría asociada a un producto
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Scope para filtrar productos por categoría
    public function scopeSearch(
        Builder $query,
        ?string $search
    ): Builder {
        if (blank($search)) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($search) {
            $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        });
    }

    // Scope para filtrar productos por categoría especifica
    public function scopeCategory(
        Builder $query,
        ?int $categoryId
    ): Builder {
        if ($categoryId === null) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    // Scope para filtrar productos activos o inactivos
    public function scopeActive(
        Builder $query,
        $active
    ): Builder {
        if ($active === null || $active === '') {
            return $query;
        }

        return $query->where(
            'is_active',
            filter_var($active, FILTER_VALIDATE_BOOLEAN)
        );
    }

    // Scope para filtrar productos con stock bajo
    public function scopeLowStock(
        Builder $query,
        $lowStock
    ): Builder {
        if (
            $lowStock === null ||
            $lowStock === '' ||
            !filter_var($lowStock, FILTER_VALIDATE_BOOLEAN)
        ) {
            return $query;
        }

        return $query->whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        );
    }

    // Scope para ordenar los productos por un campo específico y una dirección
    public function scopeSort(
        Builder $query,
        string $sort = 'name',
        string $direction = 'asc'
    ): Builder {
        $allowed = [
            'id',
            'name',
            'code',
            'purchase_price',
            'sale_price',
            'stock',
            'created_at',
        ];

        if (!in_array($sort, $allowed, true)) {
            $sort = 'name';
        }

        $direction = strtolower($direction);

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        return $query->orderBy($sort, $direction);
    }
}
