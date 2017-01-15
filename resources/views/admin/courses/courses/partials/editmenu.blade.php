            <span class="pull-right">
                <small>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href="{{ route('admin.courses.options', $course->id) }}"><i class="fa fa-user"></i> &nbsp; Options</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                           <a href="{{ route('admin.courses.scheduling', $course->id) }}"><i class="fa fa-user"></i> &nbsp; Scheduling</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href="{{ route('admin.courses.revisions', $course->id) }}"><i class="fa fa-user"></i> &nbsp; Revisions</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href=""><i class="fa fa-user"></i> &nbsp; Content</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href="{{ route('admin.courses.files', $course->id) }}"><i class="fa fa-user"></i> &nbsp; Files</a>
                    </span>
                </small>
            </span>