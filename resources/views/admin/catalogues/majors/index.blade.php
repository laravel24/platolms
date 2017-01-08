@extends('layouts.app')

@section('styles')
<style>
    /*#majors-table { margin-bottom:20px; }
    #majors-table_length, #majors-table_info { padding-left:8px; }
    #majors-table_filter, #majors-table_paginate { padding-right:8px; }*/
</style>
@endsection

@section('content')
    <div class="primary-content" id="page-content">
        <h2 class="page-header mb30">All {{ $title }}s
            <span class="pull-right">
                <small>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                           <a href="{{ route('admin.majors.archived') }}"><i class="fa fa-user"></i> &nbsp; Archived {{ $title }}s</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href="{{ route('admin.majors.create') }}"><i class="fa fa-user"></i> &nbsp; New {{ $title }}</a>
                    </span>
                    <span style="margin-left:15px;font-size:70%;font-weight:700;">
                            <a href="{{ route('admin.majors.import', strtolower($title)) }}"><i class="fa fa-upload"></i> &nbsp; Import {{ $title }}</a>
                    </span>
                </small>
            </span>
        </h2>

        @include('layouts.partials.flash')      

        @if (count($majors) > 0)

            <div class="content-box">      
                <div class="table-responsive">
                    <table id="majors-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($majors as $major)

                                <tr id="{{ $major->id }}">
                                    <td>
                                        <a href="{{ route('admin.majors.show', $major->id) }}">{{ $major->name }}</a>
                                    </td>
                                    <td class="text-right" style="padding-top: 15px;">
                                        <a href="{{ route('admin.majors.show', $major->id) }}" class="btn btn-success btn-sm"><i class="fa fa-globe"></i></a>
                                        <a href="{{ route('admin.majors.edit', $major->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-danger btn-sm" @click.prevent="confirmDelete({!! $major->id !!}, $event)"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="{{ getColumns(12) }} text-right plato-pagination">
                        {{ $majors->links() }}
                    </div>
                </div>
            </div>

        @else

            <div>
                <p>You have no majors added at this time.</p>
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
                            text: "The major will be archived and any associated data for the current cataloge along with it!",
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
                            Vue.http.delete('/' + adminURI + '/majors/' + id, {}).then((response) => {
                                $('#' + id).hide();
                                console.log(response);
                                swal({
                                    title: 'Archive Complete',
                                    text: "This major has been archived.",
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