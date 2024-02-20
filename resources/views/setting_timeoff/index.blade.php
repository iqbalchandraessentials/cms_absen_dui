@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@section('title', 'Setting Time-off')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Time Off</li>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class=" col-md-3 col-lg-6">
                            <h4>Import Adjustment Cuti {{ $now->year }}</h4>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('edit-timeoff', Auth::user())
                            <button type="button" class="btn btn-sm button" style="color: #fff; font-weight:500; border:none;"
                                    data-toggle="modal" data-target="#mass_leave">
                                Import
                            </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class=" col-md-6 col-lg-6">
                            <h4>Setting Daftar Pengajuan Cuti</h4>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('create-timeoff', Auth::user())
                                <a  class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#timeoffModal"> Create</a>
                            @endcan
                        </div>
                    </div>
                    <table id="" class="table detailTable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Active</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Attachment Mandatory</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timeoff as $x)
                                <tr>
                                    <td> {{ $x->active == 1 ? 'Active' : 'In Active' }} </td>
                                    <td> {{ $x->code }} </td>
                                    <td> {{ $x->name }} </td>
                                    <td> {{ $x->duration }} </td>
                                    <td> {{ $x->attachment_mandatory == 1 ? 'True' : 'False' }} </td>
                                    <td> @can('edit-timeoff', Auth::user())
                                            <a href=" {{ route('setting_time_off.edit', $x->id) }} ">edit</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class=" col-md-6 col-lg-6">
                            <h4>Jumlah Cuti Tahunan Karyawan 2023</h4>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            <a href="{{ route('kuota.export') }}" class="button" style="color: #fff; font-weight:500">Export Report</a>
                            @can('create-timeoff', Auth::user())
                                <a class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#DvisionModal"> Create</a>
                            @endcan
                        </div>

                    </div>
                    <table id="timeoffTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Organization</th>
                                <th>Cuti</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mass_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action=" {{ route('mass.leave')}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Adjustment Cuti</h5>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <label>Pilih file excel</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </div>
                    </div>
            </form>
        </div>
    </div>


    @include('setting_timeoff.modal.addcuti_karyawan')
    @include('setting_timeoff.modal.addtimeoff')
@endsection

@push('js')
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).find('.detailTable').DataTable();
            $('#timeoffTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('list_timeoff') !!}',
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pt',
                        name: 'pt'
                    },
                    {
                        data: 'kuota_cuti',
                        name: 'kuota_cuti'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
