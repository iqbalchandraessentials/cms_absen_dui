@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Detail Overtime')

@section('content')
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row ">
                        <div class=" col-md-3 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 "> Overtime
                                <a class="btn btn-sm btn-dark dropdown-toggle px-2" href="#" role="button"
                                            data-toggle="dropdown" aria-expanded="false">
                                    @if ($data->approve == 0)
                                        <i class="fas fa-exclamation-circle rounded-circle mr-1" style="color: #e18916"></i>
                                        Pending
                                    @elseif ($data->approve == 1)
                                        <i class="fas fa-check-circle rounded-circle mr-1"
                                            style="color: rgb(36, 194, 57)"></i>
                                        Approved
                                    @elseif ($data->approve == 2)
                                    <i class="fas fa-times-circle rounded-circle mr-1"
                                        style="color: rgb(194, 36, 36)"></i>
                                    Rejected
                                    @elseif ($data->approve == 3)
                                    <i class="fas fa-times-circle rounded-circle mr-1"
                                        style="color: rgb(18, 18, 18)"></i>
                                    Cancel
                                    @endif
                                </a>
                                @if ($data->approve == 0)
                                <div class="dropdown-menu" x-placement="bottom-start"
                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(169px, 54px, 0px);">
                                    <p class="dropdown-item">
                                        <a type="button" class="btn btn-success btn-round btn-sm text-sm "
                                        data-toggle="modal" data-target="#modal-edit-lokasi">Edit</a>
                                </div>
                                @endif
                            </h3>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td> {{ $data->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>{{ $data->user->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td>Division</td>
                                        <td>{{ $data->user->division->name }}</td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td>Overtime Date</td>
                                        <td> {{ date('d-M-Y', strtotime($data->selected_date)) }} </td>
                                    </tr>
                                    <tr>
                                        <td>Overtime Before</td>
                                        <td> {{ (int)$data->overtime_duration_before }} </td>
                                    </tr>
                                    <tr>
                                        <td>Overtime After</td>
                                        <td> {{ (int)$data->overtime_duration_after }} </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td> {!! $data->description !!} </td>
                                    </tr>
                                    <tr>
                                        <td>Approve By</td>
                                        <td> {{ $data->approveby->name }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <b>Attachment :</b>
                        <div class="row mt-5 mb-5">

                            @forelse ($data->attachment as $x)
                                <div class="col">
                                    <a href="{{ asset('uploads/timeoff/' . $x->upload_file) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('uploads/timeoff/' . $x->upload_file) }}" class="img-fluid w-80"
                                            alt="" srcset="">
                                    </a>
                                </div>
                            @empty
                                <div class=" col text-center">
                                    <b> no attachment </b>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal edit lokasi --}}
    <div class="modal fade bs-example-modal-center" id="modal-edit-lokasi" tabindex="-1" role="dialog"
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.overtime', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <select name="approve" id="">
                                <option value="1">Approve</option>
                                <option value="2">Reject</option>
                                <option value="3">Cancel</option>
                            </select>
                        </div>
                        <input type="datetime" name="date_time" value="{{$data->now}}" id="" hidden>
                        <div class="col-md-3">
                            <button type="submit" class="btn button"
                                style="width: 95px; height: 35px; text-align:center; padding: 5px; color:white;">Save</button>
                        </div>
                </form>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="table-location" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

@endsection
@push('js')
@endpush
