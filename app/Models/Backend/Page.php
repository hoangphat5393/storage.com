<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\LocalizeController;
use App\Traits\Filterable;

class Page extends Model
{
    use HasFactory, Filterable;

    public $timestamps = true;
    // protected $table = 'page';
    protected $guarded = [];

    public static function newFactory()
    {
        return \Database\Factories\PageFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Filter Search
    public function filterName(Builder $query, string $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
