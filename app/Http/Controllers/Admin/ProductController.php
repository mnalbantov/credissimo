<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Color;
use App\ColorProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Manufacturer;
use App\Product;
use App\ProductAttributes;
use App\ProductSpecValue;
use App\Ram;
use App\RamProduct;
use App\Specifications;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use PHPUnit\Framework\Constraint\Attribute;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::where('status',1)->orderBy('created_at','DESC')->paginate(); // get only active items
        return view('admin.products.list',
            [
                'products' => $products,
                'categories' => Category::all(),
                'manufacturers' => Manufacturer::all()
            ]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.products.create',
            [
                'categories' => Category::all(),
                'manufacturers' => Manufacturer::all(),
                'colors' => Color::all(),
                'ram' => Ram::all(),
            ]);

    }

    /**
    //todo SHOULD HAVE view for admin part..
     */
    public function show()
    {
        //todo SHOULD HAVE view for admin part..

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        //TODO: SHOULD HAVE multiple images for product
        //get colors
        $colors  = $request->input('color');
        //get ram specifications
        $ram  = $request->input('ram');
        $file = '';
        try {

            DB::beginTransaction();

                $product = Product::createProduct($request->all());

            ProductAttributes::create([
                'product_id' => $product->id,
                'display' => $request->input('display') ? $request->input('display') :'',
                'camera' => $request->input('camera') ? $request->input('camera') : '',
                'os' => $request->input('os') ? $request->input('os') : '',
            ]);

            if(isset($colors) && ! empty($colors))
            {
                foreach ($colors as $item) {
                    ColorProduct::create([
                        'product_id' => $product->id,
                        'color_id' => (int) $item
                    ]);
                }
            }
            if(isset($ram) && ! empty($ram))
            {
                foreach ($ram as $r) {
                    RamProduct::create([
                        'product_id' => $product->id,
                        'ram_id' => (int) $r
                    ]);
                }
            }
            DB::commit();

            if($request->file('picture'))
                $file = $this->fileUpload($request->file('picture'));

            $product->image = ($file) ? $file : null;
            $product->save();
            // TODO :  event catching and listeners for new product being added.
        }
        catch (\PDOException $e)
        {
            //something fucked up :( throw to admin dash and log error into log file
            // TODO: integrate with 3rd party service for error logging
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(['error'=>$e->getMessage()])->withInput();
        }
        return redirect()->route('products.index')->with(['success'=>'Successfully created product!']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $product = Product::where('id',$id)->firstOrFail();

        $attributes = $product->attributes()->first();


        return view('admin.products.view',
            [
                'product' => $product,
                'attributes' => $attributes,
                'categories' => Category::all(),
                'manufacturers' => Manufacturer::all(),
                'colors' => Color::all(),
                'ram' => Ram::all(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        // TODO - Simple bug occurs when user decide to edit product for name field due unique:index;
        // TODO -  MUST refactor functionallity for validate data especially for name field
        // TODO - MUST fix/change way file Upload function work
        $product = Product::where('id',(int)$id)->first();


        try
        {
            $product->updateProduct($request->all(),$product->id);

            if($request->file('picture'))
                $file = $this->fileUpload($request->file('picture'));

            $product->image = ($file) ? $file : null;
            $product->save();
        }
        catch (\PDOException $exception)
        {
            Log::error($exception->getMessage());
            DB::rollBack();
            return redirect()->back()->with(['error'=>$exception->getMessage()])->withInput();
        }
        return redirect()->route('products.index')->with(['success'=>'Successfully updated product!']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Todo : destroy method for items / could be ajax requests
        echo $id;
    }


    /**
     * @param null $image
     * @return mixed
     * Custom function responsible for file uploading for our list items
     */
    private function fileUpload($image = null)
    {
            
        try {

            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/images/products/thumbnails');

            $img = Image::make($image->getRealPath());

            $img->resize(200, 250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            $destinationPath = public_path('/images/products');

            $savedImg = $image->move($destinationPath, $input['imagename']);
                
            return $savedImg->getFileName();
        }
        catch (FileException $exception)
        {
            throw new Exception($exception->getMessage());
        }



    }
}
