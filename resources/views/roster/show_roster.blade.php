@extends('layouts.app')
@push('css')
    <style>
        .badge {
            padding: 5px 20px;
        }
    </style>
@endpush
@section('title', 'Detail Roster DUM')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="/roster">Roster</a></li>
                        <li class="breadcrumb-item active">Show Roster</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card p-3">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text" style="font-weight: bold">Jadwal Roster</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="month" class="form-control" name="month_filter" id="month_filter" style="height: 30px">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table" id="rosterTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Shift</th>
                                        <th>Off</th>
                                        <th>CR</th>
                                        <th>CT</th>
                                        <th>Induksi</th>
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

@endsection
@push('js')
    <script src="{{ asset('assets') }}/datatable/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function generate_table(param_object) {
                var currentUrl = window.location.href;
                var urlSegments = currentUrl.split('/');
                var id = urlSegments[urlSegments.length - 1];
                var query = "/roster/jadwal_roster/" + id + "?get_data=true";

                if (param_object.month_filter != "" && param_object.month_filter != null) {
                    query += `&month_filter=${param_object.month_filter}`;
                }
                $('#rosterTable').DataTable({
                    processing: true,
                    serverSide: true,
                    drawCallback: function(settings) {
                        $('#rosterTable').on('click', 'tbody > tr >  td', function(e) {
                            var tr = $(this).parent();
                            var describe = tr.find('.id_row').text();
                            location.href = "/roster/detail-roster/" + describe;
                        });
                    },
                    ajax: query,
                    columns: [{
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'shift',
                            name: 'shift'
                        },
                        {
                            name: 'off',
                            data: 'off',

                        },
                        {
                            data: 'cr',
                            name: 'cr',
                        },
                        {
                            data: 'ct',
                            name: 'ct'
                        },
                        {
                            data: 'induksi',
                            name: 'induksi'
                        },
                    ],
                    bDestroy: true,
                });
            }
            var param_object = {
                month_filter: "",
            }

            $('#month_filter').on('change', function() {
                var selectedMonthYear = $(this).val();
                param_object = {
                    month_filter: selectedMonthYear,
                }
                generate_table(param_object);
                $('#clear-filter').show();
            });

            $('#clear-filter').on('click', function() {
                param_object = {
                    month_filter: "",
                }
                generate_table(param_object);

                $('#month_filter').val("")
                $('#clear-filter').hide();
            })

            generate_table(param_object);
        });
    </script>
@endpush
