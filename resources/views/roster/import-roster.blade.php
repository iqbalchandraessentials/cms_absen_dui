@extends('layouts.app')
@push('css')
    <link href="{{ asset('assets') }}/datatable/datatables.min.css" rel="stylesheet">
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
                        <li class="breadcrumb-item active">Import Roster</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card p-3">
                <div class="card-body">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">List Roster</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('create-roster', Auth::user())
                                <button type="button" class="button" style="color: #fff; font-weight:500; border:none;" data-toggle="modal" data-target="#importModal">Import</button>
                            @endcan
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="userTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Divisi</th>
                                            <th>Department</th>
                                            <th>Job Position</th>
                                            <th>Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('roster.modal.import')
@endsection
@push('js')
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                drawCallback: function(settings) {
                    $('#userTable').on('click', 'tbody > tr >  td', function(e) {
                        var tr = $(this).parent();
                        var describe = tr.find('.id_row').text();
                        location.href = "roster/show-roster/" + describe;
                    });
                },
                ajax: '{!! route('roster.list_rosters') !!}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'division',
                        name: 'division'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                ]
            });
        });
    </script>
@endpush
