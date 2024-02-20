@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Shift')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('schedule.index') }}">Schedule</a></li>
                        <li class="breadcrumb-item active">Edit Shift</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form  method="post" action="{{ route('update.shift', $data->id) }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                    class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                <div class="col-sm-8">
                                    <input name="name" type="text" class="form-control" value="{{$data->name}}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                        <div class="col-sm-8">
                                            <input name="schedule_in" type="time" class="form-control" value="{{$data->schedule_in}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                        <div class="col-sm-8">
                                            <input name="schedule_out" type="time" class="form-control" value="{{$data->schedule_out}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                        <div class="col-sm-8">
                                            <input name="break_start" type="time" class="form-control" value="{{$data->break_start}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                        <div class="col-sm-8">
                                            <input name="break_" type="time" class="form-control" value="{{$data->break_end}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                            </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
@endsection

@push('js')
@endpush
