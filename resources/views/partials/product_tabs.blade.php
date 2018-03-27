<div class="col-lg-9">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#info">Info</a></li>
        <li><a data-toggle="tab" href="#details">Details</a></li>
        <li><a data-toggle="tab" href="#reviews">Reviews</a></li>
        <li><a data-toggle="tab" href="#tags">Tags</a></li>
    </ul>

    <div class="tab-content">
        <div id="info" class="tab-pane fade in active">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Description</h2>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <div id="details" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Technical details</h2>
                    <ul class="">
                    @if(count($attributes))
                        @foreach($attributes as $attr)
                                <li class="list-group-item">Display: {{ $attr->display }}</li>
                                <li class="list-group-item">Camera: {{ $attr->camera }}</li>
                                <li class="list-group-item">OS: {{ $attr->os }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div id="reviews" class="tab-pane fade">
            @if(count($reviews) > 0)
            @foreach($reviews as $review)
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <i class="fa fa-user"></i>{{ $review->user ? $review->user->name : 'Anonymous'}} <span class="pull-right">{{$review->timeago}}</span>

                        <p>{{{$review->review}}}</p>
                    </div>
                </div>
            @endforeach
                @else
                <p class="alert alert-primary">No reviews for this product</p>
                <p class="alert alert-primary">Write the first one now!</p>
            @endif

                <form method="post" action="{{ route ('review.store') }}">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                            <textarea name="review" id="review" class="form-control" cols="30" rows="5"></textarea><br>
                            <input type="submit" value="Add Review" class="btn btn-info">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if ($errors->has('review'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('review') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                </form>
        </div>

    </div>
</div>
@yield('product_tabs')