@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
            float: right;
        }

        .header-inline {
            display: inline-block;
        }

        @media (max-width: 600px) {
            .dropdown {
                float: left;
            }
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@section('title', 'Absence')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Absence</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-warning">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Absence</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            <button type="button" class="button" style="color: #fff; font-weight:500; border:none;"
                                data-toggle="modal" data-target="#exportExcel">
                                Export
                            </button>
                            <button type="button" class="button" style="color: #fff; font-weight:500; border:none;"
                                data-toggle="modal" data-target="#modal-tambah">
                                Create
                            </button>
                        </div>
                    </div>
                    <div class="row
                                mt-4">
                        <div class="col-lg-12">
                            <div class="card border shadow-none" style="border-color: #495057; padding-bottom:0">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="mt-1" id="selected-date"
                                                style="font-weight: bold; padding-top: 0; margin-bottom:0">
                                                Today, {{ $today }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-borderless"
                                                    style="line-height: 0.8rem; color: #495057;">
                                                    <thead>
                                                        <tr>

                                                            <th class="border-right"
                                                                style="font-weight: normal; font-size: 12px">
                                                                Employees</th>
                                                            <th class="border-right"
                                                                style="font-weight: normal; font-size: 12px">
                                                                Absent</th>
                                                            <th class="border-right"
                                                                style="font-weight: normal; font-size: 12px">
                                                                Time off</th>
                                                            <th style="font-weight: normal; font-size: 12px">No check in
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-right" id="number_employee"
                                                                style="font-weight: bold; font-size: 23px; color:#495057">
                                                            </td>
                                                            <td class="border-right" id="absent"
                                                                style="font-weight: bold; font-size: 23px; color:#3db9dc;">
                                                            </td>
                                                            <td class="border-right" id="timeoff"
                                                                style="font-weight: bold; font-size: 23px; color:#3db9dc;">
                                                            </td>
                                                            <td id="no_check_in"
                                                                style="font-weight: bold; font-size: 23px; color:#3db9dc;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-0 g-2 g-md-4">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="month_filter" id="month_filter"
                                    placeholder="mm/dd/yyyy" data-provide="datepicker" autocomplete="off"
                                    data-date-autoclose="true">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                </div>
                                <input type="text" value="{{ Auth::user()->organization_id }}" id="organization_id"
                                    name="organization_id" hidden>
                                <div class="spinner-border text-primary invisible" id="loading" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="detailTable" class="table detailTable table-striped table-hover"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%; font-size: 11px">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>NIK</th>
                                            <th>Organization</th>
                                            <th>Shift</th>
                                            <th>Schedule In</th>
                                            <th>Schedule Out</th>
                                            <th>Clock in</th>
                                            <th>Clock out</th>
                                            <th>Overtime</th>
                                            <th>Code</th>
                                            <th class="border-left">Action</th>
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

        @include('absence.modal')

    @endsection
    @push('js')
        <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                function generate_table(param_object) {
                    var query = "/filter_Abesnt?get_data=true"

                    if (param_object.month_filter != "" && param_object.month_filter != null) {
                        query += `&month_filter=${param_object.month_filter}`;
                    }

                    $('#detailTable').DataTable({
                        processing: true,
                        serverSide: true,
                        drawCallback: function(settings) {},
                        ajax: query,
                        columns: [{
                                data: 'name',
                                name: 'name',
                            },
                            {
                                data: 'nik',
                                name: 'nik'
                            },
                            {
                                data: 'organization',
                                name: 'organization',
                            },
                            {
                                data: 'shift_name',
                                name: 'shift_name'
                            },
                            {
                                data: 'schedule_in',
                                name: 'schedule_in'
                            },
                            {
                                data: 'schedule_out',
                                name: 'schedule_out'
                            },
                            {
                                data: 'check_in',
                                name: 'check_in'
                            },
                            {
                                data: 'check_out',
                                name: 'check_out'
                            },
                            {
                                data: 'overtime',
                                name: 'overtime'
                            },
                            {
                                data: 'status',
                                name: 'status',
                            },
                            {
                                data: 'edit',
                                name: 'edit'
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


        <script>
            $(document).ready(function() {
                var currentDate = moment().format("YYYY/MM/DD");
                absen(currentDate);
            });

            $(document).on('change', '#month_filter', function() {
                var currentDate = $("#month_filter").val();
                absen(currentDate);
            });

            function absen(date) {
                $('#loading').removeClass('invisible');
                $.ajax({
                    url: '/absensi',
                    type: 'get',
                    dataType: "json",
                    data: {
                        date: date,
                        dept_id: $("#organization_id").val()
                    },
                    success: function(res) {
                        let data = res.data;
                        $('#selected-date').html(data.today);
                        $('#absent').html(data.absent);
                        $('#timeoff').html(data.timeoff);
                        $('#number_employee').html(data.number_employee);
                        $('#no_check_in').html(data.no_check_in);
                        $('#loading').addClass('invisible')
                    },
                });
            };
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    @endpush
