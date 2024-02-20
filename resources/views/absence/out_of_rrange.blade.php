@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Out Of Range')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Out Of Range</li>
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
                            <h3 class="text" style="font-weight: bold; margin:0 ">Out Of Range</h3>
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
                                    style="border-collapse: collapse; font-size: 11px; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Organization</th>
                                            <th>Location</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Approve Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-one">
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
                var query = "/filter_out_of_range?get_data=true"

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
                            name: 'user.organization.name',
                        },
                        {
                            data: 'location',
                            name: 'user.location.name',
                        },
                        {
                            data: 'type',
                            name: 'type',
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
                var parts = selectedMonthYear.split("-");
                var selectedDate = parts[0] + '-' + parts[1] + '-01';

                param_object = {
                    month_filter: selectedDate,
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
