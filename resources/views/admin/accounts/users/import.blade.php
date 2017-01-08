@extends('layouts.app')

@section('content')
    <div class="primary-content">
        <div class="">
            <h2 class="page-header mb30">Import {!! ucwords($title) !!}</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.users.upload.multiple'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}

                <div class="row">
                    @if(count($usersData) > 0)

                        <div class="col-md-12">
                            <?php $i = 1; ?>
                                @foreach ($usersData as $key => $userArray)
                                    @if ($i < 6)
                                        <div class="row" style="margin-bottom:20px;border-bottom:1px solid #ececec;padding-bottom:20px;">
                                            @foreach ($userArray as $importField => $importValue)
                                                <div class="col-md-1">
                                                    @if ($i ==1) <strong>{!! ucwords($importField) !!}</strong><br/> @endif
                                                    <input type="" name="" value="{!! $importValue !!}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                    <?php $i++; ?>
                                @endforeach
                            @endif
                        </div>
                        <input type="hidden" value="{{$title}}" name="type">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}

                    @else

                        <p>Sorry, there were no {!! $title !!} found.</p>

                    @endif


                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection
