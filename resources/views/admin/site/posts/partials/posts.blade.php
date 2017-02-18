    @if ($posts->count() > 0)
        <div class="table-responsive">
            <div style="float:left;">
<!--                 <input type="radio" id="All" v-model="selectedPosts" value="All">
                <label for="All">All</label> -->
            </div>
                    <multiselect v-model="selectedPosts" :options="categoriesGet" :searchable="false" :close-on-select="true" placeholder="Pick a value" label="title" track-by="id"></multiselect>
<!-- 

 
                    <select v-model="selectedPosts">
                        <option v-for="category in categories" v-bind:value="category">
                            @{{ category }}
                        </option>
                    </select>-->
           @foreach ($categoriesGet as $category)
                <div style="margin-left:15px;float:left;">
                    <input type="radio" id="{{ $category->title }}" v-model="selectedPosts" value="{{ $category->title }}">
                    <label for="{{ $category->title }}">{{ $category->title }}</label>
                </div>
            @endforeach 
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th style="width: 40px;"></th>
                        <th></th>
                        <th class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr id="{{ $post->id }}" v-if="rowFilter('{!! $post->getCategories() !!}', selectedPosts)">
                            <td style="padding-top: 21px;text-align: center;"><input v-bind:class="shouldInputBoxBeChecked(selectedPosts)" class="checkbox-{{ $post->id }}" value="{{ $post->id }}" id="{{ $post->id }}" type="checkbox" v-model="selectedPosts"></td>
                            <td>
                                @if ($post->img)
                                    @if ($post->created_at)
                                        {!! getPostImage($post->id, $post->created_at, $post->img,  45, 'float-left') !!}
                                    @else
                                        {!! getPostImage($post->id, $post->scheduled_for, $post->img,  45, 'float-left') !!}
                                    @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post->id) }}">{{ $post->title }}</a>
                                <br>
                                <small>{{ $post->slug }}</small> 
                            </td>
                            <td class="text-right" style="padding-top: 15px;">
                                <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-success btn-sm"><i class="fa fa-globe"></i></a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-danger btn-sm" @click.prevent="confirmDelete({!! $post->id !!}, $event)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>There are no posts.</p>
    @endif  

    <div class="row">
        <div class="{{ getColumns(6) }}">
            <a class="btn btn-link" v-bind:class="arePostsSelected(selectedPosts)" style="" @click.prevent="deleteMultiplePosts(selectedPosts)">Delete All</a>
        </div>

        <div class="{{ getColumns(6) }} text-right plato-pagination">
            {{ $posts->links() }}
        </div>
    </div>

