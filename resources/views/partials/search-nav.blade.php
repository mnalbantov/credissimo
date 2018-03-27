<form name="filter"  method="post" action="{{ route ('home') }}">
    {{csrf_field()}}
    <h2>Search bar filter</h2>
    <div class="ibox-content m-b-sm">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="name">Name</label>
                    <input id="name" name="name" value="{{Request::has('name') ? Request::get('name') : ''}}" placeholder="Apple iPhone X" class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label" for="bank">Manufacturer</label>
                    <select id="manufacturer" name="manufacturer" class="form-control">
                        <option value="">Select...</option>
                            @if(count($manufacturers))
                                @foreach($manufacturers as $manufacturer)
                                <option {{ (Request::get('manufacturer') == $manufacturer->id) ? "selected": ""}} value="{{ $manufacturer->id }}"> {{ $manufacturer->name }}</option>
                                @endforeach
                                @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="class">Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">Select...</option>
                        @if(count($categories))
                            @foreach($categories as $c)
                                <option {{(Request::get('category') == $c->id) ? "selected": ""}} value="{{ $c->id }}"> {{ $c->CategoryName }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="go"></label>
                    <input type="submit" id="cc_search"  value="Search" class="form-control btn btn-primary">
                </div>
            </div>

        </div>
    </div>
</form>


@yield('partials.search-nav')
