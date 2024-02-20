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
                        <li class="breadcrumb-item"><a href="{{ route('schedule.index') }}">Schedule</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="card p-2">
                <div class="card-body">
                    {{-- tab --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-expanded="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="shift-tab" data-toggle="tab" href="#shift" role="tab" aria-controls="shift">Shift</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="karyawan-tab" data-toggle="tab" href="#karyawan" role="tab" aria-controls="karyawan">Karyawan</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        {{-- tab detail jadwal --}}
                        <div role="tabpanel" class="tab-pane fade in active show" id="detail" aria-labelledby="detail-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nama Jadwal</th>
                                                    <th>National Holiday</th>
                                                    <th>Company Holiday</th>
                                                    <th>Special Holiday</th>
                                                    <th>Flexible</th>
                                                    <th>Include Late</th>
                                                    <th>Initial Shift</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->override_national_holiday }}</td>
                                                    <td>{{ $data->override_company_holiday }}</td>
                                                    <td>{{ $data->override_special_holiday }}</td>
                                                    <td>
                                                        @if ($data->flexible == 0)
                                                            Yes
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->include_late }}</td>
                                                    <td>{{ $data->initial_shift }}</td>
                                                    <td>
                                                        @if ($data->active == 0)
                                                            Yes
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Shift --}}
                        <div class="tab-pane fade" id="shift" role="tabpanel" aria-labelledby="shift-tab">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <table id="responsive-datatable" class="table datatable table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>urutan</th>
                                                <th>Nama Shift</th>
                                                <th>Schedule In</th>
                                                <th>Schedule Out</th>
                                                <th>Break start</th>
                                                <th>Break end</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data->shift as $x)
                                                <tr>
                                                    <td>{{ $x->urutan }}</td>
                                                    <td>{{ $x->name }}</td>
                                                    <td>{{ $x->schedule_in }}</td>
                                                    <td>{{ $x->schedule_out }}</td>
                                                    <td>{{ $x->break_start }}</td>
                                                    <td>{{ $x->break_end }}</td>
                                                    <td> <a href="{{route('edit.shift', $x->id)}}">edit</a></td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- tab Karyawan --}}
                        <div class="tab-pane fade" id="karyawan" role="tabpanel" aria-labelledby="karyawan-tab">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <table id="datatable" class="table datatable table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>NIK</th>
                                                <th>Location</th>
                                                <th>Jabatan</th>
                                                <th>Stakeholder</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee as $x)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('employee.show', $x->user_id) }}" target="_blank">
                                                            {{ $x->user->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $x->user->nik }}
                                                    </td>
                                                    <td>{{ $x->location }}</td>
                                                    <td>{{ $x->department }}</td>
                                                    <td>{{ $x->organization }}</td>
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
    </div>
@endsection

@push('js')
    <script>
        function redirect(url) {
            window.location.href = url;
        }

        // Check All
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
                    $('#modal-lokasi-karyawan').modal('hide');
                }
            })
        })

        $(document).find('.datatable').DataTable();
        $('#DataTable').DataTable();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
