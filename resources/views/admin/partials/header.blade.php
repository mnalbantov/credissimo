{{csrf_field()}}
<noscript>
    <div class="wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <span class="alert alert-info col-lg-12">
                    It looks like you are browsing this without enabled JavaScript. Please turn it on!
                </span>
            </div>
            <div class="col-lg-12">
                <span class="alert alert-danger col-lg-12">
             Please enable JavaScript in your browser to use site properly! Otherwise some features wouldn't work!
            </span>
            </div>
        </div>
    </div>
</noscript>
<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <span class="m-r-sm text-muted welcome-message"><strong>Admin panel</strong></span>
        </li>
        <li>
            <a href=""><span class="label label-warning"> <i class="fa fa-plus"></i>ADD ITEMS</span></a>
        </li>
        <li>
            <a href=""><span class="label label-primary"> <i class="fa fa-dollar"></i>INCOME</span></a>

        </li>

        <input type="hidden" id="countHidden" value="">

        <li class="dropdown">
            <a class="count-info" href="/cart">
                <i class="fa fa-shopping-cart"></i><span class="label countItems label-primary"></span>

            </a>
        </li>

        <li>
            <a href="{{ route ('admin.logout') }}">
                <i class="fa fa-sign-out"></i> Log out
            </a>
        </li>
    </ul>

</nav>