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
                        <li class="breadcrumb-item"><a href="{{ route('location-vehicles.index') }}">Location Vehicle</a>
                        </li>
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
                    <div role="tabpanel" class="tab-pane fade in active show" id="detail" aria-labelledby="detail-tab">
                        <div class="col-lg-12">
                            <div class="card-body" style="margin-bottom: 8px">
                                <div class=" col-md-6 col-lg-6">
                                    <h3 class="text" style="font-weight: bold; margin:0 ">{{$data->name}}</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="col-lg-12">
                                    <table id="responsive-datatable"
                                        class="table datatable table-hover dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Merek</th>
                                                <th>Type</th>
                                                <th>Location</th>
                                                <th>Nomor Pol</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['vehicle'] as $x)
                                                <tr>
                                                    <td class="text-center"> {{ $x->merek }}</td>
                                                    <td> <a href="{{ route('pinjammobil.show', $x->id) }}">
                                                            {{ $x->type }} </a></td>
                                                    <td>{{ $x->vehicle_locations->name }}</td>
                                                    <td>{{ $x->no_polisi }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $borrowed = $x->borrow(now())->first();
                                                        @endphp

                                                        @if (isset($borrowed))
                                                            <i class='fas fa-times-circle rounded-circle mr-1'
                                                                style='color: rgb(194, 36, 36)'></i> Unavailable
                                                        @else
                                                            <i class='fas fa-check-circle rounded-circle mr-1'
                                                                style='color: rgb(36, 194, 57)'></i>Available
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
    {{-- @include('pinjammobil::vehicle.modal.edit') --}}
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
