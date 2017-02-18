    <!-- #devtodo: Move the script up to gulp/app.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.1.0/sweetalert2.min.js"></script>
    <script>
            // SweetAlert -> Send the AJAX Call to Delete the User w/ Confirmation & Error States
            const adminURI = "{!! env('ADMIN_URI') !!}";
            var selectedPosts = [];
            var selectedFilters = 'All';
            var filters = "{!! $categories !!}".split(',');

            const vm = new Vue({
                el: '#page-content',
                data: {
                    name: 'Vue.js',
                    filters: filters,
                    selectedPosts: selectedPosts,
                    selectedFilters: selectedFilters,
                    categories: {!! $categories !!},
                },
                http: {
                        emulateJSON: true,
                        emulateHTTP: true
                },
                // define methods under the `methods` object
                methods: {
                    rowFilter: function(filters, selectedFilters)
                    {
                        if ((selectedFilters == 'All') || (filters.split(',').indexOf(selectedFilters) >= 0))
                        {
                            return true;
                        }
                        return false;
                    },
                    areUsersSelected: function(selectedPosts)
                    {
                        return selectedPosts.length > 0 ? 'enabled' : 'disabled';
                    },
                    shouldInputBoxBeChecked: function(selectedPosts)
                    {
                        return selectedPosts.length > 0 ? 'checked' : 'unchecked';
                    },
                    deleteMultiplePosts: function (selectedPosts) 
                    {
                        swal({
                            title: 'Are you sure?',
                            text: "The post will be archived.",
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
                            Vue.http.post('/' + adminURI + '/posts/delete/multiple', {'posts': selectedPosts}).then((response) => {
                                console.log(response);
                                for (var id in selectedPosts)
                                {
                                    $('#' + selectedPosts[id]).hide();
                                }
                                swal({
                                    title: 'Archive Complete',
                                    text: "This posts have been archived.",
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
                            text: "The post will be archived.",
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
                            Vue.http.delete('/' + adminURI + '/posts/' + id, {}).then((response) => {
                                $('#' + id).hide();
                                console.log(response);
                                swal({
                                    title: 'Archive Complete',
                                    text: "This post has been archived.",
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