@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Request Attendance')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Request Attendance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row ">
                        <div class=" col-md-3 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Request Attendance</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                        </div>
                    </div>

                    <div class="row mt-3 mb-2 g-2 g-md-4">
                        <div class="col-6 col-md-2">
                            <div class="input-group">
                                <input type="month" class="form-control" name="month_filter" id="month_filter" style="height: 30px">
                            </div>
                        </div>
                        <div class="spinner-border text-primary invisible" id="loading" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="reqAttendenceTable" class="table table-striped table-hover" style="border-collapse: collapse; font-size: 13px; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Requested date</th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Organization</th>
                                            <th>Selected date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Status</th>
                                            <th>Approve date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-one" style="font-size: 12px">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function generate_table(param_object) {
                var query = "/filter_request_attendence?get_data=true"

                if (param_object.month_filter != "" && param_object.month_filter != null) {
                    query += `&month_filter=${param_object.month_filter}`;
                }
                $('#reqAttendenceTable').DataTable({
                    processing: true,
                    serverSide: true,
                    drawCallback: function(settings) {},
                    ajax: query,
                    columns: [{
                            data: 'request_date',
                            name: 'request_date'
                        },
                        {
                            data: 'nik',
                            name: 'user.nik'
                        },
                        {
                            data: 'name',
                            name: 'user.name',

                        },
                        {
                            data: 'organization',
                            name: 'organization',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'selected_date',
                            name: 'selected_date'
                        },
                        {
                            data: 'clock_in',
                            name: 'clock_in'
                        },
                        {
                            data: 'clock_out',
                            name: 'clock_out'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'approve_date',
                            name: 'approve_date'
                        },
                    ],
                    bDestroy: true,
                });
            }
            var param_object = {
                month_filter: "",
            }

            $('#month_filter').on('change', function() {
                var selectedMonthYear = $(this).val();
                // var parts = selectedMonthYear.split("-");
                // var selectedDate = parts[0] + '-' + parts[1] + '-01';
                param_object = {
                    month_filter: selectedMonthYear,
                }
                generate_table(param_object);
            });

            generate_table(param_object);

        });
    </script>
@endpush
