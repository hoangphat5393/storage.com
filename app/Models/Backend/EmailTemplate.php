<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Filterable;

class EmailTemplate extends Model
{
    use HasFactory, Filterable;
    public $timestamps = false;
    // public $table = 'email_template';
    protected $guarded = [];
}
