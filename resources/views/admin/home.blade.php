@extends('admin.layouts.master')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Main dashboard</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.home') }}">Home</a>
                </li>
                <li class="active">
                    <strong>Dashboard Homepage</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>

    </div>
    @endsection