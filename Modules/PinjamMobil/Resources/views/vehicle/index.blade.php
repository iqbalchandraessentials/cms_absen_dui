@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Vehicles')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Vehicles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <div class="col-md-8 mx-auto">
            <div class="card p-3">
                <div class="card-body">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Vehicles</h3>
                        </div>

                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            <a  class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#modal-tambah-lokasi"> Create</a>
                            {{-- <a  class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#modal-tambah-driver">Driver</a> --}}
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <div class="col-lg-12">
                                    <table id="responsive-datatable"
                                        class="table datatable table-hover dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th >Merek</th>
                                            <th>Type</th>
                                            <th>Location</th>
                                            <th>Nomor Pol</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x)
                                            <tr onclick="window.location='{{ route('pinjammobil.show', $x->id) }}';" style="cursor:pointer;">
                                                <td > {{ $x->merek }} {{ $x->active == 1 ? '❌' : '' }}</td></td>
                                                <td>  {{ $x->type }} </td>
                                                <td>{{ $x->vehicle_locations->name }}</td>
                                                <td>{{ $x->no_polisi }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $borrowed = $x->borrow(now())->first();
                                                    @endphp
                                                    @if ($borrowed && in_array($borrowed->status, [2, 4]))
                                                        <i class='fas fa-times-circle rounded-circle mr-1' style='color: rgb(194, 36, 36)'></i> Unavailable
                                                    @else
                                                        <i class='fas fa-check-circle rounded-circle mr-1' style='color: rgb(36, 194, 57)'></i> Available
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
    @include('pinjammobil::vehicle.modal.create')
@endsection

@push('js')
    <script>
        $(document).find('.datatable').DataTable();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
