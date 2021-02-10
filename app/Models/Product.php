<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property float $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Product filter(array $filters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product orderByName()
 * @method static Builder|Product query()
 * @method static Builder|Product whereAmount($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Builder
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'amount',
    ];

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
