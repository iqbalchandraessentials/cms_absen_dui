@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Detail Location')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Location</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="row">
                    <div class=" col-md-3 col-lg-6">
                        <h3 class="text" style="font-weight: bold; margin:0 ">{{ $data->name }} -
                            jml({{ $total }})</h3>
                    </div>
                    <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                        @can('edit-location', Auth::user())
                            <a  class="button" style="color: #fff; font-weight:500" data-toggle="modal" data-target="#modal-tambah-lokasi"> Edit</a>
                        @endcan
                    </div>
                </div>
                @include('layouts.modal.table')
            </div>
        </div>
    </div>
    @include('location.modal.edit_location')
@endsection

@push('js')
    <script>
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

        $(document).find('.DataTable').DataTable();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
