<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // protected $table = 'page';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public static function search(string $keyword)
    {
        $keyword = '%' . addslashes($keyword) . '%';
        $result = self::select('id', 'title', 'slug', 'description')
            ->where('title', 'like', $keyword)
            ->orWhere('parent', 'like', $keyword)
            ->get();
        return $result;
    }

    public function getTitleAttribute($value)
    {
        $lc = app()->getLocale();
        if ('vi' == $lc) {
            return $value;
        } else {
            return $this->{'title_' . $lc};
        }
    }

    public function getDescriptionAttribute($value)
    {
        $lc = app()->getLocale();
        if ('vi' == $lc) {
            return $value;
        } else {
            return $this->{'description_' . $lc};
        }
    }

    public function getContentAttribute($value)
    {
        $lc = app()->getLocale();
        if ('vi' == $lc) {
            return $value;
        } else {
            return $this->{'content_' . $lc};
        }
    }
}
