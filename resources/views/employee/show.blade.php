@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .table#table1 th {
            width: 40%;
        }

        .table#table2 th {
            width: 40%;
        }

        .btn#edit-data {
            padding: 5px 20px;
        }

        @media (max-width: 600px) {
            .btn#edit-data {
                margin-top: 10px;
                padding: 5px 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endpush
@section('title', 'Detail Employee')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Employee</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
        <div class="col-lg-11 mx-auto">
            <div class="card p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-md-6">
                                @if ($data->photo_path)
                                    <img class="img-fluid rounded-circle"
                                        src="{{ asset('uploads/profile_images/' . $data->photo_path) }}" alt="Gambar Card"
                                        style="width: 70px; height: 70px;">
                                @else
                                    <img class="img-fluid rounded-circle"
                                        src="{{ asset('style/dist/assets/images/users/ic_globe-3.png') }}" alt="Gambar Card"
                                        style="width: 70px; height: 70px;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p style="font-size: 13px; font-weight: bold">{{ $data->name }}</p>
                            <p style="font-size: 13px; font-weight: bold">{{ $data->organization }}</p>
                            <p style="font-size: 13px; font-weight: bold">{{ $data->department }} -
                                {{ $data->level }}</p>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info"
                                role="tab" aria-controls="basic-info" aria-expanded="true">Basic Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="log-tab" data-toggle="tab" href="#log" role="tab"
                                aria-controls="log">Attendance log</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab"
                                aria-controls="setting">Setting Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="insight-tab" data-toggle="tab" href="#insight" role="tab"
                                aria-controls="insight">Insight</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        {{-- Personal Data --}}
                        <div role="tabpanel" class="tab-pane fade in active show" id="basic-info"
                            aria-labelledby="basic-info-tab">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <p style="font-weight: bold; margin-bottom: 0.3rem;">Personal data</p>
                                    @if ($data->organization_id == 10)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                                                {{ $data->is_updated == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Has Update
                                            </label>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" style="line-height: 1" id="table1">
                                            <tr>
                                                <th>Nama Lengkap</th>
                                                <td>{{ $data->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Handphone</th>
                                                <td>{{ $data->mobile_phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $data->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tempat Lahir</th>
                                                <td>{{ $data->birth_place }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Lahir</th>
                                                <td>{{ $data->birth_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td>{{ $data->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Perkawinan</th>
                                                <td>{{ $data->marital_status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status PKTP </th>
                                                <td>{{ $data->PKTP_status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Agama</th>
                                                <td>{{ $data->religion }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @can('edit-employee', Auth::user())
                                        <button type="button" class="btn btn-sm waves-effect"
                                            style="background-color: #47708F; color:white" data-toggle="modal"
                                            data-target="#modal-edit-data" id="edit-data">Edit</button>
                                    @endcan
                                </div>
                            </div>
                            <hr>
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Identity & address</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" style="line-height: 1" id="table2">
                                            <tr>
                                                <th>ID type</th>
                                                <td>KTP</td>
                                            </tr>
                                            <tr>
                                                <th>ID number</th>
                                                <td>{{ $data->citizen_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Citizen ID address</th>
                                                <td>{{ $data->citizen_id_address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Residential address</th>
                                                <td>{{ $data->resindtial_address }}</td>
                                            </tr>

                                        </table>
                                    </div>

                                </div>

                                <hr>
                            </div>

                            <hr>
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Emengency Info</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" style="line-height: 1" id="table2">
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $data->emergency_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $data->emergency_number }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                                <hr>
                            </div>
                        </div>
                        {{-- Attendance Log --}}
                        <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <p style="font-weight: bold; margin-bottom: 0rem">{{ $data->name }}</p>
                                    <p>{{ $data->nik }} - {{ $data->level }} - {{ $data->division }} </p>
                                </div>
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" style="line-height: 0.8rem;">
                                            <thead>
                                                <tr>
                                                    <th class="border-right" style="font-weight: normal; font-size: 12px">
                                                        <button data-toggle="modal" class="btn btn-info text-white"
                                                            data-target="#modal-tambah">Create</button>
                                                    </th>
                                                    <th class="border-right" style="font-weight: normal; font-size: 12px">
                                                        <button data-toggle="modal" class="btn btn-info text-white"
                                                            data-target="#modal-timeoff">Time off</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 g-2 g-md-4">
                                <div class="col-6 col-md-2">
                                    <div class="input-group">
                                        <input type="month" class="form-control" id="month_filter"
                                            style="height: 30px">
                                        <input type="text" class="form-control" value="{{ $data->id }}"
                                            id="user_id" hidden>
                                        <div class="spinner-border text-primary invisible" id="loading" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <table id="detailTable" class="table table-hover dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Shift</th>
                                                <th>Schedule In</th>
                                                <th>Schedule Out</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Overtime</th>
                                                <th>Code</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-one">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- Setting account --}}
                        <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Setting</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Lokasi</td>
                                                <td>{{ $data->location }}</td>
                                                <td>
                                                    @can('edit-employee', Auth::user())
                                                        <button type="button" class="btn btn-sm"
                                                            style="background-color: #f1b53d; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); transition: all 0.2s ease-in-out; color:white; width: 50px"
                                                            data-toggle="modal" data-target="#modal-edit-lokasi">Edit</button>
                                                    @endcan
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Resign Date</td>
                                                <td>{{ $data->resign_date }}</td>
                                                <td><button type="button" class="btn btn-sm"
                                                        style="background-color: #f1b53d; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); transition: all 0.2s ease-in-out; color:white; width: 50px"
                                                        data-toggle="modal" data-target="#modal-edit-resign">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Reset Password</td>
                                                <td></td>
                                                <td>
                                                    @can('edit-employee', Auth::user())
                                                        <a type="button" class="btn btn-sm reset-btn"
                                                            href="{{ route('reset.password', $data->id) }}"
                                                            style="background-color: #f1b53d; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); transition: all 0.2s ease-in-out; color:white; width: 50px">reset</a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </form>
                        </div>
                        {{-- insight --}}
                        <div class="tab-pane fade" id="insight" role="tabpanel" aria-labelledby="insight-tab">
                                    <div class="col-lg-8 mx-auto">
                                        <div class="row">
                                            <div class="col">
                                                <label>Start Date</label>
                                                <div class="input-group">
                                                    <input type="text" required class="form-control"
                                                        placeholder="mm/dd/yyyy" data-provide="datepicker"
                                                        name="start_date" id="start_date" data-date-autoclose="true" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Untill Date</label>
                                                <div class="input-group">
                                                    <input type="text" id="end_date" required name="end_date" class="form-control"
                                                        placeholder="mm/dd/yyyy" data-provide="datepicker"
                                                        data-date-autoclose="true" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col mx-auto text-center">
                                    <button type="button" id="exportBtn" class="mt-4 btn-sm btn btn-primary">Export</button>
                                </div>
                            </div>
                            <div class="test col-8 mx-auto" id="test"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('employee.modal')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#exportBtn').on('click', function(e) {
                e.preventDefault();
                // Show loading spinner
                $('#test').html('<div class="loading text-center mt-5">Loading...</div>');

                // Get values from date inputs
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Send AJAX POST request
                    $.ajax({
                    url: '{{route('insight', $data->id)}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(res) {
                        let data = res.data;
                        $('#test').html(`
                        <table id="datatable" class="table table-bordered dt-responsive mt-4 nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Insight</th>
                                    <th>Index</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Not Absent</td>
                                    <td>${data.not_absent}</td>
                                </tr>
                                <tr>
                                    <td>Late Total</td>
                                    <td>${data.late}</td>
                                </tr>
                                <tr>
                                    <td>Cuti Tahunan</td>
                                    <td>${data.ct}</td>
                                </tr>
                                <tr>
                                    <td>Sakit Dengan Surat Dokter</td>
                                    <td>${data.sdsd}</td>
                                </tr>
                                <tr>
                                    <td>Sakit Tanpa Surat Dokter</td>
                                    <td>${data.stsd}</td>
                                </tr>
                                <tr>
                                    <td>Unpaid Leave</td>
                                    <td>${data.ul}</td>
                                </tr>
                            </tbody>
                        </table>
                    `);
                    },
                    error: function(error) {
                        $('#test').html('<div class="error">Error loading data</div>');
                        // Handle the error as needed
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function generate_table(param_object) {
                var query = "/filter_user_Abesnt?get_data=true"
                query += `&user_id={{ $data->id }}`;
                if (param_object.month_filter != "" && param_object.month_filter != null) {
                    query += `&month_filter=${param_object.month_filter}`;
                }

                $('#detailTable').DataTable({
                    processing: true,
                    serverSide: true,
                    drawCallback: function(settings) {},
                    ajax: query,
                    columns: [{
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'schedule_name',
                            name: 'schedule_name'
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
                            data: 'clock_in',
                            name: 'clock_in'
                        },
                        {
                            data: 'clock_out',
                            name: 'clock_out'
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
