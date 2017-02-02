@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Create Course</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.courses.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
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

                {!! makeTextField('sub_title', 'Sub Title', '', '', 'optional', $errors) !!}
                {!! makeTextField('number', 'Course Number', '', '', 'required', $errors) !!}
                @if (!empty(Config::get('settings.course.levels')))
                    {!! makeSelectField('level', Config::get('settings.course.levels'), 'Course Level', '', '', 'required', $errors, '') !!}
                @endif
                {!! makeSelectField('subject_id', $subjects, 'Subject', '', '', 'required', $errors, '') !!}
                {!! makeSelectField('tags[]', $tags, 'Tags', '', '', 'required', $errors, '', true) !!}
                {!! makeTextAreaField('description', 'Description', '', '', 'required', $errors) !!}
                {!! makeCheckBoxField('online', 'This Course Is Offered Online?', '1', '1', '', 'optional', $errors) !!}
                {!! makeCheckBoxField('campus', 'This Course Is Offered On Campus?', '1', '1', '', 'optional', $errors) !!}

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
                courseTitle: '',
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
                    return value.split(' ').join('-').toLowerCase();
                }
            },
            methods: {
                slugifyTitle: function (value) {
                    if (!value) return '';
                    value = value.trim();
                    value = value.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                    return value.split(' ').join('-').toLowerCase();
                }
            }
        })
    </script>
@endsection