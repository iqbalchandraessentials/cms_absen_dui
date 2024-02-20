@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Time off')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Time off</li>
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
                            <h3 class="text" style="font-weight: bold; margin:0 ">Time-Off</h3>
                        </div>
                        <div class=" col-md-9 col-lg-6" style="text-align: right">
                            <a class="btn btn-sm button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#exportExcel">Export</a>
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
                                <table id="timeoffTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Organization</th>
                                            <th>Filling Date</th>
                                            <th>Jenis Cuti</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Aprrove Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
    @include('time_off.modal.export')
@endsection
@push('js')
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function generate_table(param_object) {
                var query = "/filter_req_timeoff?get_data=true"

                if (param_object.month_filter != "" && param_object.month_filter != null) {
                    query += `&month_filter=${param_object.month_filter}`;
                }
                $('#timeoffTable').DataTable({
                    processing: true,
                    serverSide: true,
                    drawCallback: function(settings) {
                        $('#timeoffTable').on('click', 'tbody > tr >  td', function(e) {
                            var tr = $(this).parent();
                            var describe = tr.find('.id_row').text();
                            location.href = "{{ URL::to('time_off') }}" + '/' +
                                    describe;
                        });
                    },
                    ajax: query,
                    columns: [{
                            data: 'nik',
                            name: 'user.nik'
                        },
                        {
                            data: 'name',
                            name: 'user.name',
                        },
                        {
                            data: 'organization',
                            name: 'organization.name',
                            searchable: false,
                            orderable: false

                        },
                        {
                            data: 'created_date',
                            name: 'created_date'
                        },
                        {
                            data: 'time_off',
                            name: 'timeoff.name'
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'approve_date',
                            name: 'approve_date',
                            searchable: false,
                            orderable: false
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
