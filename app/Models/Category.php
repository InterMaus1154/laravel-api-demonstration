<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $guarded = [];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
