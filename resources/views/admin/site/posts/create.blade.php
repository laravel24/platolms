@extends('layouts.app')

@section('styles')
    <link href="{{ asset('vendor/summernote/dist/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/summernote/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="primary-content" id="page-content">
        <div class="">
            <h2 class="page-header mb30">New Post</h2>
        </div>

        @include('layouts.partials.flash')      

        <div class="content-box">          
            
            {!! Form::open(['route' => ['admin.posts.store'], 'id' => 'form', 'method' => 'post', 'files' => 'true']) !!}

                <div class="admin-post-content row">
                    <div class="post-content-main {{ getColumns(9) }}">
                        <div class="form-group">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="control-label" for="title">Post Title</label>
                                <input type="text" class="form-control" name="title" v-model="postName" required>
                                @if ($errors->has('title'))
                                    <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                @endif
                                <small>URL: /front-end/blog-page/<span id="postNamePreview">@{{ postName | slugify }}</span></small>
                                <input type="hidden" name="slug" v-model="slug">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label><br/>
                            <div style="font-weight:normal;font-family:'Helvetica Neue'">
                                {!! Form::textarea('content', '', ['required', 'id' => 'content', 'placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Featured Image</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <p>Add Featured Image</p>
                            </div><!-- .panel-body -->
                        </div>

                    </div>

                    <div class="post-content-sidebar {{ getColumns(3) }}">

                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Publish Info</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <p>Schedule the post </p>
                            </div><!-- .panel-body -->
                            <div class="panel-footer">
                                {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']) !!}
                            </div><!-- /.panel-footer -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Post Type</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <p>Pick post type</p>
                            </div><!-- .panel-body -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Categories</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <multiselect v-model="postCategories" :options="categories" :multiple="true" :close-on-select="true" :clear-on-select="true" :hide-selected="true" placeholder="Pick some" label="title" track-by="id"></multiselect>
                            </div><!-- .panel-body -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Tags</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <multiselect v-model="postTags" :options="tags" :multiple="true" :close-on-select="true" :clear-on-select="true" :hide-selected="true" placeholder="Pick some" label="title" track-by="id"></multiselect>
                            </div><!-- .panel-body -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Author</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <p>Pick Author</p>
                            </div><!-- .panel-body -->
                        </div>

                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('vendor/summernote/dist/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                minHeight: 300,
                fontNames: ['Helvetica Neue', 'Times New Roman'],
                help: false,
            });
        });
    </script>
    <script>
        const vm = new Vue({
            el: '#page-content',
            data: {
                name: 'Vue.js',
                postName: '',
                postCategories: '',
                categories: {!! $categories !!},
                postTags: '',
                tags: {!! $tags !!}
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.postName);
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