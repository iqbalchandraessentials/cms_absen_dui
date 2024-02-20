@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Karyawan')

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card p-3">
                <div class="card-body">
                    <div class="row d-flex justify-content-center align-items-center" id="filter-form">
                        <div class="form-group mr-3">
                            <label>filter : </label>
                        </div>
                        <div class="form-group">
                            <select name="active" class="form-control" id="active">
                                <option value="9" selected>Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <select name="department" class="form-control" id="department">
                                <option value="0" selected>Select Department</option>
                                @foreach ($department as $x)
                                    <option value="{{$x->name}}">{{$x->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <select name="division" class="form-control" id="division">
                                <option value="0" selected>Select Division</option>
                                @foreach ($division as $x)
                                    <option value="{{$x->name}}">{{$x->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <button class="btn btn-sm btn-primary" id="filter-button">search</button>
                        </div>

                    </div>
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Employee</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('view-employee', Auth::user())
                                <a href="{{ route('export.karyawan') }}" class="button" style="color: #fff; font-weight:500; border:none;">Export</a>
                            @endcan
                            @can('create-employee', Auth::user())
                                <button type="button" class="button" style="color: #fff; font-weight:500; border:none;" data-toggle="modal" data-target="#importKaryawan">
                                    Import
                                </button>
                                <a href="{{ route('employee.create') }}" class="button" style="color: #fff; font-weight:500">Create</a>
                            @endcan
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="table-one">
                                <table id="AbsenTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size: 13px">
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Date join</th>
                                            <th>End join</th>
                                            <th>Position</th>
                                            <th>Level</th>
                                            <th>Grade</th>
                                            <th>Golongan</th>
                                            <th>Department</th>
                                            <th>Division</th>
                                            <th>Unit Business</th>
                                            <th>Location</th>
                                            <th>Rekening</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 12px">
                                    </tbody>
                                </table>
                            </div>
                                <div class="table-responsive text-center d-none" id="second-table">
                                    <table id="datatable-filter" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size: 13px">
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Date join</th>
                                            <th>End join</th>
                                            <th>Position</th>
                                            <th>Level</th>
                                            <th>Grade</th>
                                            <th>Golongan</th>
                                            <th>Department</th>
                                            <th>Division</th>
                                            <th>Unit Business</th>
                                            <th>Location</th>
                                            <th>Rekening</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 12px">
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
    @include('employee.modal.export')
    @include('employee.modal.import')
@endsection


@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#AbsenTable').DataTable({
                processing: true,
                serverSide: true,
                drawCallback: function(settings) {
                    $('#AbsenTable').on('click', 'tbody > tr >  td', function(e) {
                        var tr = $(this).parent();
                        var describe = tr.find('.id_row').text();
                        location.href = "{{ URL::to('/detail_employee/') }}" + '/' +
                                describe;
                    });
                },
                ajax: '{!! route('list_employees') !!}',
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'NAME',
                        name: 'NAME'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'join_date',
                        name: 'join_date'
                    },
                    {
                        data: 'resign_date',
                        name: 'resign_date'
                    },
                    {
                        data: 'job_position',
                        name: 'job_position'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'golongan',
                        name: 'golongan'
                    },
                    {
                        data: 'departments',
                        name: 'departments'
                    },
                    {
                        data: 'division',
                        name: 'division'
                    },
                    {
                        data: 'organization',
                        name: 'organization'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'rekening',
                        name: 'rekening'
                    },
                ]
            });
        });
    </script>

<script>

    var dataTable = null; // Declare a variable to hold the DataTable instance

    function filter(tipewo, status) {
        $("#table-one").hide();
        if (dataTable !== null) {
                dataTable.destroy(); // Destroy the existing DataTable instance
            }
            dataTable = $('#datatable-filter').DataTable({
            processing: true,
                serverSide: true,
                drawCallback: function(settings) {
                    $('#datatable-filter').on('click', 'tbody > tr >  td', function(e) {
                        var tr = $(this).parent();
                        var describe = tr.find('.id_row').text();
                        location.href = "{{ URL::to('/detail_employee/') }}" + '/' +
                                describe;
                    });
                },
            ajax: "{{URL::to('filter_employees')}}" + '/' + $("#active").val() + '/' + $("#department").val() + '/' + $("#division").val(),
            columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'NAME',
                        name: 'NAME'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'join_date',
                        name: 'join_date'
                    },
                    {
                        data: 'resign_date',
                        name: 'resign_date'
                    },
                    {
                        data: 'job_position',
                        name: 'job_position'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'golongan',
                        name: 'golongan'
                    },
                    {
                        data: 'departments',
                        name: 'departments'
                    },
                    {
                        data: 'division',
                        name: 'division'
                    },
                    {
                        data: 'organization',
                        name: 'organization'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'rekening',
                        name: 'rekening'
                    },
                ]
        });
        $("#second-table").removeClass('d-none');
    }

    $('#filter-form').on('click', '#filter-button', function() {
        filter();
    });
</script>
@endpush
