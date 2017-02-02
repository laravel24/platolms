@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Edit Minor</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.minors.update', $minor->id], 'id' => 'form', 'method' => 'put', 'files' => 'true']) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="control-label" for="name">Minor Name</label>
                    <input type="text" class="form-control" name="name" v-model="minorName" required>
                    @if ($errors->has('name'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                    @endif
                    <small>URL: /minors/<span id="minorNamePreview">@{{ minorName | slugify }}</span></small>
                    <input type="hidden" name="slug" v-model="slug">
                </div>

                {!! makeNumberInputField('hours', 'Hours', $minor->hours, '', 'required', $errors) !!}
                {!! makeTextAreaField('description', 'Description', $minor->description, '', 'required', $errors) !!}

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
                minorName: '<?php echo $minor->name; ?>',
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.minorName);
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