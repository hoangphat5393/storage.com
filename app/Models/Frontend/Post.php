<?php

namespace App\Models\Frontend;

// use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Traits
use App\Traits\Filterable;

class Post extends Model
{
    use HasFactory, Filterable;

    public $timestamps = true;
    protected $guarded = [];

    public function categories(): BelongsToMany
    {
        // return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'category_id');
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Filter Search
    public function filterCategoryId($query, $value)
    {
        if ($value)
            return $query->whereHas('categories', function ($query) use ($value) {
                $query->where('id', $value);
            });
        // return $query->join('post_category', 'post_id', 'post.id')->where('category_id', $value);
    }

    public function filterName($query, $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
