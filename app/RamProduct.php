<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RamProduct extends Model
{
    protected $table = 'ram_products';

    protected  $fillable = ['product_id','ram_id'];

    public $timestamps = false;


}
