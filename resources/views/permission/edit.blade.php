@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h5 class="text" style="font-weight: bold">Edit Permission</h5>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ route('permission.update', $permission->id) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" id="name" name="name" value="{{ $permission->name }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>For</label>
                                                    <input type="text" name="for" class="form-control" value="{{ $permission->for }}">
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
@endpush
