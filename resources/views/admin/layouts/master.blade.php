<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>{{ isset($title) ? $title : 'Credissimo Admin Panel' }}</title>

    {{--<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">--}}
    <link href="{!! URL::asset('assets/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{{url('assets/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{url('assets/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <link href="{{url('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{url('assets/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <noscript>Please enable JavaScript in your browser to use site properly!</noscript>
</head>
<body class="">
@include('admin.partials.navbar')
<input type="hidden" id="base_url" name="base_url" value="{{url('/')}}">
<div class="row">
    <div class="col-lg-12">
        <div style="min-height: 563px;" id="page-wrapper" class="white-bg">

            @include('admin.partials.header')

            @yield('content')

            @include('admin.layouts.footer')

        </div>

    </div>
</div>
@include('admin.partials.scripts')


</body>
</html>