@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .select2-selection__rendered {
            margin: 5px;
        }

        .select2-selection__arrow {
            margin: 5px;
        }

        .select2-selection {
            min-height: 38px;
        }
    </style>
@endpush
@section('title', 'Permissions')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="/permission">Permission</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-3">
                <div class="card-header" style="background-color:white">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h5 class="text" style="font-weight: bold">Fill this form</h5>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ route('permission.store') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" id="name" name="name" placeholder="name">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>For</label>
                                                    <select name="for" class="custom-select" id="select_for" aria-label="Permission For:">
                                                        <option disabled selected>Open this select menu</option>
                                                        @foreach ($permissions as $x)
                                                            <option value="{{ $x }}">{{ $x }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                        </div>

                    </div>

                </div>
                <div class="card-footer" style="background-color:white">
                    <a class="btn btn-secondary btn-round text-white" onclick="history.back()">
                        Back</a>
                    <button type="submit" class="btn btn-primary btn-round">{{ __('Save') }}</button>
                </div>
                </form>

            </div>

        </div>
    </div>



@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#select_for').select2();
    </script>
@endpush
