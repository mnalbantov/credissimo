@extends('layouts.app')
@section('content')
        <div class="container">
            @include('partials.messages')
        <div class="row">
            @include('partials.category_sidebar')
            <?php $url =  url('images/products/'. $product->image); ?>
            <div class="col-lg-9">
                    <div class="col-lg-6 item-photo">
                        <img width="300" height="350"  src="{{  ($product->image != null) ? $url : 'http://placehold.it/700x400' }}" />
                    </div>
                    <div class="col-lg-6" style="border:0px solid gray">

                        <h3>{{ $product->name or '---' }}</h3>
                        <h5 style="color:#337ab7">created by <a href="{{ url ('manufacturer/'. $product->manufacturer->id) }}">{{ $product->manufacturer->name }}</a> ·
                            <small style="color:#337ab7">({{$product->viewed}} views)</small>
                            <small> added on {{$product->created_at->diffForHumans()}}</small>
                        </h5>

                        <h3 style="margin-top:0px;">${{ $product->price }}</h3>
                        <h6 class="title-attr">In Stock</h6>
                        <span> {{ $product->quantity }} pcs</span>
                        <div class="section">
                            <h6 class="title-attr" style="margin-top:15px;" ><small>AVAILABLE COLORS</small></h6>
                            <div class="form-group ">
                                @if($product->colors)
                                    <select class="col-lg-2 form-control" name="color" id="color">
                                    @foreach($product->colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                    </select>
                                @endif
                            </div>
                            <br>
                            <h6 class="title-attr" style="margin-top:15px;" ><small>AVAILABLE RAM</small></h6>
                            <div class="form-group ">
                                @if($product->ram)
                                    <select class="col-lg-2 form-control" name="color" id="color">
                                        @foreach($product->ram as $ram)
                                            <option value="{{ $ram->id }}">{{ $ram->value }} {{ strtoupper($ram->entity) }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <br><br>
                        <div class="section">
                            <button class="btn btn-primary">Add to cart</button>
                        </div>
                    </div>
                @include('partials.product_tabs')
            </div>
        </div>
            <div class="row">
                <br><br><br><br><br><br>
            </div>
    </div>
@endsection