<div class="main-sidebar">
    <h5>Administration</h5>
	<div class="list-group">
        <a href="{{ route('admin.admins.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'users')) active @endif">Admins</a>
        <a href="{{ route('admin.students.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'users')) active @endif">Students</a>
    </div>

    <h5>Portal</h5>
    <div class="list-group">
        <a href="{{ route('admin.pages.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'pages')) active @endif">Pages</a>
        <a href="{{ route('admin.posts.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'posts')) active @endif">Posts</a>
        <a href="{{ route('admin.categories.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'post-categories')) active @endif">Post Categories</a>
        <a href="{{ route('admin.tags.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'post-tags')) active @endif">Post Tags</a>
    </div>

    <h5>Degree Programs</h5>
    <div class="list-group">
        <a href="{{ route('admin.colleges.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'colleges')) active @endif">Colleges</a>
        <a href="{{ route('admin.degrees.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'degrees')) active @endif">Degrees</a>
        <a href="{{ route('admin.majors.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'majors')) active @endif">Majors</a>
        <a href="{{ route('admin.minors.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'minors')) active @endif">Minors</a>
        <a href="{{ route('admin.catalogues.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'catalogues')) active @endif">Catalogues</a>
        <a href="{{ route('admin.concentrations.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'concentrations')) active @endif">Concentrations</a>
        <a href="{{ route('admin.plans.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'plans')) active @endif">Plans</a>
        <a href="{{ route('admin.semesters.index') }}" class="list-group-item @if (isset($menuTab) && ($menuTab == 'semesters')) active @endif">Semesters</a>
    </div>

    <h5>Courses</h5>
    <div class="list-group">
        <a href="" class="list-group-item @if (isset($menuTab) && ($menuTab == 'course-categories')) active @endif">Course Categories</a>
        <a href="" class="list-group-item @if (isset($menuTab) && ($menuTab == 'courses')) active @endif">Courses</a>
    </div>
</div>
