<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Hello, {{Auth::user()->name}}</strong>
                             </span> <span class="text-muted text-xs block">Profile<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li class="divider"></li>
                        <li><a href="{{url('logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    CB+
                </div>
            </li>
            <li class="@if(Request::is("admin")) special_link @endif">
                <a href="{{url('admin')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="@if(Request::is("products")) special_link @endif">
                <a href="{{ route('products.index') }}"><i class="fa fa-mobile"></i> <span class="nav-label">Products</span></a></a>
            </li>
            {{--<li class="@if(Request::is("vpn*")) special_link @endif">--}}
                {{--<a href="{{url('vpn')}}"><i class="fa fa-shield"></i> <span class="nav-label">Shop VPNs</span></a></a>--}}
            {{--</li>--}}
            {{--<li class="@if(Request::is("socks*")) special_link @endif">--}}
                {{--<a href="{{url('socks')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Shop Socks</span></a></a>--}}
            {{--</li>--}}
            {{--<li class="@if(Request::is("fullz*")) special_link @endif">--}}
                {{--<a href="{{url('fullz')}}"><i class="fa fa-user"></i> <span class="nav-label">Shop Fullz</span></a></a>--}}
            {{--</li>--}}
            {{--<li class="@if(Request::is("my-orders*")) special_link @endif">--}}
                {{--<a href="#"><i class="fa fa-folder"></i> <span class="nav-label">My Orders</span><span class="fa arrow"></span></a>--}}
                {{--<ul class="nav nav-second-level collapse" style="height: 0px;">--}}
                    {{--<li class="@if(Request::is("my-cards*")) special_link @endif">--}}
                        {{--<a href="{{url('my-cards')}}"><i class="fa fa-credit-card"></i>My Cards</a>--}}
                    {{--</li>--}}
                    {{--<li class="@if(Request::is("my-socks*")) special_link @endif">--}}
                        {{--<a href="{{url('my-socks')}}"><i class="fa fa-bank"></i>My Socks</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{url('my-vpn')}}"><i class="fa fa-shield"></i>My VPNs</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="@if(Request::is("tickets*")) special_link @endif">--}}
                {{--<a href="{{url('tickets')}}"><i class="fa fa-envelope"></i> <span class="nav-label">Tickets</span>@if(isset($aTickets))<span id="newTickets" title="You have new answered tickets!" class="label label-warning pull-right">{{$aTickets > 0 ? $aTickets : ''}}</span>@endif</a>--}}
            {{--</li>--}}
            {{--<li class="@if(Request::is("faq*")) special_link @endif">--}}
                {{--<a href="{{url('faq')}}"><i class="fa fa-flask"></i> <span class="nav-label">FAQ</span></a>--}}
            {{--</li>--}}
        </ul>

    </div>
</nav>


