    <!-- #devtodo: Move the script up to gulp/app.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.1.0/sweetalert2.min.js"></script>
    <script>
            // SweetAlert -> Send the AJAX Call to Delete the User w/ Confirmation & Error States
            const userArchiveLimit = {!! Config::get('settings.user.user_archive_limit') !!};
            const adminURI = "{!! env('ADMIN_URI') !!}";
            var selectedUsers = [];
            var selectedRoles = 'All';
            var roles = "{!! getRolesAsStrings() !!}".split(',');

            const vm = new Vue({
                el: '#page-content',
                data: {
                    name: 'Vue.js',
                    roles: roles,
                    selectedUsers: selectedUsers,
                    selectedRoles: selectedRoles,
                },
                http: {
                        emulateJSON: true,
                        emulateHTTP: true
                },
                // define methods under the `methods` object
                methods: {
                    rowFilter: function(userRoles, selectedRoles)
                    {
                        if ((selectedRoles == 'All') || (userRoles.split(',').indexOf(selectedRoles) >= 0))
                        {
                            return true;
                        }
                        return false;
                    },
                    areUsersSelected: function(selectedUsers)
                    {
                        return selectedUsers.length > 0 ? 'enabled' : 'disabled';
                    },
                    shouldInputBoxBeChecked: function(selectedUsers)
                    {
                        return selectedUsers.length > 0 ? 'checked' : 'unchecked';
                    },
                    deleteMultipleUsers: function (selectedUsers) 
                    {
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
                                console.log(response);
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
                    confirmDelete: function (id, event) 
                    {
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