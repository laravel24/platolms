@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Create Subject</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.subjects.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="control-label" for="name">Subject Title</label>
                    <input type="text" class="form-control" name="name" v-model="subjectName" required>
                    @if ($errors->has('name'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                    @endif
                    <small>URL: /subjects/<span id="subjectNamePreview">@{{ subjectName | slugify }}</span></small>
                    <input type="hidden" name="slug" v-model="slug">
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
                subjectName: '',
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.subjectName);
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