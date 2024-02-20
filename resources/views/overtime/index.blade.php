@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Overtime')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                            <h3 class="text" style="font-weight: bold; margin:0 ">Overtime </h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            <button type="button" class="btn btn-sm button" style="color: #fff; font-weight:500; border:none;"
                            data-toggle="modal" data-target="#exportExcel">
                                Export
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 mb-2 g-2 g-md-4">
                        <div class="col-6 col-md-2">
                            <div class="input-group">
                                <input type="month" class="form-control" name="month_filter" id="month_filter" style="height: 30px">
                                <button style="display: none" class="btn btn-sm btn-danger" id="clear-filter" style="border-radius: 0 !important;">X</button>
                            </div>
                        </div>
                        <div class="spinner-border text-primary invisible" id="loading" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="detailTable" class="table table-striped table-hover"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%; font-size : 11px;">
                                    <thead>
                                        <tr>
                                            <th>Filling Date</th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Organization</th>
                                            <th>Selected Date</th>
                                            <th>Duration Before</th>
                                            <th>Duration After</th>
                                            <th>Status</th>
                                            <th> Approve date </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-one">
                                    </tbody>
                                </table>
                            </div>
                            {{--  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{route('export.overtime')}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Export Excel</h5>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy"
                                        data-provide="datepicker" required name="start_date" data-date-autoclose="true" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label>Untill Date</label>
                                <div class="input-group">
                                    <input type="text" required name="end_date" class="form-control" placeholder="mm/dd/yyyy"
                                        data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>


    @endsection
    @push('js')
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function generate_table(param_object) {
                var query = "/filter_req_overtime?get_data=true"

                if (param_object.month_filter != "" && param_object.month_filter != null) {
                    query += `&month_filter=${param_object.month_filter}`;
                }
                $('#detailTable').DataTable({
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
                            data: 'overtime_duration_before',
                            name: 'overtime_duration_before'
                        },
                        {
                            data: 'overtime_duration_after',
                            name: 'overtime_duration_after'
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
                date: "",
            }

            $('#month_filter').on('change', function() {
                var selectedMonthYear = $(this).val();
                param_object = {
                    month_filter: selectedMonthYear,
                }
                generate_table(param_object);
                $('#clear-filter').show();
            });

            $('#clear-filter').on('click', function() {
                param_object = {
                    month_filter: "",
                }
                generate_table(param_object);

                $('#month_filter').val("")
                $('#clear-filter').hide();
            })

            generate_table(param_object);

        });
    </script>

    @endpush
