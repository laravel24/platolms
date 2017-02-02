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

            <h4 class="course-title">
                <span class="label label-default">{{ $course->subject->abbr }}{{ $course->number }}</span> 
                {{ $course->title }} @if($course->sub_title) : {{ $course->sub_title }} @endif
            </h4>

            {!! Form::open(['route' => ['admin.courses.update.scheduling', $course->id], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                
                <h5>Semesters Offered</h5>
                {!! makeSelectField('semester_id', $semesters, 'Semester', '', '', 'required', $errors, '') !!}

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

                <input type="checkbox" v-model="onCampus">
                <p>if "is onCampus" is checked ... Populate Buildings .... then Rooms... based on campus filled out</p>
                <!-- v-bind:value="getValue(online, campus_id)"  -->
                <select type="name" v-if="onCampus" v-model="selectedBuilding">
                    <option v-for="building in buildings" v-bind:value="building.id">
                        @{{ building.name }}
                    </option>
                </select>
                <span>Selected: @{{ selectedBuilding }}</span>

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
                buildings: '',
                selectedBuilding: '',
                instructor_id: '',
                campus_id: '',
                onCampus: ''
            },
            http: {
                    emulateJSON: true,
                    emulateHTTP: true
            },
            computed: {
                buildings: function () {
                    if (this.campus_id != 0)
                    {
                        // Send the AJAX that gets the buildings in a campus
                        Vue.http.post('/' + adminURI + '/campuses/getbuildings', {'campus': this.campus_id}).then((response) => {
                            if (response.body)
                            {
                                this.buildings = response.body;
                                Vue.set(vm.buildings, response.body);
                                this.buildings = Object.assign({}, this.buildings, response.body)
                                return this.buildings;
                                console.log('None of these work ^^^');
                            }
                        }, (response) => {
                            // return [];
                        });
                    }

                    return [
                        { name: 'One', id: 'A' },
                        { name: 'Two', id: 'B' },
                        { name: 'four', id: 'C' }
                    ];
                }
            }
        })
    </script>
@endsection