<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

// Traits
use App\Traits\Filterable;

class Permission extends Model
{
    use HasFactory, Filterable;
    // public $table = 'admin_permission';
    // protected $fillable = ['name', 'name_en', 'slug', 'http_uri'];
    protected $guarded = [];

    /**
     * Permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     * If request should pass through the current permission.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function passRequest(Request $request): bool
    {
        if (empty($this->http_uri)) {
            return false;
        }

        $uriCurrent = \Route::getCurrentRoute()->uri;
        $methodCurrent = $request->method();
        $actions = explode(',', $this->http_uri);

        foreach ($actions as $key => $action) {
            $method = explode('::', $action);
            if ($method[0] === 'ANY' && ($request->path() . '/*' == $method[1] || $request->is($method[1]))) {
                return true;
            }
            if ($methodCurrent . '::' . $uriCurrent == $action) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->roles()->detach();
        });
    }

    /**
     * Update info
     * @param  [array] $dataUpdate
     * @param  [int] $id
     */
    // public static function updateInfo($dataUpdate, $id)
    // {
    //     $dataUpdate = $dataUpdate;
    //     $obj = self::find($id);
    //     return $obj->update($dataUpdate);
    // }

    /**
     * Create new permission
     * @return [type] [description]
     */
    // public static function createPermission($dataInsert)
    // {
    //     $dataUpdate = $dataInsert;
    //     return self::create($dataUpdate);
    // }

    // Filter Search
    // public function filterCategoryId($query, $value)
    // {
    //     if ($value)
    //         return $query->whereHas('categories', function ($query) use ($value) {
    //             $query->where('id', $value);
    //         });
    // }

    public function filterName(Builder $query, string $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
