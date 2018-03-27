@extends('admin.layouts.master')
@section('content')

    @include('admin.partials.messages')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>List Phones</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('/backend')}}">Dashboard</a>
                </li>
                <li class="active">
                    <strong>List  products</strong>
                </li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="go"></label>
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">

                        <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
                            <thead>
                            <tr>

                                <th class="footable-visible footable-sortable" data-toggle="true">ID<span class="footable-sort-indicator"></span></th>
                                <th class="footable-visible footable-sortable" data-toggle="true">Name<span class="footable-sort-indicator"></span></th>
                                <th class="footable-visible footable-sortable" data-toggle="true">Model<span class="footable-sort-indicator"></span></th>
                                <th class="footable-visible footable-sortable" data-hide="phone">SKU<span class="footable-sort-indicator"></span></th>
                                <th class="footable-visible footable-sortable" data-hide="phone">Manufacturer<span class="footable-sort-indicator"></span></th>
                                <th class="footable-visible footable-sortable" data-hide="phone">Price<span class="footable-sort-indicator"></span></th>
                                <th class="footable-visible footable-sortable" data-hide="phone">Quantity<span class="footable-sort-indicator"></span></th>
                                <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">Action</th>
                            </tr>
                            </thead>
                            @if(count($products))
                                <tbody>
                                @foreach($products as $product)

                                    <tr class="footable-even" style="">
                                        <td class="footable-visible">{{$product->id}} </td>
                                        <td class="footable-visible"><i class="fa fa-mobile"></i> {{$product->name}}</td>
                                        <td class="footable-visible">{{$product->model}}</td>
                                        <td class="footable-visible">{{$product->sku}}</td>
                                        <td class="footable-visible">{{$product->manufacturer->name}}</td>
                                        <td class="footable-visible">${{$product->price}}</td>
                                        <td class="footable-visible">{{$product->quantity}}</td>
                                        <td class="text-right footable-visible footable-last-column">
                                            <a href="{{ url ('admin/products/' .  $product->id) . '/edit' }}" class="btn-xs btn-info">Edit</a>
                                            <a href="{{ route ('products.destroy',['id' => $product->id]) }}" class="btn-xs btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            @else
                                <tbody>
                                <tr><br><br>
                                    <td rowspan="3" colspan="12" class="text-center">
                                        <div class="alert alert-danger">
                                            Nothing found!
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            @endif
                        </table>
                        <table>
                            <tr>
                                <td>
                                    @if($products->render() != '')
                                        {{ $products->appends(\Illuminate\Support\Facades\Input::except(array('page')))->render() }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


