@extends('layouts.app')

@section('content')
    <div class="primary-content">
        <div class="">
            <h2 class="page-header mb30">Create @if(isset($studentLabel)) Student @else User @endif</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            @if(isset($studentLabel))
                {!! Form::open(['route' => ['admin.students.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
            @else
                {!! Form::open(['route' => ['admin.users.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
            @endif

                {!! makeTextField('first', 'First Name', '', '', 'required', $errors) !!}
                {!! makeTextField('last', 'Last Name', '', '', 'required', $errors)!!}
                {!! makeEmailField('email', 'Email', '', '', 'required', $errors) !!}

                @if(!isset($studentLabel))
                    <div class="row">
                        @foreach ($roles as $role)
                            <div style="margin-left:15px;float:left;">
                                <input type="checkbox" id="{{ $role->name }}" name="roles[]" value="{{ $role->id }}">
                                <label for="{{ $role->name }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                @else

                @endif

                {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}

            {!! Form::close() !!}

        </div>
    </div>

@endsection
