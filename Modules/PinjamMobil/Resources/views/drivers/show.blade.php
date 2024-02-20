@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Drivers')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Drivers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card p-3">
            <div class="card-body">
                <div class="row">
                    <div class=" col-md-6 col-lg-6">
                        <h3 class="text" style="font-weight: bold; margin:0 ">Drivers</h3>
                    </div>

                    <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                        <a href="/form-jadwal" class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#AddDriversModal">Add New</a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="col-lg-12">
                                <table id="responsive-datatable" class="table datatable table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x)
                                            <tr onclick="window.location='{{ route('drivers.edit', $x->id) }}';" style="cursor:pointer;">
                                                <td>{{ $x->name }}</td>
                                                <td>
                                                    @if ($x->status == '1')
                                                        Tersedia
                                                    @else
                                                        Tidak Tersedia
                                                    @endif
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
        @include('pinjammobil::drivers.modal.create')
    @endsection

    @push('js')
        <script>
            $(document).find('.datatable').DataTable();
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
