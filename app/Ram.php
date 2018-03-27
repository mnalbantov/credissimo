<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class,'ram_products');
    }
}
