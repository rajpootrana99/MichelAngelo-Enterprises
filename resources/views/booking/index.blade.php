@extends('layouts.base')

@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">Bookings</h4>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end page-title-box-->
            </div><!--end col-->
        </div><!--end row-->
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mt-4">Bookings
                        </div>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="alert alert-success border-0" style="display: none" role="alert" id="success_alert"></div>
                        <div class="alert alert-danger border-0" style="display: none" role="alert" id="warning_alert"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 table-centered">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">User</th>
                                        <th>Service</th>
                                        <th width="20%">Date</th>
                                        <th width="20%">Status</th>
                                        <th width="3%"><i class="fa fa-check-circle"></i></th>
                                        <th width="3%"><i class="fas fa-times-circle"></i></th>
                                        <th width="3%"><i class="fa fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table><!--end /table-->
                        </div><!--end /tableresponsive-->
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteBooking" tabindex="-1" role="dialog" aria-labelledby="deleteBookingLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="deleteBookingLabel">Delete</h6>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-times"></i></span>
                    </button>
                </div><!--end modal-header-->
                <form method="post" id="deleteBookingForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="booking_id" name="booking_id">
                            <p class="mb-4">Are you sure want to delete?</p>
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Yes</button>
                    </div><!--end modal-footer-->
                </form>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>

    <script>
        $(document).ready(function (){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchBookings();

            function fetchBookings()
            {
                $.ajax({
                    type: "GET",
                    url: "fetchBookings",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.bookings, function (key, booking) {
                            if(booking.status === 'Pending'){
                                var status = '<span class="badge badge-primary">'+booking.status+'</span>';
                            }
                            if(booking.status === 'Booked'){
                                var status = '<span class="badge badge-info">'+booking.status+'</span>';
                            }
                            if(booking.status === 'Reject'){
                                var status = '<span class="badge badge-danger">'+booking.status+'</span>';
                            }
                            if(booking.status === 'Complete'){
                                var status = '<span class="badge badge-success">'+booking.status+'</span>';
                            }
                            if(booking.status === 'Expire'){
                                var status = '<span class="badge badge-warning">'+booking.status+'</span>';
                            }

                            $('tbody').append('<tr>\
                            <td>'+booking.id+'</td>\
                            <td>'+booking.user.name+'</td>\
                            <td><img src="storage/'+booking.service.image+'" alt="" class="rounded-circle thumb-xs mr-1">'+booking.service.name+'</td>\
                            <td>'+booking.date+'</td>\
                            <td>'+status+'</td>\
                            <td><button value="'+booking.id+'" style="border: none; background-color: #fff" class="book_btn"><i class="fa fa-check-circle"></i></button></td>\
                            <td><button value="'+booking.id+'" style="border: none; background-color: #fff" class="reject_btn"><i class="fas fa-times-circle"></i></button></td>\
                            <td><button value="'+booking.id+'" style="border: none; background-color: #fff" class="delete_btn"><i class="fa fa-trash"></i></button></td>\
                    </tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.book_btn', function (e) {
                e.preventDefault();
                var booking_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: 'bookBooking/'+booking_id,
                    dataType: "json",
                    success: function (response) {
                        fetchBookings();
                        $('#success_alert').html('<strong>Success! </strong>'+response.message)
                        $('#success_alert').css('display', 'block')
                        setTimeout(function () {
                            $('#success_alert').css('display', 'none')
                        }, 5000)
                    }
                });
            });

            $(document).on('click', '.reject_btn', function (e) {
                e.preventDefault();
                var booking_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: 'rejectBooking/'+booking_id,
                    dataType: "json",
                    success: function (response) {
                        fetchBookings();
                        $('#warning_alert').html('<strong>Warning! </strong>'+response.message)
                        $('#warning_alert').css('display', 'block')
                        setTimeout(function () {
                            $('#warning_alert').css('display', 'none')
                        }, 5000)
                    }
                });
            });

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var booking_id = $(this).val();
                $('#deleteBooking').modal('show');
                $('#booking_id').val(booking_id)
            });

            $(document).on('submit', '#deleteBookingForm', function (e) {
                e.preventDefault();
                var booking_id = $('#booking_id').val();

                $.ajax({
                    type: 'delete',
                    url: 'user/'+booking_id,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 0) {
                            $('#deleteBooking').modal('hide');
                            $('#warning_alert').html('<strong>Warning! </strong>'+response.message)
                            $('#warning_alert').css('display', 'block')
                            setTimeout(function () {
                                $('#warning_alert').css('display', 'none')
                            }, 5000)
                        }
                        else {
                            fetchBookings();
                            $('#deleteBooking').modal('hide');
                            $('#warning_alert').html('<strong>Warning! </strong>'+response.message)
                            $('#warning_alert').css('display', 'block')
                            setTimeout(function () {
                                $('#warning_alert').css('display', 'none')
                            }, 5000)
                        }
                    }
                });
            });
        });
    </script>
@endsection
