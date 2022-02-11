@extends('layouts.base')

@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">Services</h4>
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
                        <div class="card-title mt-4">Services
                            <a href="" data-toggle="modal" data-target="#addService" id="addServiceButton" class="btn btn-primary" style="float:right;margin-left: 10px"><i class="fa fa-plus"></i> New Service </a>
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
                                    <th width="20%">Service Name</th>
                                    <th>Description</th>
                                    <th width="20%">Price</th>
                                    <th width="3%"><i class="fa fa-edit"></i></th>
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
    <div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="addServiceLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="addServiceLabel">Service Detail</h6>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-times"></i></span>
                    </button>
                </div><!--end modal-header-->
                <form method="post" id="addServiceForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label text-right">Service Name</label>
                                    <input class="form-control" type="text" name="name" id="name" >
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price" class="col-form-label text-right">Price</label>
                                    <input class="form-control" type="text" name="price" id="price" >
                                    <span class="text-danger error-text price_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="image" class="col-form-label text-right">Image</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="image" id="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                                <span class="text-danger error-text image_error"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label text-right">Description</label>
                                    <input class="form-control" type="text" name="description" id="description">
                                    <span class="text-danger error-text description_error"></span>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div><!--end modal-footer-->
                </form>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>

    <div class="modal fade" id="editService" tabindex="-1" role="dialog" aria-labelledby="editServiceLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="editServiceLabel">Service Detail</h6>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-times"></i></span>
                    </button>
                </div><!--end modal-header-->
                <form method="post" id="editServiceForm" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="service_id" id="service_id">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="edit_name" class="col-form-label text-right">Service Name</label>
                                    <input class="form-control" type="text" name="name" id="edit_name" >
                                    <span class="text-danger error-text name_update_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_price" class="col-form-label text-right">Price</label>
                                    <input class="form-control" type="text" name="price" id="edit_price" >
                                    <span class="text-danger error-text price_update_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="edit_image" class="col-form-label text-right">Image</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="image" id="edit_image">
                                    <label class="custom-file-label" for="edit_image">Choose file</label>
                                </div>
                                <span class="text-danger error-text image_update_error"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="edit_description" class="col-form-label text-right">Description</label>
                                    <input class="form-control" type="text" name="description" id="edit_description">
                                    <span class="text-danger error-text description_update_error"></span>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div><!--end modal-footer-->
                </form>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>

    <div class="modal fade" id="deleteService" tabindex="-1" role="dialog" aria-labelledby="deleteServiceLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="deleteServiceLabel">Delete</h6>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-times"></i></span>
                    </button>
                </div><!--end modal-header-->
                <form method="post" id="deleteServiceForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="service_id" name="service_id">
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

            fetchServices();

            function fetchServices()
            {
                $.ajax({
                    type: "GET",
                    url: "fetchServices",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.services, function (key, service) {
                            $('tbody').append('<tr>\
                            <td>'+service.id+'</td>\
                            <td><img src="storage/'+service.image+'" alt="" class="rounded-circle thumb-xs mr-1">'+service.name+'</td>\
                            <td>'+service.description+'</td>\
                            <td>'+Number(service.price).toFixed(2)+'</td>\
                            <td><button value="'+service.id+'" style="border: none; background-color: #fff" class="edit_btn"><i class="fa fa-edit"></i></button></td>\
                            <td><button value="'+service.id+'" style="border: none; background-color: #fff" class="delete_btn"><i class="fa fa-trash"></i></button></td>\
                    </tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var service_id = $(this).val();
                $('#deleteService').modal('show');
                $('#service_id').val(service_id)
            });

            $(document).on('submit', '#deleteServiceForm', function (e) {
                e.preventDefault();
                var service_id = $('#service_id').val();

                $.ajax({
                    type: 'delete',
                    url: 'service/'+service_id,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 0) {
                            $('#deleteService').modal('hide');
                            $('#warning_alert').html('<strong>Warning! </strong>'+response.message)
                            $('#warning_alert').css('display', 'block')
                            setTimeout(function () {
                                $('#warning_alert').css('display', 'none')
                            }, 5000)
                        }
                        else {
                            fetchServices();
                            $('#deleteService').modal('hide');
                            $('#warning_alert').html('<strong>Warning! </strong>'+response.message)
                            $('#warning_alert').css('display', 'block')
                            setTimeout(function () {
                                $('#warning_alert').css('display', 'none')
                            }, 5000)
                        }
                    }
                });
            });

            $(document).on('click', '.edit_btn', function (e) {
                e.preventDefault();
                var service_id = $(this).val();
                $('#editService').modal('show');
                $(document).find('span.error-text').text('');
                $.ajax({
                    type: "GET",
                    url: 'service/'+service_id+'/edit',
                    success: function (response) {
                        if (response.status == 404) {
                            $('#editService').modal('hide');
                        }
                        else {
                            $('#service_id').val(response.service.id);
                            $('#edit_name').val(response.service.name);
                            $('#edit_price').val(response.service.price);
                            $('#edit_description').val(response.service.description);
                        }
                    }
                });
            });

            $(document).on('submit', '#editServiceForm', function (e) {
                e.preventDefault();
                var service_id = $('#service_id').val();
                let EditFormData = new FormData($('#editServiceForm')[0]);

                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'), '_method': 'patch'},
                    url: "service/"+service_id,
                    data: EditFormData,
                    contentType: false,
                    processData: false,
                    beforeSend:function (){
                        $(document).find('span.error-text').text('');
                    },
                    success: function (response) {
                        if (response.status == 0){
                            $('#editService').modal('show')
                            $.each(response.error, function (prefix, val){
                                $('span.'+prefix+'_update_error').text(val[0]);
                            });
                        }else {
                            $('#editServiceForm')[0].reset();
                            $('#editService').modal('hide');
                            $('#success_alert').html('<strong>Success! </strong>'+response.message)
                            $('#success_alert').css('display', 'block')
                            setTimeout(function () {
                                $('#success_alert').css('display', 'none')
                            }, 5000)
                            fetchServices();
                        }
                    },
                    error: function (error){
                        console.log(error)
                        $('#editService').modal('show');
                    }
                });
            })

            $(document).on('submit', '#addServiceForm', function (e){
                e.preventDefault();
                let formDate = new FormData($('#addServiceForm')[0]);
                $.ajax({
                    type: "post",
                    url: "service",
                    data: formDate,
                    contentType: false,
                    processData: false,
                    beforeSend:function (){
                        $(document).find('span.error-text').text('');
                    },
                    success: function (response) {
                        if (response.status == 0){
                            $('#addService').modal('show')
                            $.each(response.error, function (prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                            });
                        }else {
                            $('#addServiceForm')[0].reset();
                            $('#addService').modal('hide');
                            $('#success_alert').html('<strong>Success! </strong>'+response.message)
                            $('#success_alert').css('display', 'block')
                            setTimeout(function () {
                                $('#success_alert').css('display', 'none')
                            }, 5000)
                            fetchServices();
                        }
                    },
                    error: function (error){
                        $('#addService').modal('show')
                        $('#warning_alert').html('<strong>Warning! </strong>'+error.message)
                        $('#warning_alert').css('display', 'block')
                        setTimeout(function () {
                            $('#warning_alert').css('display', 'none')
                        }, 5000)
                    }
                });
            });
        });
    </script>
@endsection
