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
                                {!! Form::textarea('content', '', ['optional', 'id' => 'content', 'placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Featured Image</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">

                                <div v-if="image">
                                    <img class="responsive" :src="image" />
                                    <a class="btn btn-success" v-on:click.prevent="removeImage">Remove image</a>
                                </div>                                
                                <input type="file" name="featured_image" @change="onFileChange">
                            </div><!-- .panel-body -->
                        </div>

                    </div>

                    <div class="post-content-sidebar {{ getColumns(3) }}">

                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title">Publish Info</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <span>Status:</span> Draft<br/>
                                <div class="pull-left">
                                    <span>Publish:</span> <span v-if="!changePublishingDateClicked">Immediately</span><span v-if="changePublishingDateClicked">Another Date</span>
                                </div>
                                <div class="pull-right">
                                    <div v-if="!changePublishingDateClicked">
                                        <a class="btn-link" v-on:click.prevent="changePublishingDateClicked = !changePublishingDateClicked">Change</a>
                                    </div>
                                    <div v-if="changePublishingDateClicked">
                                        <a class="btn-link" v-on:click.prevent="changePublishingDateClicked = !changePublishingDateClicked">Cancel</a>
                                    </div>
                                </div>
                                <div class="row mt30" v-if="changePublishingDateClicked">
                                    <div class="{{ getColumns(5) }}">
                                        <multiselect v-model="postMonth" :options="months" select-label="" :searchable="false" :close-on-select="true" placeholder="{{ date('M') }}" label="title" track-by="id"></multiselect>
                                        <input type="hidden" name="post_month" v-model="postMonth">
                                    </div>
                                    <div class="{{ getColumns(3) }}">
                                        {!! Form::text('day', '', ['id' => 'day', 'placeholder' => date('d'), 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="{{ getColumns(4) }}">
                                        {!! Form::text('year', '', ['id' => 'year', 'placeholder' => date('Y'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div><!-- .panel-body -->
                            <div class="panel-footer">
                                {!! Form::submit('Save Draft', ['class' => 'btn btn-default pull-left']) !!}
                                {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']) !!}
                            </div><!-- /.panel-footer -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Post Type</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <multiselect v-model="postType" :options="types" :searchable="false" :close-on-select="true" placeholder="Pick a value" label="title" track-by="id"></multiselect>
                                <input type="hidden" name="post_type" v-model="postType">
                            </div><!-- .panel-body -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Categories</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <multiselect v-model="postCategories" :options="categories" :multiple="true" :close-on-select="true" :clear-on-select="true" :hide-selected="true" placeholder="Pick some" label="title" track-by="id"></multiselect>
                                <input type="hidden" name="post_categories" v-model="postCategories">
                            </div><!-- .panel-body -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Tags</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <multiselect v-model="postTags" :options="tags" :multiple="true" :close-on-select="true" :clear-on-select="true" :hide-selected="true" placeholder="Pick some" label="title" track-by="id"></multiselect>
                                <input type="hidden" name="post_tags" v-model="postTags">
                            </div><!-- .panel-body -->
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Author</h3>
                            </div><!-- /.panel-heading -->
                            <div class="panel-body">
                                <multiselect v-model="postAuthor" :options="authors" :searchable="false" :close-on-select="true" placeholder="Pick a value" label="display_name" track-by="id"></multiselect>
                                <input type="hidden" name="post_author" v-model="postAuthor">
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
                changePublishingDateClicked: false,
                postName: '',
                image: '',
                postType: '',
                types: {!! $postTypes !!},
                postCategories: '',
                categories: {!! $categories !!},
                postTags: '',
                tags: {!! $tags !!},
                postAuthor: '',
                authors: {!! $authors !!},
                postMonth: '',
                months: {!! $months !!},
            },
            // http: {
            //         emulateJSON: true,
            //         emulateHTTP: true
            // },
            computed: {
                slug: function () {
                    return this.slugifyTitle(this.postName);
                },
                createdImage: function() {
                    return this.image;
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
                },
                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    console.log(this.createImage(files[0]))
                    this.createImage(files[0]);
                },
                createImage(file) {
                    var image = new Image();
                    var reader = new FileReader();
                    var vm = this;

                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                removeImage: function (e) {
                    this.image = '';
                }
            }
        })
    </script>
@endsection