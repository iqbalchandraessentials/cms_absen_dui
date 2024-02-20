@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Schedule')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Schedule</li>
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
                            <h3 class="text" style="font-weight: bold; margin:0 ">Schedule</h3>
                        </div>

                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('edit-schedule', Auth::user())
                                <a href="{{ route('schedule.create') }}" class="button" style="color: #fff; font-weight">Create</a>
                            @endcan
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="ScheduleTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Number of employees</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $x)
                                            <tr onclick="redirect('{{ route('schedule.show', $x->id) }}')">
                                                <td>
                                                    {{ $x->name }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $x->user_schedule->count() }}
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
@endsection

@push('js')
    <script>
        //redirect row
        function redirect(url) {
            if (!$(event.target).closest('td').is('.action')) {
                window.location.href = url;
            }
        }
        $(document).ready(function() {
            $('#ScheduleTable').DataTable();
        });

        $("#check-all").click(function() {
            $(".check-item").prop('checked', $(this).prop('checked'));
        });

        // Check Items
        $(".check-item").change(function() {
            if ($(this).prop('checked') == false) {
                $("#check-all").prop('checked', false);
            }
            if ($(".check-item:checked").length == $(".check-item").length) {
                $("#check-all").prop('checked', true);
            }
        });

        // Save
        $("#save-btn").click(function() {
            var selected = [];
            $(".check-item:checked").each(function() {
                selected.push($(this).closest("tr").find("td:eq(1)").text());
            });
            console.log(selected);
            // Lakukan Save data atau tindakan lainnya dengan data yang dipilih
        });

        $(document).on('click', '#btn-Save', function() {
            Swal.fire('Berhasil', 'Data berhasil diSave!', 'success').then((result) => {
                if (result.isConfirmed) {
                    $('#modal-tambah-jadwal').modal('hide');
                }
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
