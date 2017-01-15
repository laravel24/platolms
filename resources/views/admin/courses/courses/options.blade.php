@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Course Options
            @include('admin.courses.courses.partials.editmenu')
        </h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            <h4 class="course-title"><span class="label label-default">{{ $course->subject->abbr }}{{ $course->number }}</span> {{ $course->title }} @if($course->sub_title) : {{ $course->sub_title }} @endif</h4>

            {!! Form::open(['route' => ['admin.courses.update.options', $course->id], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                
                <h5>Prequisite Courses</h5>

                {!! makeSelectField('prereqs[]', $coursesAsArray, 'Courses', $course->prerequisites->pluck('id')->toArray(), '', 'required', $errors, '', true) !!}

                <h5>Other Prequisites</h5>
                {!! makeTextAreaField('other_prerequisites', 'Other Prequisites', $courseOptions['other_prerequisites'], '', 'required', $errors) !!}

                <h5>Public Notes</h5>
                {!! makeTextAreaField('public_notes', 'Public Notes', $courseOptions['public_notes'], '', 'required', $errors) !!}

                <h5>Internal Notes</h5>
                {!! makeTextAreaField('internal_notes', 'Internal Notes', $courseOptions['internal_notes'], '', 'required', $errors) !!}

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
                courseTitle: '<?php echo $course->title; ?>',
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.courseTitle);
                }
            },
            filters: {
                slugify: function (value) {
                    if (!value) return '';
                    value = value.trim();
                    value = value.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                    return value.split(' ').join('').toLowerCase();
                }
            },
            methods: {
                slugifyTitle: function (value) {
                    if (!value) return '';
                    value = value.trim();
                    value = value.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                    return value.split(' ').join('').toLowerCase();
                }
            }
        })
    </script>
@endsection