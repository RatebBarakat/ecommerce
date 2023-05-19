<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasEagerLimit;
    protected $fillable = [
        'name',
        'slug',
        'small_description',
        'description',
        'images',
        'price',
        'discount',
        'available_quantity',
        'images',
        'category_id',
        'brand_id',
        'admin_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'images' => 'array'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    // public function category(){
    //     return $this->be
    // }
}
