@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@section('title', 'PIC')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">PIC</li>
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
                            <h3 class="text" style="font-weight: bold; margin:0 ">PIC</h3>
                        </div>

                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            <a class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#DvisionModal"> Create</a>
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
                                            <th>Name</th>
                                            <th class="text-center">Jml Kendaraan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x)
                                        <tr onclick="window.location='{{ route('pic-vehicles.show', $x->id) }}';" style="cursor:pointer;">
                                            <td>
                                                <a>
                                                    {{ $x->users->name ?? '-' }} {{ $x->active != 0 ? '❌' : '' }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $x->vehicle->count() }}</td>
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

        {{-- Modal tambah Cuti karyawan --}}
        <div class="modal fade" id="DvisionModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('pic-vehicles.store') }}" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <select id="user_id" name="user_id" data-live-search="true" required class="selectpicker form-control">
                                        <option>Select User</option>
                                        @foreach ($user as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">Create</button>
                </div>
                </form>
            </div>
        </div>
        </div>

@push('js')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush

@endsection
