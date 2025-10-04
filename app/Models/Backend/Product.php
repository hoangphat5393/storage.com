<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\ShopCategory;
use App\Models\ShopProductAttribute;
use DB;

// use DateTimeInterface;
use App\Traits\LocalizeController;
use App\Traits\Filterable;

class Product extends Model
{
    use Filterable;

    public $timestamps = true;
    // protected $table = 'product';
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $cast = [
        // 'options' => 'array', // change option to column want to cast to array
        'meta' => 'array',
        'meta_en' => 'array'
    ];


    public function getUser()
    {
        $user = \App\Models\Backend\User::find($this->user_id);
        if ($user)
            return $user->name;
    }

    /*user detail*/
    public function getUserPost()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function listClass()
    {
        return array(
            'out-product'   => 'Ngoại thất',
            'in-product'   => 'Nội thất',
            'engine-product'   => 'Động cơ, An toàn',
            'operation-product'   => 'Vận hành',
        );
    }

    // public function promotions()
    // {
    //     return $this->hasMany(ShopProductPromotion::class);
    // }

    // public function products()
    // {
    //     return $this->belongsToMany('App\Product', 'shop_product_category', 'category_id', 'product_id')->orderByDesc('shop_products.updated_at');
    // }
}
