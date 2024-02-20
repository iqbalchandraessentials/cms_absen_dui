@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Detail Department')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="/department">Department</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row">
                        <div class=" col-md-3 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">{{ $data->name }} -
                                jml({{ $data->user->count() }})</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('edit-businessunit', Auth::user())
                                <a  class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#modal-tambah-lokasi"> Edit </a>
                            @endcan
                        </div>
                    </div>
                </div>
                @include('layouts.modal.table')
            </div>
        </div>
    </div>
    @include('department.modal.edit')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#DataTable').DataTable();
        });
    </script>
@endpush
