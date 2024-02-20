@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Edit Cuti Tahunan')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a onclick="history.back()">Cuti Tahunan</a></li>
                        <li class="breadcrumb-item active">Edit Cuti Tahunan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-3">
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="{{ route('cuti-tahunan.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input  disabled type="text" class="form-control" value="{{$data->user->name}}">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input  disabled type="text" class="form-control" value="{{$data->user->nik}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Kuota Tahunan</label>
                                        <input type="number" name="kuota_cuti" class="form-control" value="{{$data->kuota_cuti}}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Sisa Cuti</label>
                                        <input type="number" name="sisa_cuti" class="form-control"value="{{$data->sisa_cuti}}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Adjustment</label>
                                        <input type="number" name="adjustment" class="form-control"value="{{$data->adjustment}}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="save-btn">Edit</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

