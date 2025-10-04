<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // protected $table = 'category';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_categories', 'category_id', 'post_id');
    }

    public function getCategoryNameAttribute($value)
    {
        $lc = app()->getLocale();
        if ('en' == $lc) {
            return $value;
        } else {
            return $this->{'categoryName_' . $lc};
        }
    }
    public function getCategoryDescriptionAttribute($value)
    {
        $lc = app()->getLocale();
        if ('en' == $lc) {
            return $value;
        } else {
            return $this->{'categoryDescription_' . $lc};
        }
    }
    public function getCategoryContentAttribute($value)
    {
        $lc = app()->getLocale();
        if ('en' == $lc) {
            return $value;
        } else {
            return $this->{'categoryContent_' . $lc};
        }
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent', 'id')->orderBy('sort', 'DESC');
    }
    public function parent()
    {
        return $this->hasOne(Category::class, 'categoryID', 'categoryParent');
    }

    public function getDetail($id, $type = '')
    {
        $detail = new Category;
        if ($type == 'slug')
            $detail = $detail->where('slug', $id);
        else
            $detail = $detail->where('id', $id);

        $detail = $detail->first();
        return $detail;
    }
}
