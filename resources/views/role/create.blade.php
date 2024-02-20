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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="/role">Roles</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                            <form method="post" action="{{ route('role.store') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" id="name" name="name" placeholder="Name">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                                        <label class="form-control-label" for="input-name">{{ __('For Others :') }}</label>
                                        @foreach ($permissions as $permission)
                                            @if ($permission->for == 'Others')
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->id }}">
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
                    <div class="card-footer" style="background-color:white">
                        <a class="btn btn-secondary btn-round text-white" onclick="history.back()">
                            Back</a>
                        <button type="submit" class="btn btn-primary btn-round">{{ __('Save') }}</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>



    @endsection
    @push('js')
    @endpush
