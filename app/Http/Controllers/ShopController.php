<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\Manufacturer;
use App\Product;
use App\ProductAttributes;
use App\Ram;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{

    /** Main view for all listings
     * // todo Limit info / AJAX loader for all products
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $method = $request->method();

        $products = Product::getFiltered($request->all());

        return view('home',
            [
                'products' => $products,
                'categories' => Category::all(),
                'manufacturers' => Manufacturer::all(),
                'colors' => Color::all(),
                'ram' => Ram::all(),
            ]);
    }

    /** Get the current products by category filter
     *  //todo relate with dynamicly filter with search bar
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id)
    {
        $products = Product::getByCategory($id);

        return view('home',
            [
                'products' => $products,
                'categories' => Category::all(),
                'manufacturers' => Manufacturer::all(),
                'colors' => Color::all(),
                'ram' => Ram::all(),
            ]);
    }

    /** Show method for specific product a.k.a list single product
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::getWithAttributes($id);
            if(! $product)
                abort(404);

        $product->viewed +=1;
        $product->save();
        return view('products.show',
            [
                'product' => $product,
                'attributes' => $product->attributes()->get(),
                'categories' => Category::all(),
                'reviews'    => Review::where('product_id',$id)->get()
            ]);
    }


    /** Method responsible for storing reviews for specific product
     * @param Request $request
     *  Method responsible for storing reviews for our products
     */
    public function storeReview(Request $request)
    {
        // only registered users can write reviews
        if(!Auth::check())
              return redirect()->route('login');

         $this->validate($request,
                [
                   'review' => 'required|min:5:max:255'
                ]);
        $reviewComment = $request->input('review');
        $review = new Review();
        $review->product_id = $request->input('product_id');
        $review->user_id = Auth::user()->id;
        $review->review = $reviewComment;

        $review->save();

        return redirect()->back()->with(['success' => 'Sucessfully written review!']);
    }
}
