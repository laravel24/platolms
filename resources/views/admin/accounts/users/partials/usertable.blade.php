<div class="table-responsive">
    @if(isset($title))
        <div style="float:left;">
            <input type="radio" id="All" v-model="selectedRoles" value="All">
            <label for="All">All</label>
        </div>
        @foreach ($roles as $role)
            <div style="margin-left:15px;float:left;">
                <input type="radio" id="{{ $role->name }}" v-model="selectedRoles" value="{{ $role->name }}">
                <label for="{{ $role->name }}">{{ $role->name }}</label>
            </div>
        @endforeach
    @endif
    <table id="user-table" class="table table-striped">
        <thead>
            <tr>
                <th style="width: 30px;"></th>
                <th style="width: 40px;"></th>
                <th></th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)

                <tr id="{{ $user->id }}" v-if="rowFilter('{!! $user->getRolesNames() !!}', selectedRoles)">
                    <td style="padding-top: 21px;text-align: center;"><input v-bind:class="shouldInputBoxBeChecked(selectedUsers)" class="checkbox-{{ $user->id }}" value="{{ $user->id }}" id="{{ $user->id }}" type="checkbox" v-model="selectedUsers"></td>
                    <td>
                        {!! getUserImage($user->id, $user->img, $user->email, 45, 'float-left img-circle') !!}
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}">
                        {{ $user->first }} {{ $user->last }}</a> 
                        <br/>
                        <small>{{ $user->email }}</small> 
                            <span id="rolediv-{{ $user->id }}">
                                @if ($user->getHighestRole()->name != env('STUDENT_LABEL', 'Student'))
                                    @foreach ($user->roles as $role) 
                                        {!! makeRoleLabel($role->name, false) !!} 
                                    @endforeach
                                @endif
                            </span>
                    </td>
                    <td class="text-right" style="padding-top: 15px;">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-success btn-sm"><i class="fa fa-globe"></i></a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                        <a href="{{ route('admin.users.edit.auth', $user->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-lock"></i></a>
                        <a class="btn btn-danger btn-sm" @click.prevent="confirmDelete({!! $user->id !!}, $event)"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="row">
    <div class="{{ getColumns(6) }}">
        <a class="btn btn-link" v-bind:class="areUsersSelected(selectedUsers)" style="" @click.prevent="deleteMultipleUsers(selectedUsers)">Delete All</a>
    </div>

    <div class="{{ getColumns(6) }} text-right plato-pagination">
        {{ $users->links() }}
    </div>
</div>
