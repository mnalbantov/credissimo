<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{

    protected $fillable = [];
    protected $guarded = ['id'];
    public function products()
    {
        return $this->hasMany(Product::class,'manufacturer_id','id');
    }
}
