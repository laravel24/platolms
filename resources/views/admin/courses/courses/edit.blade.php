@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Update Course
            <span class="pull-right">
                <small>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                           <a href=""><i class="fa fa-user"></i> &nbsp; Semesters</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href=""><i class="fa fa-user"></i> &nbsp; Revisions</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href=""><i class="fa fa-user"></i> &nbsp; Online Content</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href=""><i class="fa fa-user"></i> &nbsp; Files</a>
                    </span>
                </small>
            </span>
        </h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.courses.update', $course->id], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label class="control-label" for="title">Course Title</label>
                    <input type="text" class="form-control" name="title" v-model="courseTitle" required>
                    @if ($errors->has('title'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                    @endif
                    <small>URL: /courses/<span id="courseTitlePreview">@{{ courseTitle | slugify }}</span></small>
                    <input type="hidden" name="slug" v-model="slug">
                </div>

                {!! makeTextField('sub_title', 'Sub Title', $course->sub_title, '', 'optional', $errors) !!}
                {!! makeSelectField('subjects[]', $subjects, 'Subjects', $course->subjects->pluck('id')->toArray(), '', 'required', $errors, '', true) !!}
                {!! makeTextAreaField('description', 'Description', $course->description, '', 'required', $errors) !!}
                {!! makeCheckBoxField('online', 'This Course Is Offered Online Too?', '1', $course->online, '', 'optional', $errors) !!}

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