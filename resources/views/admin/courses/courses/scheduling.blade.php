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
                {!! makeSelectField('semester_id', $semesters, 'Semester', '', '', 'required', $errors, '') !!}
<br/>
                <h5>Campus</h5>
                <div class="form-group {{ $errors->has('campus_id') ? ' has-error' : '' }}">
                    <label class="control-label" for="campus_id">Campus</label>
                    <select class="form-control" name="campus_id" v-model="campus_id" required>
                        @foreach ($campuses as $campus)
                            <option v-bind:value="{{ $campus->id }}">{{ $campus->title }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('campus_id'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block">
                            <strong>{{ $errors->first('campus_id') }}</strong>
                        </span>
                    @endif
                </div>

                <input type="checkbox" v-model="online">
                <p>if "is online" is checked ... Populate Buildings .... then Rooms... based on campus filled out</p>
                <select type="name" v-bind:value="getValue(online, campus_id)">
                        @foreach ($instructors as $instructor)
                            <option v-bind:value="{{ $instructor->id }}">{{ $instructor->display_name }}</option>
                        @endforeach
                </select>

<br/><br/>
                <h5>Instructor</h5>
                <div class="form-group {{ $errors->has('instructor_id') ? ' has-error' : '' }}">
                    <label class="control-label" for="instructor_id">Instructor</label>
                    <select class="form-control" name="instructor_id" v-model="instructor_id" required>
                        @foreach ($instructors as $instructor)
                            <option v-bind:value="{{ $instructor->id }}">{{ $instructor->display_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('instructor_id'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block">
                            <strong>{{ $errors->first('instructor_id') }}</strong>
                        </span>
                    @endif
                </div>

                <p>When instructor is selected ... Check the instructors course load</p>

                {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right']) !!}
            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const adminURI = "{!! env('ADMIN_URI') !!}";

        const vm = new Vue({
            el: '#page-content',
            data: {
                name: 'Vue.js',
                buildings: [],
                instructor_id: '',
                campus_id: '',
                online: '',
            },
            http: {
                    emulateJSON: true,
                    emulateHTTP: true
            },
            methods: {
                getValue: function(online, campus_id)
                {
                    if (online)
                    {
                        console.log(campus_id)
                        return campus_id;
                    }

                    return '32';
                    // if (campus_id)
                    // {
                    //     // Send the AJAX that gets the buildings in a campus
                    //     Vue.http.post('/' + adminURI + '/resources/campuses/getbuildings', {'campus': campus_id}).then((response) => {
                    //         console.log(response);                            
                    //     }, (response) => {
                    //         console.log(response);
                    //     });
                    // } else {
                    //     return '0';
                    // }
                },
            }
        })
    </script>
@endsection