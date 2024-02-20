@extends('layouts.app')
@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <!-- Load DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        .badge {
            padding: 0.5rem 0.5rem;
        }

        .table th,
        .table td {
            pad: 0.2rem;
        }
    </style>
@endpush
@section('title', 'Borrow Vehicle')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('borrow-vehicles.create') }}">Borrow Vehicles</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                {{-- <img src="{{ $data['vehicle']['image'] }}" class="card-img-top" alt="{{ $data['vehicle']['vehicle_type'] }}"> --}}
                                <a href="#" class="badge w-80 h-100 badge-secondary" style="text-align: center" data-toggle="modal" data-target="#modal-edit-borrow">
                                    {{ $data['vehicle']['merek'] }} - {{ $data['vehicle']['vehicle_type'] }} - {{ $data['vehicle']['vehicle_nopol'] }}
                                </a>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        @php
                                            $status = $data['status_ga'];
                                        @endphp
                                        @if ($status == 0)
                                            <span class="badge w-50 badge-info" style="float: right">Menunggu approval GA</span>
                                        @elseif($status == 1)
                                            <span class="badge w-50 badge-success" style="float: right">Disetujui</span>
                                        @elseif($status == 2)
                                            <span class="badge w-50 badge-danger" style="float: right">Ditolak</span>
                                        @elseif($status == 3)
                                            <span class="badge w-50 badge-warning" style="float: right">Dibatalkan</span>
                                        @else
                                            <span class="badge w-50 badge-secondary" style="float: right"> Menunggu approval atasan</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <strong class="mt-3">Detail :</strong>
                        <div class="row mt-0">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th style="width: 8rem">Requested by</th>
                                            <th style="width: 1rem">:</th>
                                            <td>{{ $data['user']['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <th>:</th>
                                            <td>{{ $data['user']['departement'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Position</th>
                                            <th>:</th>
                                            <td>{{ $data['user']['jabatan'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Request Date</th>
                                            <th>:</th>
                                            <td>{{ $data['request_date'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>:</th>
                                            <td>{{ $data['start_date'] }}</td>

                                        </tr>
                                        <tr>
                                            <th>End Date</th>
                                            <th>:</th>
                                            <td>{{ $data['end_date'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th style="width: 8rem">Destination</th>
                                            <th style="width: 1rem">:</th>
                                            <td>{{ $data['from'] }} --> {{ $data['to'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reason</th>
                                            <th>:</th>
                                            <td>{{ $data['reason'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cost Center</th>
                                            <th>:</th>
                                            <td>{{ $data['cost_center'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last KM</th>
                                            <th>:</th>
                                            <td>{{ $data['KM']['last_km'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Driver</th>
                                            <th>:</th>
                                            <td>{{ $data['driver']['name'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Condition :</strong>
                                <ul>
                                    @foreach (['body', 'lampu', 'ban', 'ac', 'mesin'] as $condition)
                                        <li>
                                            {{ ucfirst($condition) }}:
                                            @if (isset($data['condition'][$condition]))
                                                @if ($data['condition'][$condition] == 1)
                                                    <i class='fas fa-check-circle rounded-circle mr-1' style='color: rgb(36, 194, 57)'></i>
                                                @elseif($data['condition'][$condition] == 0)
                                                    <i class='fas fa-times-circle rounded-circle mr-1' style='color: rgb(194, 36, 36)'></i>
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </li>
                                    @endforeach
                                    <li><b>Description:</b> {{ $data['condition']['description'] }}</li>
                                </ul>

                            </div>

                            <div class="col-md-6">
                                <img src="{{ $data['vehicle']['image'] }}" class="card-img-top" alt="{{ $data['vehicle']['vehicle_type'] }}" width="20" height="300">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('pinjammobil::borrow.modal.edit')
@endsection

@push('js')
    <script>
        $(document).find('.datatable').DataTable();

        function redirect(url) {
            window.location.href = url;
        }


        // Save
        $("#save-btn").click(function() {
            var selected = [];
            $(".check-item:checked").each(function() {
                selected.push($(this).closest("tr").find("td:eq(1)").text());
            });
            console.log(selected);
            // Lakukan Save data atau tindakan lainnya dengan data yang dipilih
        });

        $(document).on('click', '#btn-Save', function() {
            Swal.fire('Berhasil', 'Data berhasil diSave!', 'success').then((result) => {
                if (result.isConfirmed) {
                    $('#modal-lokasi-karyawan').modal('hide');
                }
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
@endpush
