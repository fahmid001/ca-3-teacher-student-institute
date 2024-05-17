<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noipunno - Application</title> <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400&family=Roboto:wght@100;400&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/noipunno/css/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugin/datatables/dataTables.bootstrap4.css') }}">
    

    <script src="{{ asset('plugin/sweetalert/sweetalert.js') }}"></script>
    <link href="{{ asset('plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap JS and jQuery (required for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables -->
    <script src="{{ asset('plugin/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.js') }}"></script>

    <style>
        .sweet-alert h2 {
            font-size: 16px !important;
        }
        .sweet-alert p {
            font-size: 14px !important;
        }
        .sa-button-container .confirm{
            padding: 5px 10px !important;
            font-size: 14px !important;
        }
        .sa-button-container .cancel{
            padding: 5px 10px !important;
            font-size: 14px !important;
        }
        
        .select2-container .select2-selection--single {
            height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 36px;
            padding-left: 12px;
        }
        .select2-container--default .select2-results__option--selected{
            background: none;
            color: #000;
            font-size: 16px;
        }
        .select2-results__option--selectable{
            background: none;
            color: #000;
            font-size: 16px;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 12px;
        }
    </style>
</head>

<body>
    @include('frontend.layouts.nav-noipunno')

    <div class="content">
        @yield('content')
    </div>

    @include('frontend.layouts.noipunno-footer')
    @yield('custom-js')


    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#delete', function() {
                var actionTo = $(this).attr('data-route');
                var token = $(this).attr('data-token');
                var id = $(this).attr('data-id');

                swal({
                        title: "আপনি কি তথ্যটি মুছে ফেলতে চান?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "না",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "হ্যাঁ",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: actionTo,
                                type: 'post',
                                data: {
                                    id: id,
                                    _token: token
                                },
                                success: function(data) {
                                    swal({
                                            title: "Deleted!",
                                            text: "তথ্যটি মুছে ফেলা হয়েছে।",
                                            type: "success"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                location.reload();
                                            }
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", "বাতিল করা হয়েছে।", "error");
                        }
                    });
                return false;
            });
        });

        $(function(){
            $('#n_dataTable').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    // "ordering": false,
                    "info": true,
                    "autoWidth": true,

                });

                $('.select2').select2();
        });

    </script>
</body>

</html>
