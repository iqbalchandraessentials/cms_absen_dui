@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Edit Timeoff')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a onclick="history.back()">Timeoff</a></li>
                        <li class="breadcrumb-item active">Edit Timeoff</li>
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
                            <form action="{{ route('setting_time_off.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input  name="name" type="text" class="form-control" value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input  name="code" type="text" class="form-control" value="{{$data->code}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Duration</label>
                                        <input type="number" name="duration" class="form-control" value="{{ $data->duration }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <select id="attachment_mandatory" name="attachment_mandatory" class="form-control">
                                            <option value="{{$data->attachment_mandatory}}"> --- {{ $data->attachment_mandatory == 1 ? 'True' : 'False' }}  --- </option>
                                            <option value="0">False</option>
                                            <option value="1">True</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select id="attachment_mandatory" name="active" class="form-control">
                                            <option value="{{$data->active}}"> --- {{ $data->active == 1 ? 'True' : 'False' }}  --- </option>
                                            <option value="0">False</option>
                                            <option value="1">True</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

