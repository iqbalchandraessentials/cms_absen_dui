@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Roles')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold">Roles</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6" style="text-align: right; display:inline-block">
                            <a href="{{ route('role.create') }}" class="button">Create Roles</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="RoleTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($role as $x)
                                            <tr>
                                                <td>{{ $x->name }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-info" href="#" role="button" data-toggle="dropdown"aria-expanded="false">Action</button>
                                                        <div class="dropdown-menu dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{ route('role.edit', $x->id) }}">Edit</a>
                                                            <form method="post" id="delete-form-{{ $x->id }}" action="#" style="display: none">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                            </form>
                                                            <a class="dropdown-item" href=""
                                                                onclick="if(confirm('Are you sure?'))
                                                        {
                                                            event.preventDefault();document.getElementById('delete-form-{{ $x->id }}').submit();
                                                        }
                                                        else{
                                                            event.preventDefault();
                                                        }">Hapus
                                                            </a>
                                                        </div>
                                                    </div>
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
        $(document).ready(function() {
            $('#RoleTable').DataTable();
        });
    </script>
@endpush
