@extends('layouts.app')

@section('content')
    <div class="primary-content">
        <div class="">
            <h2 class="page-header mb30">All Posts
                @include('admin.site.posts.partials.menu')
            </h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="sub-menu">
            <div class="row">
                <div class="{{ getColumns(6) }} text-left">
                    @if (isset($breadcrumbs))
                        <ul class="breadcrumb">
                            <li>
                                
                            </li>
                            <li>
                                
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="{{ getColumns(6) }} text-right">
                    <h4 class="mb0 mt0">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-info bg-gradient-12 borderless @if (isset($menuTab) && ($menuTab == 'post-categories')) active @endif"><i class="fa fa-sitemap"></i> &nbsp; Post Categories</a>
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-sm btn-info bg-gradient-04 borderless @if (isset($menuTab) && ($menuTab == 'post-tags')) active @endif"><i class="fa fa-tags"></i> &nbsp; Post Tags</a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="content-box">          
            @include('admin.site.posts.partials.posts')
        </div>
    </div>

@endsection
