<!-- Mainly scripts -->
<script src="{!! URL::asset('assets/js/jquery-3.1.1.min.js') !!}"></script>
<script src="{!! URL::asset('assets/js/bootstrap.min.js') !!}"></script>
<script src="{!! URL::asset('assets/js/custom.js') !!}"></script>
<script src="{!! URL::asset('assets/js/admin/common.js') !!}"></script>
<script src="{!! URL::asset('assets/js/inspinia.js') !!}"></script>
{{--<script src="{{URL::asset(elixir('scripts/app.js'))}}"></script>--}}
<script src="{!! URL::asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') !!}"></script>
<script src="{!! URL::asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}"></script>


<!-- jQuery UI -->
<script src="{!! URL::asset('assets/js/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>


<!-- Toastr -->
<script src="{!! URL::asset('assets/js/plugins/toastr/toastr.min.js') !!}"></script>

@yield('scripts')