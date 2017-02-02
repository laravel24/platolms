@extends('layouts.app')

@section('content')
    <div class="primary-content">
        <div class="">
            <h2 class="page-header mb30">{{ $tag->title }}</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box mt30">          
            @if ($tag)
                <div class="row">
                    <div class="{{ getColumns(4) }}">
                        <h4 class="mb30 text-warning text-sub-header-color">Tag Information</h4>

                        {!! Form::open(['route' => ['admin.tags.update', $tag->id], 'id' => 'form', 'method' => 'put']) !!}

                            {!! makeTextField('title', 'Tag Title', $tag->title, '', 'required', $errors) !!}

                            {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

                        {!! Form::close() !!}
                    </div>
                    <div class="{{ getColumns(8) }}">
                        @include('admin.site.posts.partials.posts', ['posts' => $tag->posts])
                    </div>
                </div>          
            @else
                <p>Tag does not exist.</p>
            @endif
        </div>
    </div>
@endsection
