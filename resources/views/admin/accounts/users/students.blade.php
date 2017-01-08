@extends('layouts.app')

@section('styles')
<style>
    #user-table { margin-bottom:20px; }
    #user-table_length, #user-table_info { padding-left:8px; }
    #user-table_filter, #user-table_paginate { padding-right:8px; }
</style>
@endsection

@section('content')

    <div class="primary-content" id="page-content">
        <h2 class="page-header mb30">All Students
            <span class="pull-right">
                <small>
                    <span style="font-size:70%;font-weight:700;">
                           <a href="{{ route('admin.students.search') }}"><i class="fa fa-search"></i> &nbsp; Student Search</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                           <a href="{{ route('admin.students.archived') }}"><i class="fa fa-trash"></i> &nbsp; Archived Students</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                           <a href="{{ route('admin.students.create') }}"><i class="fa fa-user"></i> &nbsp; New Student</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a data-toggle="modal" data-target="#importUsers"><i class="fa fa-upload"></i> &nbsp; Import Students</a>
                    </span>
                </small>
            </span>
        </h2>

        @include('layouts.partials.flash')      
        @include('admin.accounts.users.partials.import')

        <div class="content-box">      
            @include('admin.accounts.users.partials.usertable')
        </div>
    </div>

@endsection

@section('scripts')
    @include('admin.accounts.users.partials.userscripts')
@endsection