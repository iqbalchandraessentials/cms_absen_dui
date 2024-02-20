@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Location')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Location</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card p-3">
                <div class="card-body">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Location</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('create-location', Auth::user())
                                <button type="button" class="button" style="color: #fff; font-weight:500; border:none;" data-toggle="modal" data-target="#importLocation">
                                    Import
                                </button>
                                <a class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#modal-tambah-lokasi"> Create</a>
                            @endcan
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="LocationTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Coordinate</th>
                                            <th>Radius(m)</th>
                                            <th class="text-center">Number of employees</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x)
                                            <tr onclick="redirect('{{ route('location.show', $x->id) }}')">
                                                <td>{{ $x->name }}
                                                </td>
                                                <td>{{ $x->longitude }} , {{ $x->latitude }}</td>
                                                <td>{{ $x->radius }}</td>
                                                <td class="text-center">{{ $x->user->count() }}</td>
                                                <td class="text-center">
                                                    @if ($x->active == 1)
                                                        <i class="fas fa-check-circle rounded-circle mr-1" style="color: rgb(36, 194, 57)"></i>
                                                        Active
                                                    @else
                                                        <i class="fas fa-times-circle rounded-circle mr-1" style="color: rgb(194, 36, 36)"></i>
                                                        In Active
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
    @include('location.modal.create')
    @include('location.modal.import')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#LocationTable').DataTable();
        });

        function redirect(url) {
            window.location.href = url;
        }

        $(document).on('click', '#btn-Save', function() {
            Swal.fire('Berhasil', 'Data berhasil diSave!', 'success').then((result) => {
                if (result.isConfirmed) {
                    $('#modal-tambah-lokasi').modal('hide');
                }
            })
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
