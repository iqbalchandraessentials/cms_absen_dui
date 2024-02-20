@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Roster DUM')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="/roster">Roster</a></li>
                        <li class="breadcrumb-item"><a href="/roster/show-roster/{{ $data->user_id }}">Show Roster</a></li>
                        <li class="breadcrumb-item active">Update Roster</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card p-3">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <h4 class="text" style="font-weight: bold; margin:0; text-align:center ">Form Update
                                Roster
                            </h4>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('roster.update-roster', $data->id) }}" method="post">
                                @csrf

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" id="date" name="date" value="{{ $data->date }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Shift</label>
                                            {{-- <input type="text" class="form-control" id="shift" name="shift"
                                                value="{{ $data->shift }}"> --}}
                                            <select name="shift" id="shift" class="form-control">
                                                @if ($data->shift == 'SIANG')
                                                    <option selected value="SIANG">SIANG</option>
                                                    <option value="MALAM">MALAM </option>
                                                @else
                                                    <option selected value="MALAM">MALAM </option>
                                                    <option value="SIANG">SIANG</option>
                                                @endif


                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <label for="">OFF</label>
                                        <div class="form-group">
                                            <input type="radio" id="off_yes" name="off" value="1" {{ $data->off === '1' ? 'checked' : '' }}>
                                            <label for="">Yes</label><br>
                                            <input type="radio" id="off_no" name="off" value="0" {{ $data->off === '0' ? 'checked' : '' }}>
                                            <label for="">No</label><br>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">CR</label>
                                        <div class="form-group">
                                            <input type="radio" id="cr_yes" name="cr" value="1" {{ $data->cr === '1' ? 'checked' : '' }}>
                                            <label for="cr">Yes</label><br>
                                            <input type="radio" id="cr_no" name="cr" value="0" {{ $data->cr === '0' ? 'checked' : '' }}>
                                            <label for="cr">No</label><br>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">CT</label>
                                        <div class="form-group">
                                            <input type="radio" id="ct_yes" name="ct" value="1" {{ $data->ct === '1' ? 'checked' : '' }}>
                                            <label for="ct">Yes</label><br>
                                            <input type="radio" id="ct_no" name="ct" value="0" {{ $data->ct === '0' ? 'checked' : '' }}>
                                            <label for="ct">No</label><br>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Induksi</label>
                                        <div class="form-group">
                                            <input type="radio" id="induksi_yes" name="induksi" value="1" {{ $data->induksi === '1' ? 'checked' : '' }}>
                                            <label for="induksi">Yes</label><br>
                                            <input type="radio" id="induksi_no" name="induksi" value="0" {{ $data->induksi === '0' ? 'checked' : '' }}>
                                            <label for="induksi">No</label><br>

                                        </div>
                                    </div>
                                </div>

                                <div class="row  mt-4">
                                    <div class="col-md-12">

                                        <button type="submit" class="button" style="font-weight:500; border:none; background-color:#7495A9">
                                            Back
                                        </button>
                                        @can('edit-roster', Auth::user())
                                            <button type="submit" class="button" style="color: #fff; font-weight:500; border:none;">
                                                Save
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script></script>
@endpush
