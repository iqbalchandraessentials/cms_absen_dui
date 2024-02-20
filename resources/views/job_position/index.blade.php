@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Job Position')

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Job Position</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card p-3">
                <div class="card-body">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Job Position</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6" style="text-align: right; display:inline-block">
                            @can('create-jobposition', Auth::user())
                                <a class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#Modal"> Create</a>
                            @endcan
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="JobTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Number of employees</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x)
                                            <tr onclick="redirect('{{ route('job-position.show', $x->id) }}')">
                                                <td>{{ $x->name }}
                                                <td class="text-center">{{ $x->user->count() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('job_position.modal')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#JobTable').DataTable();
        });

        function redirect(url) {
            if (!$(event.target).closest('td').is('.action')) {
                window.location.href = url;
            }
        }
    </script>
@endpush
