<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItems extends Model
{
    // protected $table = 'menu_items';

    protected $guarded = [];
    // protected $fillable = ['page_id', 'category_id', 'label', 'link', 'parent', 'sort', 'class', 'menu', 'depth', 'role_id'];

    // public function __construct(array $attributes = [])
    // {
    //     //parent::construct( $attributes );
    //     $this->table = config('menu.table_prefix') . config('menu.table_name_items');
    // }

    public function getsons($id)
    {
        return $this->where("parent", $id)->get();
    }
    public function getall($id)
    {
        return $this->where("menu_id", $id)->orderBy("sort", "asc")->get();
    }

    public static function getNextSortRoot($menu)
    {
        return self::where('menu_id', $menu)->max('sort') + 1;
    }

    public function parent_menu(): BelongsTo
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(MenuItems::class, 'parent')->orderBy('sort', 'ASC');
    }
}
