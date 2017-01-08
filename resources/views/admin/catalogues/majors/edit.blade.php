@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">Edit {{ $major->name }}</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          

            {!! Form::open(['route' => ['admin.majors.update', $major->id], 'id' => 'form', 'method' => 'put', 'files' => 'true']) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="control-label" for="name">Major Name</label>
                    <input type="text" class="form-control" name="name" v-model="majorName" required>
                    @if ($errors->has('name'))
                        <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                    @endif
                    <small>URL: /majors/<span id="majorNamePreview">@{{ majorName | slugify }}</span></small>
                    <input type="hidden" name="slug" v-model="slug">
                </div>

                {!! makeNumberInputField('hours', 'Hours', $major->hours, '', 'required', $errors) !!}
                {!! makeTextAreaField('description', 'Description', $major->description, '', 'required', $errors) !!}
                {!! makeSelectField('college_id', $colleges, 'Colleges', $major->college_id, '', 'required', $errors) !!}
                {!! makeSelectField('degree_id', $degreeTypes, 'Degree Type', $major->degree_id, '', 'required', $errors) !!}

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
                majorName: '<?php echo $major->name; ?>',
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.majorName);
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