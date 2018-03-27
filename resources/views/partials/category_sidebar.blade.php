<div class="col-lg-3">

    <h1 class="my-4">{{$title or 'Credisimo App'}}</h1>
    <div class="list-group">
        @if(count($categories))
            @foreach($categories as $category)
                <a href="{{ route ('category',['id' => $category->id]) }}" class="list-group-item @if(Request::is('category/'.$category->id)) active @endif">{{ $category->CategoryName }}</a>
            @endforeach
        @endif
    </div>

</div>

@yield('category_sidebar')