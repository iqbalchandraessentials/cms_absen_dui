@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@section('title', 'Roles')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="/role">Roles</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                <div class="card-header" style="background-color:white">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h5 class="text" style="font-weight: bold">Fill this form</h5>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ route('role.update', $role->id) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" id="name" name="name" value="{{ $role->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For Employee :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'employee')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For Internal Memo:') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'internal-memo')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For Location :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'location')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For Schedule :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'schedule')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For business :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'business')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For department :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'department')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For division :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'division')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For level :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'level')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For job-position :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'job-position')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For roster :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'roster')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For timeoff :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'timeoff')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For attendance :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'attendance')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For report-overtime :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'report-overtime')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For reporttimeoff :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'reporttimeoff')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For report-outofrange :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'report-outofrange')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For report-attendance :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'report-attendance')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="form-control-label" for="input-name">{{ __('For others :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'Others')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" @foreach ($role->permissions as $role_permit) @if ($role_permit->id == $permission->id) checked @endif @endforeach>
                                                        {{ $permission->name }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                        </div>

                    </div>

                </div>
                <div class="card-footer" style="background-color:white">
                    <a class="btn btn-secondary btn-round text-white" onclick="history.back()">
                        Back</a>
                    <button type="submit" class="btn btn-primary btn-round">{{ __('Save') }}</button>
                </div>
                </form>
            </div>

        </div>
    </div>


    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class=" col-md-6 col-lg-6">
                        <h4>Hak Akses User {{$role->name}}</h4>
                    </div>
                    <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            <a class="button" style="color: #fff; font-weight:500" data-toggle="modal"
                            data-target="#DvisionModal"> Create</a>
                    </div>

                </div>
                <table id="" class="table detailTable table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NIK</th>
                            <th>Organization</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role->users as $x)
                        <tr>
                            <td><a href="{{route('employee.show', $x->user->id)}}"> {{ $x->user->nik }} </a> </td>
                            <td> {{$x->user->name}} </td>
                            <td> {{$x->user->organization->name}} </td>
                            <td><a href="{{ route('deleteRoleUser', $x->id) }}" style="color: red;">Hapus</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{-- Modal tambah Cuti karyawan --}}
<div class="modal fade" id="DvisionModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header" style="height: 50px">
            <p>Hak Akses User {{$role->name}}</p>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ route('addOrEditRole') }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                           <div class="form-group">
                               <label>Name</label>
                               <select id="user_id" name="user_id" data-live-search="true" required class="selectpicker form-control">
                                   <option>Select User</option>
                                   @foreach ($users as $x)
                                       <option value="{{ $x->id }}">{{ $x->name }}</option>
                                   @endforeach
                               </select>
                               <input type="text" value="{{$role->id}}" name="role_id" hidden>
                           </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="save-btn">Create</button>
        </div>
        </form>
    </div>
</div>
</div>



@endsection
@push('js')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
