<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Traits\Filterable;

class Shortcode extends Model
{
    use HasFactory, Filterable;

    public $timestamps = true;
    protected $table = 'shortcode';
    protected $guarded = [];

    // public function setCreatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('Y-m-d H:i:s');
    // }
    // public function setUpdatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('Y-m-d H:i:s');
    // }

    // public function getCreatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('Y-m-d H:i:s');
    // }
    // public function getUpdatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('Y-m-d H:i:s');
    // }
}
