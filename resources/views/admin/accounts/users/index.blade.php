@extends('layouts.app')

@section('styles')
<style>
    #user-table { margin-bottom:20px; }
    #user-table_length, #user-table_info { padding-left:8px; }
    #user-table_filter, #user-table_paginate { padding-right:8px; }
</style>
@endsection

@section('content')
    <div class="primary-content" id="page-content">
        <h2 class="page-header mb30">All {{ $title }}
            <span class="pull-right">
                <small>
                    <span style="font-size:70%;font-weight:700;">
                            @if ($title == 'students') <a href="{{ route('admin.students.create') }}"> @else <a href="{{ route('admin.users.create') }}"> @endif
                            <i class="fa fa-user"></i> &nbsp; New {{ substr($title, 0, -1) }}
                            </a>
                    </span>
                    @if ($title !== 'Admins')
                        <span style="margin-left:15px;font-size:70%;font-weight:700;">
                                <a href="{{ route('admin.users.import', strtolower($title)) }}"><i class="fa fa-upload"></i> &nbsp; Import {{ $title }}</a>
                        </span>
                    @endif
                </small>
            </span>
        </h2>

        @include('layouts.partials.flash')      

        <div class="content-box">      

            <div class="table-responsive">
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

                            <tr id="{{ $user->id }}">
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
                    <a class="btn btn-link" v-bind:class="areUsersSelected(selectedUsers)" style="" @click.prevent="deleteMultipleUsers(event)">Delete All</a>
                </div>

                <div class="{{ getColumns(6) }} text-right plato-pagination">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <!-- #devtodo: Move the script up to gulp/app.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.1.0/sweetalert2.min.js"></script>
    <script>
            // SweetAlert -> Send the AJAX Call to Delete the User w/ Confirmation & Error States
            const userArchiveLimit = {!! Config::get('settings.user_archive_limit') !!};
            const adminURI = "{!! env('ADMIN_URI') !!}";
            var selectedUsers = [];

            const vm = new Vue({
                el: '#page-content',
                data: {
                    name: 'Vue.js',
                    selectedUsers: selectedUsers,
                },
                // define methods under the `methods` object
                methods: {
                    areUsersSelected: function(selectedUsers)
                    {
                        return selectedUsers.length > 0 ? 'enabled' : 'disabled';
                    },
                    shouldInputBoxBeChecked: function(selectedUsers)
                    {
                        return selectedUsers.length > 0 ? 'checked' : 'unchecked';
                    },
                    deleteMultipleUsers: function (event) {
                        swal({
                            title: 'Are you sure?',
                            text: "The users, and their information, will be removed from the archive in " + userArchiveLimit + " days!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success mr20',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        })
                        .then(function() {
                            // Send the AJAX that deletes the user
                            Vue.http.post('/' + adminURI + '/users/delete/multiple', {'users': selectedUsers}).then((response) => {
                                for (var id in selectedUsers)
                                {
                                    $('#' + selectedUsers[id]).hide();
                                }
                                swal({
                                    title: 'Archive Complete',
                                    text: "This users have been archived.",
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonText: 'Got it!',
                                    confirmButtonClass: 'btn btn-success',
                                    buttonsStyling: false
                                })
                            }, (response) => {
                                console.log(response);
                                // error callback
                                swal(
                                    'Sorry!',
                                    'There was an error with your request!',
                                    'error'
                                )
                            });
                        }, function(dismiss) {
                            //
                        })
                    },
                    confirmDelete: function (id, event) {
                        swal({
                            title: 'Are you sure?',
                            text: "The user, and their information, will be removed from the archive in " + userArchiveLimit + " days!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success mr20',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        })
                        .then(function() {
                            // Send the AJAX that deletes the user
                            Vue.http.delete('/' + adminURI + '/users/' + id, {}).then((response) => {
                                $('#' + id).hide();
                                console.log(response);
                                swal({
                                    title: 'Archive Complete',
                                    text: "This user has been archived.",
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonText: 'Got it!',
                                    confirmButtonClass: 'btn btn-success',
                                    buttonsStyling: false
                                })
                            }, (response) => {
                                console.log(response);
                                // error callback
                                swal(
                                    'Sorry!',
                                    'There was an error with your request!',
                                    'error'
                                )
                            });
                        }, function(dismiss) {
                            //
                        })
                    }
                }
            })

    </script>
@endsection