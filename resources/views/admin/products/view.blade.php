@extends('admin.layouts.master')
@section('title', 'Credissimo - Add product')
@section('content')

    @include('admin.partials.messages')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Edit {{$product->name}}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href=" {{ route ('admin.home') }}">Dashboard</a>
                </li>
                <li class="active">
                    <strong>Edit Product</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">General</a></li>
            <li><a data-toggle="tab" href="#menu1">Data</a></li>
            <li><a data-toggle="tab" href="#menu2">Options</a></li>
            <li><a data-toggle="tab" href="#menu3">Links</a></li>
        </ul>
        <form class="form" method="POST" action="{{ route ('products.update',['id'=> $product->id]) }} " enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input name="_method" type="hidden" value="PUT">

            <div class="container">

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="price">Name</label>
                                    <input id="price" class="form-control" value="{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->name :  old ('name') }}" name="name" required  type="text" placeholder="iPhone 6S">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control"  placeholder="Awesome model phone :)" required id="description" rows="10" cols="50">{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->description :  old ('description') }}</textarea>
                                </div>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select required class="form-control" name="category" id="category">
                                        @if($categories)
                                            @foreach($categories as $category)
                                                <option {{ ($category->id== $product->category_id) ? "selected":"" }} value="{{$category->id}}">{{$category->CategoryName or ''}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                                    <label for="sku">SKU</label>
                                    <input id="sku" class="form-control" value="{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->sku :  old ('sku') }} " name="sku"   type="text" placeholder="APPL-123">
                                </div>
                                @if ($errors->has('sku'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sku') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="manufacturer">Manufacturer</label>
                                    <select required class="form-control" name="manufacturer" id="manufacturer">
                                        @if($manufacturers)
                                            @foreach($manufacturers as $manufacturer)
                                                <option value="{{$manufacturer->id}}">{{$manufacturer->name or ''}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group{{ $errors->has('lot') ? ' has-error' : '' }}">
                                    <label for="lot">LOT</label>
                                    <input id="lot" class="form-control" value="{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->lot :  old ('lot') }} " name="lot"   type="text" placeholder="LOT123S23">
                                </div>
                                @if ($errors->has('lot'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lot') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label for="price">Price</label>
                                    <input  id="price"  class="form-control" name="price"  value="{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->price :  old ('price') }}" required  type="number" step="0.01" placeholder="124.99">
                                </div>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                    <label for="quantity">Quantity</label>
                                    <input id="quantity" class="form-control" name="quantity" value="{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->quantity :  old ('quantity') }}" required  type="number" step="any" placeholder="80">
                                </div>
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group{{ $errors->has('colors') ? ' has-error' : '' }}">
                                    <label for="colors">Available Colors</label><br>
                                    @if(count($colors))
                                        @foreach($colors as $color)
                                            @foreach($product->colors as $p_c)
                                                @if($p_c->id == $color->id)
                                                    <input type="checkbox" class="" checked name="color[]" id="{{ $color->id }} " value="{{$color->id}}">
                                                 @endif
                                                    @endforeach
                                            <span>{{ $color->name }}</span>
                                            <input type="checkbox" class=""  name="color[]" id="{{ $color->id }} " value="{{$color->id}}">
                                        @endforeach
                                    @endif
                                </div>
                                @if ($errors->has('colors'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('colors') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group{{ $errors->has('colors') ? ' has-error' : '' }}">
                                    <label for="ram">Available RAM</label><br>
                                    @if(count($ram))
                                        @foreach($ram as $r)
                                            @foreach($product->ram as $p_r)
                                                @if($p_r->id == $r->id)
                                                    <input type="checkbox" checked name="ram[]" id="{{ $r->id }} " value="{{$r->id}}">
                                                @endif
                                            @endforeach
                                            <span>{{ $r->value . ' '. strtoupper($r->entity) }}</span>
                                            <input type="checkbox" class="" name="ram[]" id="{{ $r->id }} " value="{{$r->id}}">
                                        @endforeach

                                        <input type="radio" class="form-control" >
                                    @endif
                                </div>
                                @if ($errors->has('colors'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('colors') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option  {{ old('status') == '1' ? "selected":"" }} value="1">Active</option>
                                        <option  {{ old('status')  == '2' ? "selected":"" }} value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('display') ? ' has-error' : '' }}">
                                    <label for="display">Display</label>
                                    <input id="display" class="form-control" value="{{ Request::is('admin/products/' . $product->id. '/edit') ? $product->attributes->display :  old ('display') }}" name="display"   type="text" placeholder="5 inches">
                                </div>
                                @if ($errors->has('display'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('display') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('camera') ? ' has-error' : '' }}">
                                    <label for="camera">Camera Model</label>
                                    <input id="camera" class="form-control" value="{{ $product->attributes->camera  }}" name="camera"   type="text" placeholder="12 MP Carlezeiss">
                                </div>
                                @if ($errors->has('display'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('display') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('os') ? ' has-error' : '' }}">
                                    <label for="os">Operational system</label>
                                    <input id="os" class="form-control" value="{{ $product->attributes->os  }}" name="os"   type="text" placeholder="iOS 10.2 / Android 5.6">
                                </div>
                                @if ($errors->has('os'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('os') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                                    <label for="image">Featured image</label><br>
                                    @if($product->image != null)
                                    <?php $url = url('images/products/thumbnails/'. $product->image); ?>
                                    <img src="{{ $url }}" alt="Featured Image"><br><br>
                                        @else
                                        <img src="http://placehold.it/700x400" width="200" height="250" alt="Featured Image"><br><br>
                                    @endif
                                    <input  type="file" name="picture" id="image"><br>

                                </div>
                                @if ($errors->has('picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" value="Edit Product" name="submit">
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection