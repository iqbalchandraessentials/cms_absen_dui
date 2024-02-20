@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Borrow Vehicles')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Borrow Vehicles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="col-md-12 mx-auto">
        <div class="card p-3">
            <div class="card-body">
                <div class="row">
                    <div class=" col-md-6 col-lg-6">
                        <h3 class="text" style="font-weight: bold; margin:0 ">Borrow Vehicles</h3>
                    </div>

                    <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                        <button type="button" class="btn btn-sm button" style="color: #fff; font-weight:500; border:none;" data-toggle="modal" data-target="#exportExcel">
                            Export
                        </button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="col-lg-12">
                                <table id="responsive-datatable" class="table datatable table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Request Date</th>
                                            <th>Vehicles</th>
                                            <th>Borrower</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Trip</th>
                                            <th>Driver</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $y)
                                            <tr onclick="window.location='{{ route('borrow-vehicles.show', $y->id) }}';" style="cursor:pointer;">
                                                <td>{{ date('Y-m-d', strtotime($y['request_date'])) }}</td>
                                                <td>{{ $y['vehicles']['type'] }}</td>
                                                <td>{{ $y['users']['name'] }}</td>
                                                <td>{{ $y['start_date'] }} </td>
                                                <td>{{ $y['end_date'] }}</td>
                                                <td>{{ $y['from'] }} - {{ $y['to'] }}</td>
                                                <td>{{ $y['drivers']['name'] ?? '-' }}</td>
                                                @php
                                                    $status = $y['ga_approve']['status'] ?? '-';
                                                    $status_borrow = $y->status;
                                                @endphp
                                                @if ($status == 1)
                                                    <td> <span class="badge w-100 badge-success">Disetujui</span></td>
                                                @elseif($status == 2)
                                                    <td> <span class="badge w-100 badge-danger">Ditolak</span></td>
                                                @elseif($status == 3)
                                                    <td> <span class="badge w-100 badge-warning">Dibatalkan</span></td>
                                                @elseif($status_borrow == 1)
                                                    <td> <span class="badge w-100 badge-info">Menunggu approval GA</span></td>
                                                @else
                                                    <td> <span class="badge w-100 badge-secondary"> Menunggu approval atasan</span></td>
                                                @endif
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="{{ route('export.borrow_vehicles') }}" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" name="start_date" data-date-autoclose="true" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Untill Date</label>
                                    <div class="input-group">
                                        <input type="text" name="end_date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
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
        <script>
            $(document).find('.datatable').DataTable();
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
