@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Edit Absen')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Absen</a></li>
                        <li class="breadcrumb-item active">Edit Absen</li>
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
                            <form action="{{ route('report_absence.update', $data->id) }}" method="post" enctype="multipart/form-data">
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

                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" readonly name="date" value="{{$data->check_in->format('Y-m-d')}}">
                            </div>

                            <div class="form-group">
                                <label>Shift</label>
                                <select name="shift_id" required class="form-control">
                                    <option selected value="{{$data->shift_id}}"> -- {{$data->shift->name}} -- </option>
                                    @foreach ($shift as $x)
                                    <option value="{{$x->id}}">{{$x->name}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Clock In</label>
                                        <input type="time" required name="check_in" value="{{$data->check_in->format('H:i')}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Clock Out</label>
                                        <input type="time" required name="check_out" value="{{$data->check_out->format('H:i')}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Overtime Before</label>
                                        <input type="number" name="overtime_before" value="{{ (int)$data->overtime_before}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Overtime After</label>
                                        <input type="number" name="overtime_after" value="{{(int)$data->overtime_after}}"  class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Select Status</label>
                                <select name="status" required class="form-control">
                                    <option value="{{$data->status}}">--{{$data->status}}--</option>
                                    <option value="H">H (Hadir)</option>
                                    <option value="CT">CT (Cuti Tahunan)</option>
                                    <option value="CB">CB (Cuti Besar)</option>
                                    <option value="SDSD">SDSD (Sakit Dengan Surat Dokter)</option>
                                    <option value="STSD">STSD (Sakit Tanpa Surat Dokter)</option>
                                    <option value="DLK">DLK (Dinas Luar Kantor)</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="save-btn">Edit</button>
                            </form>
                            <form action="{{ route('report_absence.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger text-white" type="submit">Delete</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

