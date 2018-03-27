@extends('layouts.app')

@section('content')
<div class="container">

 <div class="row">

     @include('partials.category_sidebar')
     <div class="col-lg-9">
        <div class="row">
            @include('partials.search-nav')
        </div>
         @include('partials.product_row')

         @include('partials.paginator')
     </div>

 </div>
</div>
@endsection
