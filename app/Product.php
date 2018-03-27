<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = [];

    protected $guarded = ['id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attributes()
    {
        return $this->hasOne(ProductAttributes::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class,'colors_products','product_id','color_id');
    }

    public function ram()
    {
        return $this->belongsToMany(Ram::class,'ram_products','product_id','ram_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class,'manufacturer_id','id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getWithAttributes($id)
    {
       return  Product::where('id',$id)
            ->with(['colors','ram'])
            ->where('status',1)
            ->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public  static function getByCategory($id)
    {
        return Product::where('status',1)
            ->where('category_id',$id)
            ->orderBy('created_at','DESC')
            ->paginate(6);
    }


    /**
     * @param array $data
     * @return mixed
     */
    public static function createProduct($data = array())
    {
        return Product::create([
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : '',
            'sku' => isset($data['sku']) ? $data['sku'] : '',
            'lot' => isset($data['lot']) ? $data['lot'] : '',
            'price' => isset($data['price']) ? $data['price'] : '',
            'manufacturer_id' => $data['manufacturer'],
            'category_id' => $data['category'],
            'quantity' => $data['quantity'],
            'status' => $data['status'],
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateProduct($data = array())
    {
        return Product::update([
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : '',
            'sku' => isset($data['sku']) ? $data['sku'] : '',
            'lot' => isset($data['lot']) ? $data['lot'] : '',
            'price' => isset($data['price']) ? $data['price'] : '',
            'manufacturer_id' => $data['manufacturer'],
            'category_id' => $data['category'],
            'quantity' => $data['quantity'],
            'status' => $data['status'],
        ]);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public static function getFiltered($request = array())
    {
        $query = Product::where('status',1);

        if(isset($request['name']) && $request['name']){
            $query->where('name',"LIKE",''.trim('%'.$request['name'].'%'));
        }
        if(isset($request['manufacturer']) &&  $request['manufacturer']){
            $query->where('manufacturer_id',$request['manufacturer']);
        }
        if(isset($request['category']) &&  $request['category']){
            $query->where('category_id',$request['category']);
        }

        $query->orderBy('created_at','desc');

        return $query->paginate();
    }


}
