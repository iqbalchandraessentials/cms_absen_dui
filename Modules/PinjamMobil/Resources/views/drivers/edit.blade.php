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
                        <li class="breadcrumb-item"><a href="{{ route('drivers.index') }}">Drivers</a></li>
                        <li class="breadcrumb-item active">Edit Drivers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-md-6 mx-auto">
        <div class="card p-3">
            <div class="card-body">
                <div class="row mb-0">
                    <div class="col-md-6 col-lg-6">
                        <h3 class="text" style="font-weight: bold; margin:0 ">Drivers</h3>
                        <p>Edit form</p>
                    </div>
                </div>
                <hr class="mt-0">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('drivers.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input required class="form-control" id="name" name="name" value="{{ $data->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Status</label>
                                        <select name="status" id="status" class="form-control">

                                            <option value="1"{{ $data->status == '1' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <a class="btn btn-secondary btn-round text-white mt-3" onclick="history.back()">
                                Back</a>
                            <button type="submit" class="btn btn-primary mt-3">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).find('.datatable').DataTable();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
