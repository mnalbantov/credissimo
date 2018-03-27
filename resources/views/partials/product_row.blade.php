<div class="row">
        @if(count($products))
        @foreach ($products as $product)
            <?php $url = url('images/products/thumbnails/'. $product->image); ?>

                <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route ('show',['id' => $product->id]) }}"><img class="card-img-top" height="250" width="250" src="{{  ($product->image != null) ? $url : 'http://placehold.it/700x400' }}" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{ route ('show',['id'=> $product->id]) }}">{{$product->name}}</a>
                            <small class="text-muted">by {{ $product->manufacturer->name }}</small>
                        </h4>
                        <h5>${{$product->price}}</h5>
                        <p class="card-text"><?php echo substr($product->description,0,50). '...'; ?></p>
                    </div>

                </div>
            </div>
        @endforeach
    @else
        <div class="col-lg-9">
            <h2>No products available yet</h2>
        </div>
    @endif
</div>

@yield('product_row')