@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Load DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endpush
@section('title', 'Vehicle')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pinjammobil.create') }}">Vehicle</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="card p-2">
                <div class="card-body">
                    {{-- tab --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-expanded="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="shift-tab" data-toggle="tab" href="#shift" role="tab" aria-controls="shift">History Borrow</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        {{-- tab detail jadwal --}}
                        <div role="tabpanel" class="tab-pane fade in active show" id="detail" aria-labelledby="detail-tab">
                            <div class="row mb-3">
                                <div class=" col-md-6 col-lg-6">
                                    <a style="cursor: pointer;" data-toggle="modal" data-target="#modal-tambah-lokasi">
                                        <h3><span class="badge {{ $data['active'] == 0 ? 'badge-success' : 'badge-danger' }}">{{ $data['active'] == 0 ? 'Active' : 'Incative' }}</span></h3>
                                    </a>
                                </div>
                                <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Merek:</strong> {{ $data['merek'] }}</li>
                                        <li class="list-group-item"><strong>Type:</strong> {{ $data['type'] }}</li>
                                        <li class="list-group-item"><strong>Location:</strong> {{ $data['vehicle_lokasi']['lokasi'] }}</li>
                                        <li class="list-group-item"><strong>PIC:</strong> {{ $data['vehicle_pic']['pic'] }}</li>
                                        <li class="list-group-item"><strong>Nomor Pol:</strong> {{ $data['nopol'] }}</li>
                                        <li class="list-group-item"><strong>Nomor Rangka:</strong> {{ $data['nomor_rangka'] }}</li>
                                        <li class="list-group-item"><strong>Nomor Mesin:</strong> {{ $data['nomor_mesin'] }}</li>
                                        <li class="list-group-item"><strong>Pajak Berakhir:</strong> {{ $data['pajak_berakhir'] }}</li>
                                        <li class="list-group-item"><strong>STNK Berakhir:</strong> {{ $data['stnk_berakhir'] }}</li>
                                        <li class="list-group-item"><strong>Last KM:</strong> {{ $data['last_km'] }}</li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <div class="row mt-4 justify-content-center">
                                        <div class="col-12 col-md-6">
                                            <div class="text-center">
                                                <img src="{{ $data['image'] }}" class="card-img-top mx-auto w-100" alt="Vehicle Image">
                                                <div class="card-body">
                                                    <h5 class="card-title">Vehicle Details</h5>
                                                    <!-- Add other details or description about the vehicle here if needed -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Shift --}}
                        <div class="tab-pane fade" id="shift" role="tabpanel" aria-labelledby="shift-tab">
                            <div class="row mt-3">
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
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($borrow as $y)
                                                <tr onclick="window.location='{{ route('borrow-vehicles.show', $y->id) }}';" style="cursor:pointer;">
                                                    <td>{{ date('Y-m-d', strtotime($y['request_date'])) }}</td>
                                                    <td>{{ $y['vehicles']['type'] }}</td>
                                                    <td>{{ $y['users']['name'] }}</td>
                                                    <td>{{ $y['start_date'] }} </td>
                                                    <td>{{ $y['end_date'] }}</td>
                                                    <td> {{ $y['from'] }} - {{ $y['to'] }} </td>
                                                    <td>{{ $y['drivers']['name'] ?? '-' }}</td>
                                                    @php
                                                        $status = $y->status;
                                                    @endphp
                                                    @if ($status == 0)
                                                        <td> <span class="badge badge-info">Menunggu approval atasan</span></td>
                                                    @elseif($status == 1)
                                                        <td> <span class="badge badge-primary">Menunggu approval GA</span></td>
                                                    @elseif($status == 2)
                                                        <td> <span class="badge badge-info">Disetujui GA</span></td>
                                                    @elseif($status == 3)
                                                        <td> <span class="badge badge-danger">Dibatalkan</span></td>
                                                    @elseif($status == 4)
                                                        <td> <span class="badge badge-warning">Menunggu pengembalian</span></td>
                                                    @elseif($status == 5)
                                                        <td> <span class="badge badge-success">Selesai</span></td>
                                                    @else
                                                        <td> <span class="badge badge-warning">Status tidak dikenali</span></td>
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
        </div>
    </div>
    @include('pinjammobil::vehicle.modal.edit')
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
