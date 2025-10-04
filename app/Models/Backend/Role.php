<?php

namespace App\Models\Backend;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Trails
use App\Traits\Filterable;

class Role extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];

    // protected $fillable = ['name', 'name_en', 'slug'];
    // public $table       = 'roles';

    public function administrators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * A role belongs to many menus.
     *
     * @return BelongsToMany
     */
    // public function menus(): BelongsToMany
    // {
    //     return $this->belongsToMany(AdminMenu::class, 'admin_role_menu', 'role_id', 'menu_id');
    // }

    /**
     * Check user has permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function can(string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }

    /**
     * Check user has no permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function cannot(string $permission): bool
    {
        return !$this->can($permission);
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
            $model->administrators()->detach();
            // $model->menus()->detach();
            $model->permissions()->detach();
        });
    }

    /**
     * Update info customer
     * @param  [array] $dataUpdate
     * @param  [int] $id
     */
    // public static function updateInfo($dataUpdate, $id)
    // {
    //     $dataUpdate = sc_clean($dataUpdate, 'password');
    //     $obj        = self::find($id);
    //     return $obj->update($dataUpdate);
    // }

    /**
     * Create new role
     * @return [type] [description]
     */
    // public static function createRole($dataInsert)
    // {
    //     $dataUpdate = sc_clean($dataInsert, 'password');
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
