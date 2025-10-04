<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Traits
use App\Traits\Filterable;
use App\Traits\LocalizeController;

class PostCategory extends Model
{
    use HasFactory, Filterable, LocalizeController;

    // public $timestamps = true;
    // protected $table = 'post_category';
    protected $guarded = [];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Filter Search
    public function filterName($query, $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
