@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Update College</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.colleges.update', $college->id], 'id' => 'form', 'method' => 'put', 'files' => 'true']) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="control-label" for="name">College Name</label>
                    <input type="text" class="form-control" name="name" v-model="collegeName" required>
                    @if ($errors->has('name'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                    @endif
                    <small>URL: /colleges/<span id="collegeNamePreview">@{{ collegeName | slugify }}</span></small>
                    <input type="hidden" name="slug" v-model="slug">
                </div>

                {!! makeTextAreaField('description', 'Description', $college->description, '', 'required', $errors) !!}
                {!! makeSelectField('contact_id', $admins, 'Contact To Display', $college->contact_id, '', 'required', $errors) !!}

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
                collegeName: "<?php echo $college->name; ?>"
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.collegeName);
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