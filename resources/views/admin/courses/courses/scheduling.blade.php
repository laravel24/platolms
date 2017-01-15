@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Course Scheduling
            @include('admin.courses.courses.partials.editmenu')
        </h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            <h4 class="course-title"><span class="label label-default">{{ $course->subject->abbr }}{{ $course->number }}</span> {{ $course->title }} @if($course->sub_title) : {{ $course->sub_title }} @endif</h4>

            {!! Form::open(['route' => ['admin.courses.update.scheduling', $course->id], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                
                <h5>Semesters Offered</h5>

                {!! makeSelectField('campus', $campuses, 'Campus', '', '', 'required', $errors, '') !!}
                {!! makeSelectField('semester', $semesters, 'Semester', '', '', 'required', $errors, '') !!}
                <div class="form-group {{ $errors->has('semester_id') ? ' has-error' : '' }}">
                    <label class="control-label" for="semester_id">Semester</label>
                    <input type="text" class="form-control" name="semester_id" v-model="semester" required>
                    @if ($errors->has('semester_id'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('semester_id') }}</strong>
                            </span>
                    @endif
                </div>
              
                {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}
            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const vm = new Vue({
            el: '#page-content',
            data: {
                name: 'Vue.js',
                semester: '',
            },
            http: {
                    emulateJSON: true,
                    emulateHTTP: true
            },
            methods: {
                isCourseOfferedOnline: function(selectedUsers)
                {
                    return selectedUsers.length > 0 ? 'enabled' : 'disabled';
                },
                isCourseOfferedOnCampus: function(selectedUsers)
                {
                    return selectedUsers.length > 0 ? 'enabled' : 'disabled';
                },
            }
        })
    </script>
@endsection