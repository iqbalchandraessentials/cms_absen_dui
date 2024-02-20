@extends('layouts.app')
@push('css')
@endpush
@section('title', 'Dashboard')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')



    <div class="row">
        <div class="col-12">
            <p>Hallo</p>
        </div>
    </div>

@endsection
@push('js')
@endpush
