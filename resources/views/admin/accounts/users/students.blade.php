@extends('layouts.app')

@section('styles')
<style>
    #user-table { margin-bottom:20px; }
    #user-table_length, #user-table_info { padding-left:8px; }
    #user-table_filter, #user-table_paginate { padding-right:8px; }
    .userSearchBox {
        width: 100%;
        margin-bottom: 10px;
        font-size: 25px;
        border-left: 1px solid #efefef;
        padding-left: 6px;
        border-top: 0px;
        border-right: 0px;
        border-bottom: 0px;        
    }
</style>
@endsection

@section('content')

    <div class="primary-content" id="page-content">
        <h2 class="page-header mb30">All Students
            <span class="pull-right page-header-menu">
                <small>
                    <span class="hidden page-header-button">
                        <a href="{{ route('admin.students.archived') }}"><i class="fa fa-trash"></i> &nbsp; Archived Students</a>
                    </span>
                    <span class="page-header-button">
                        <a class="btn btn-success" href="{{ route('admin.students.create') }}"><i class="fa fa-user"></i> &nbsp; New Student</a>
                    </span>
                    <span class="page-header-button">
                        <a class="btn btn-success" data-toggle="modal" data-target="#importUsers"><i class="fa fa-upload"></i> &nbsp; Import Students</a>
                    </span>
                </small>
            </span>
        </h2>

        @include('layouts.partials.flash')      
        @include('admin.accounts.users.partials.import')

        <div class="search-box">
            <input type="text" class="userSearchBox" name="searchBox" placeholder="Search">
        </div>

        <div class="content-box">      
            @include('admin.accounts.users.partials.usertable')
        </div>
    </div>

@endsection

@section('scripts')
    @include('admin.accounts.users.partials.userscripts')
@endsection