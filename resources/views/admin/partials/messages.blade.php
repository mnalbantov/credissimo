@if (Session::has('not_found'))
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <span>{{ Session::get('not_found') }}</span>
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <span>{{ Session::get('error') }}</span>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <span>{{ Session::get('success') }}</span>
    </div>
@endif

@if(count($errors))
    <div class="row col-lg-12 alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <ul>
            @foreach ($errors->all() as $msg)
                <li class="alert-danger ">{{$msg}}</li>
            @endforeach
        </ul>
    </div>
@endif
@yield('messages')
