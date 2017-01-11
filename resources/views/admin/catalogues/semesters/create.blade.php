<?php
$now =  \Carbon\Carbon::now();
?>
@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Create Semesters</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.semesters.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label class="control-label" for="title">Semester Title</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                    @if ($errors->has('title'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                    @endif
                </div>

                {!! makeDateInputField('start', 'Start Date:', $now, '', 'required', $errors) !!}
                {!! makeDateInputField('end', 'End Date:', $now, '', 'required', $errors) !!}

                {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}
            {!! Form::close() !!}

        </div>
    </div>

@endsection
