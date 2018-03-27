@extends('layouts.master')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Profile</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('backend/overview')}}">Home</a>
                </li>
                <li class="active">
                    <strong>{{ucfirst($user->name)}}</strong>
                </li>
                <li>
                    <a href="{{URL::previous()}}" class="label label-primary">Back</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a aria-expanded="true" data-toggle="tab" href="#tab-1">User Summary</a></li>
                        <li class=""><a aria-expanded="false" data-toggle="tab" href="#tab-2">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="row m-b-lg m-t-lg">
                                    <div class="col-md-6">

                                        <div class="profile-image">
                                            <img src="{{URL::asset('img/anonymous_avatar.png')}}" class="img-circle circle-border m-b-md" alt="profile">
                                        </div>
                                        <div class="profile-info">
                                            <div class="">
                                                <div>
                                                    <h2 class="no-margins">
                                                        {{ucfirst($user->name)}}
                                                    </h2>
                                                    <h4>User</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table small m-b-xs">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    Last 7 days <strong>{{$lastWeek or 0}}</strong>
                                                </td>
                                                <td>
                                                    This Month <strong>{{$lastMonth or 0}}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Tickets <strong>{{$countTickets or 0}}</strong>
                                                </td>
                                                <td>
                                                    Total Orders <strong>{{$totalOrders or 0}}</strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Orders in last 24h</small>
                                        <h2 class="no-margins">{{$dailyOrders or 0}}</h2>
                                        <div id="sparkline1"><canvas height="50" width="248" style="display: inline-block; width: 248px; height: 50px; vertical-align: top;"></canvas></div>
                                    </div>
                                </div>
                                <div class="ibox-title">
                                    <h4>Orders</h4>
                                </div>
                                <div class="ibox-content">

                                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                                        <thead>
                                        <tr>

                                            <th class="footable-visible footable-first-column footable-sortable" data-toggle="true">Order ID<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-visible footable-sortable">BIN<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-visible footable-sortable">Country<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-sortable" style="display: none;" data-hide="all">Company<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-sortable" style="display: none;" data-hide="all">Completed<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-sortable" style="display: none;" data-hide="all">Task<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-sortable" style="display: none;" data-hide="all">Date<span class="footable-sort-indicator"></span></th>
                                            <th class="footable-visible footable-last-column footable-sortable footable-sorted-desc">Status<span class="footable-sort-indicator"></span></th>
                                        </tr>
                                        </thead>
                                        @if(count($orders))
                                            <tbody>
                                            <?php $count = 0; ?>
                                            @foreach($orders as $order)
                                                <?php $count++;  ?>
                                                <tr>
                                                    <td>
                                                        {{$order->id or '-'}}
                                                    </td>
                                                    <td>
                                                        <?php $bin = substr($order->cc_number,0,6); ?>
                                                        {{$bin or '-'}}
                                                    </td>
                                                    <td>
                                                        {{$order->country or '-'}}
                                                    </td>
                                                    <td class="footable-visible footable-last-column"><a href="#"><i class="fa {{$order->is_refunded == 0 ? 'fa-check text-navy' : 'fa-remove text-danger'}} "></i></a></td>
                                                </tr>
                                                @if($count >= 10)

                                                    <tr>
                                                        <td>
                                                            <a href="{{url('orders')}}" class="btn btn-xs btn-primary">See all orders</a>
                                                        </td>
                                                    </tr>
                                                    @break
                                                @endif
                                            @endforeach
                                            </tbody>

                                        @endif

                                        <tfoot>
                                        <tr>
                                            <td class="footable-visible" colspan="5">
                                                <ul class="pagination pull-right">
                                                    {{$orders->links()}}
                                                </ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>

                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label class=" control-label">Jabber</label>
                                        <div><input class="form-control" id="email" name="jabber" value="{{$user->email or '-'}}" type="text">
                                            <span id="error-email"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Password</label> <small class="text text-danger">Leave blank if you don't want to change!</small>
                                        <div><input class="form-control" id="password" name="pass" value="" type="password">
                                            <span id="error-password"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button id="{{$user->id}}" class="updateUser btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>
@endsection