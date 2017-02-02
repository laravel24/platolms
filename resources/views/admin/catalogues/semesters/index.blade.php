<?php
$now =  \Carbon\Carbon::now();
$thisYear = \Carbon\Carbon::now()->year;
//$overlay=false;
?>
@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <h2 class="page-header mb30">Scheduling: All Semesters</h2>

        @include('layouts.partials.flash')      

        @if (count($semestersByYear) > 0)

            <div class="content-box">    
                <div class="row">
                    <div class="{{ getColumns(3) }}">
                        @if (isset($editSemester))
                            {!! Form::open(['route' => ['admin.semesters.update', $editSemester->id], 'id' => 'form', 'method' => 'put', 'files' => 'true']) !!}
                        @else
                            {!! Form::open(['route' => ['admin.semesters.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                        @endif

                        @if (isset($editSemester))
                            <div class="panel panel-warning @if (isset($overlay)) modal @endif">
                                <div class="panel-heading">
                                        <h3 class="panel-title">Edit {{ $editSemester->title }}</h3>
                        @else
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                        <h3 class="panel-title">Add New</h3>
                        @endif
                                </div><!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        @if (isset($editSemester))
                                            <input type="text" class="form-control" name="title" value="{{ $editSemester->title }}" placeholder="Title" required>
                                        @else
                                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Title" required>
                                        @endif
                                        @if ($errors->has('title'))
                                            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    @if (isset($editSemester))
                                        <div class="row">
                                            <div class="{{ getColumns(6) }}">
                                                {!! makeDateInputField('start', 'Start Date', $editSemester->start, '', 'required', $errors) !!}
                                            </div>
                                            <div class="{{ getColumns(6) }}">
                                                {!! makeDateInputField('end', 'End Date', $editSemester->end, '', 'required', $errors) !!}
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="{{ getColumns(6) }}">
                                                {!! makeDateInputField('start', 'Starts On', $now, '', 'required', $errors) !!}
                                            </div>
                                            <div class="{{ getColumns(6) }}">
                                                {!! makeDateInputField('end', 'Ends On', $now, '', 'required', $errors) !!}
                                            </div>
                                        </div>
                                    @endif
                                </div><!-- .panel-body -->
                                <div class="panel-footer">
                                    @if (isset($editSemester))
                                        <a class="btn btn-sm btn-default pull-left" href="{{ route('admin.settings.schedules.index') }}">Cancel</a>
                                        {!! Form::submit('Save Changes', ['class' => 'btn btn-sm btn-success pull-right']) !!}
                                    @else
                                        {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-success pull-right']) !!}
                                    @endif
                                </div><!-- /.panel-footer -->
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="{{ getColumns(9) }}">
                        <div class="semesters-div">

                            @foreach ($semestersByYear as $key => $semesters)
                                <div class="semester">
                                    <h3>@if ($key == $thisYear) This Year @else {{ $key }} @endif</h3>
                                    <div class="semester-list">
                                        @foreach ($semesters as $semester)
                                            <div class="semester-item {{ $semester->id }}">
                                                <div class="semester-item-name {{ getColumns(6) }}">
                                                    <a class="semester-item-title" href="{{ route('admin.semesters.show', $semester->id) }}">{{ $semester->title }}</a>
                                                    <br/><span class="description">{{ $semester->start }} - {{ $semester->end }}</span>
                                                </div>
                                                <div class="semester-item-actions text-right {{ getColumns(6) }}">
                                                    <a href="{{ route('admin.semesters.show', $semester->id) }}" class="btn btn-success btn-sm">
                                                        <i class="fa fa-area-chart"></i>
                                                    </a>
                                                    <a href="{{ route('admin.semesters.edit', $semester->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" @click.prevent="confirmDelete({!! $semester->id !!}, $event)">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> 
            </div>

        @else

            <div>
                <p>You have no semester added at this time.</p>
            </div>

        @endif

    </div>

@endsection

@section('scripts')
    <!-- #devtodo: Move the script up to gulp/app.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.1.0/sweetalert2.min.js"></script>
    <script>
            // SweetAlert -> Send the AJAX Call to Delete the User w/ Confirmation & Error States
            const adminURI = "{!! env('ADMIN_URI') !!}";

            const vm = new Vue({
                el: '#page-content',
                data: {
                    name: 'Vue.js',
                },
                http: {
                        emulateJSON: true,
                        emulateHTTP: true
                },
                // define methods under the `methods` object
                methods: {
                    confirmDelete: function (id, event) 
                    {
                        swal({
                            title: 'Are you sure?',
                            text: "The semester will be archived and any associated data for the current cataloge along with it!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, archive it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success mr20',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        })
                        .then(function() {
                            // Send the AJAX that deletes the user
                            Vue.http.delete('/' + adminURI + '/semesters/' + id, {}).then((response) => {
                                $('#' + id).hide();
                                console.log(response);
                                swal({
                                    title: 'Archive Complete',
                                    text: "This semester has been archived.",
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonText: 'Got it!',
                                    confirmButtonClass: 'btn btn-success',
                                    buttonsStyling: false
                                })
                            }, (response) => {
                                console.log(response);
                                // error callback
                                swal(
                                    'Sorry!',
                                    'There was an error with your request!',
                                    'error'
                                )
                            });
                        }, function(dismiss) {
                            //
                        })
                    }
                }
            })

    </script>
@endsection