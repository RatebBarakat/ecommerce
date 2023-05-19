<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_mode',
        'status',
        'payment_status',
    ];   
    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'guest castomer'
        ]);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,'order_products','order_id','product_id','id','id')
        ->using(OrderProduct::class)            
        ->withPivot([
            'name','price','quantity','options'
        ]);
    }
    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)
                ->where('type','billing');
    }
    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)
                ->where('type','shipping');
    }
}
