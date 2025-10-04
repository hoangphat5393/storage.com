<?php

namespace App\Models\Backend;

// use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Trails
use App\Traits\LocalizeController;
use App\Traits\Filterable;

class Campaign extends Model
{
    use HasFactory, Filterable;

    public $timestamps = true;
    // protected $table = 'campaign';
    protected $guarded = [];

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'campaign_category', 'campaign_id', 'category_id');
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function filterName(Builder $query, string $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('name_en', 'LIKE', '%' . $value . '%');
    }
}
