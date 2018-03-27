<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorProduct extends Model
{
    protected $table = 'colors_products';

        protected  $fillable = ['product_id','color_id'];

    public  $timestamps = false;
}
