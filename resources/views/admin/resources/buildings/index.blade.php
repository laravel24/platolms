@extends('layouts.app')

@section('content')
    <div class="primary-content" id="page-content">
        <h2 class="page-header mb30">All Buildings
            <span class="pull-right">
                <small>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href="{{ route('admin.buildings.create') }}"><i class="fa fa-user"></i> &nbsp; New Building</a>
                    </span>
                </small>
            </span>
        </h2>

        @include('layouts.partials.flash')      

        @if (count($buildings) > 0)

            <div class="content-box">      
                <div class="table-responsive">
                    <table id="buildings-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buildings as $building)

                                <tr id="{{ $building->id }}">
                                    <td>
                                        <a href="{{ route('admin.buildings.show', $building->id) }}">{{ $building->title }}</a>
                                    </td>
                                    <td class="text-right" style="padding-top: 15px;">
                                        <a href="{{ route('admin.buildings.show', $building->id) }}" class="btn btn-success btn-sm"><i class="fa fa-globe"></i></a>
                                        <a href="{{ route('admin.buildings.edit', $building->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-danger btn-sm" @click.prevent="confirmDelete({!! $building->id !!}, $event)"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @else

            <div>
                <p>You have no buildings added at this time.</p>
            </div>

        @endif

    </div>

@endsection

@section('scripts')
    <!-- #devtodo: Move the script up to gulp/app.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.1.0/sweetalert2.min.js"></script>
    <script>
            // SweetAlert -> Send the AJAX Call to Delete the User w/ Confirmation & Error States
            const adminURI = "{!! env('ADMIN_URI') !!}";

            const vm = new Vue({
                el: '#page-content',
                data: {
                    name: 'Vue.js',
                },
                http: {
                        emulateJSON: true,
                        emulateHTTP: true
                },
                // define methods under the `methods` object
                methods: {
                    confirmDelete: function (id, event) 
                    {
                        swal({
                            title: 'Are you sure?',
                            text: "The buildings will be archived and any associated data for the current cataloge along with it!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, archive it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success mr20',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        })
                        .then(function() {
                            // Send the AJAX that deletes the user
                            Vue.http.delete('/' + adminURI + '/buildings/' + id, {}).then((response) => {
                                $('#' + id).hide();
                                console.log(response);
                                swal({
                                    title: 'Archive Complete',
                                    text: "This building has been archived.",
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