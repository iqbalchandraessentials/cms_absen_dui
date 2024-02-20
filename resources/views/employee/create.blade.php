@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@section('title', 'Form Karyawan')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Form karyawan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form id="basic-form" method="post" action="{{ route('employee.store') }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <h3>Personal data</h3>
                            <section>
                                <h5 class="mb-0">Personal data</h5>
                                <p>Fill all employee personal basic information data </p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group has-validation">
                                            <label for="name">Name<span class="text-danger">*</span></label>
                                            <div>
                                                <input id="name" autofocus name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror">
                                            </div>
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group has-validation">
                                            <label for="email">Email<span class="text-danger">*</span></label>
                                            <input id="email" autofocus name="email" value="{{ old('email') }}" type="text" class="form-control @error('email') is-invalid @enderror">
                                            @if ($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group has-validation">
                                                <label for="gender">Gender<span class="text-danger">*</span></label>
                                                <div class="form-inline">
                                                    <div class="form-check mb-3 mr-3">
                                                        <div class="custom-control custom-radio">
                                                            <input name="gender" type="radio" id="gender" value="Male" class="custom-control-input">
                                                            <label class="custom-control-label" for="gender">Male</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check mb-3 mr-3">
                                                        <div class="custom-control custom-radio">
                                                            <input name="gender" type="radio" id="gender2" value="Female" class="custom-control-input">
                                                            <label class="custom-control-label" for="gender2">Female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('gender'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group has-validation">
                                            <label for="mobile_phone ">Mobile phone<span class="text-danger">*</span></label>
                                            <div>
                                                <input id="mobile_phone" autofocus name="mobile_phone" type="number" value="{{ old('mobile_phone') }}" class="form-control @error('mobile_phone') is-invalid @enderror">
                                            </div>
                                            @if ($errors->has('mobile_phone'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('mobile_phone') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="religion">Religion<span class="text-danger">*</span></label>
                                            <select id="religion" name="religion" class="form-control @error('religion') is-invalid @enderror">
                                                <option value="" selected>Choose...</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Kristen Katolik">Kristen Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                            @if ($errors->has('religion'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('religion') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="birth_place">Place of birth</label>
                                            <div>
                                                <input id="birth_place" name="birth_place" value="{{ old('birth_place') }}" type="text" class="form-control @error('birth_place') is-invalid @enderror">
                                            </div>
                                            @if ($errors->has('birth_place'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_place') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="birthdate">Birthdate <span class="text-danger">*</span></label>
                                            <div>
                                                <input name="birth_date" id="example-date-input" type="date" value="{{ old('birth_date') }}" class="form-control @error('birth_date') is-invalid @enderror">
                                            </div>
                                            @if ($errors->has('birth_date'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_date') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleSelect1">Marital status<span class="text-danger">*</span></label>
                                            <select id="marital-status" name="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                                                <option value="" selected>Choose...</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widow">Widow</option>
                                            </select>
                                            @if ($errors->has('marital_status'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('marital_status') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- end row --}}
                                <hr>
                                <h5 class="mb-0">Identity & address</h5>
                                <p>Employee identity address information</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="identiTytype">Identity type</span></label>
                                            <select class="form-control" id="identiTytype" name="identityType" disabled>
                                                <option selected value="KTP">KTP</option>
                                                <option value="SIM">SIM</option>
                                                <option value="STNK">STNK</option>
                                                <option value="Pasport">Pasport</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="citizen_id ">Identity number <span class="text-danger">*</span></label>
                                            <input id="citizen_id" name="citizen_id" class="form-control @error('citizen_id') is-invalid @enderror" value="{{ old('citizen_id') }}" type="number">
                                            @if ($errors->has('citizen_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('citizen_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="citizen_id_address">Citizen ID address</label>
                                            <textarea class="form-control" name="citizen_id_address" id="citizen_id_address" rows="3">{{ old('citizen_id_address') }}</textarea>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-address" type="checkbox" name="same_as_citizen_id_address">
                                                <label for="checkbox-address">
                                                    Use as residential address
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="resindtial_address">Residential address</label>
                                            <textarea class="form-control" name="resindtial_address" id="resindtial_address" rows="3">{{ old('resindtial_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-0">Contact Emergency</h5>
                                <p>Employee Contact Emergency information</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="emergency_name">Name </label>
                                            <div>
                                                <input class="form-control" name="emergency_name" value="{{ old('emergency_name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="emergency_number">Phone</label>
                                            <div>
                                                <input class="form-control" name="emergency_number" value="{{ old('emergency_number') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Employment data --}}
                            </section>
                            <h3>Employment data</h3>
                            <section>
                                <h5 class="mb-0">Employment data</h5>
                                <p>Fill all employee data information related to company</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="nik"> Employee ID<span class="text-danger">*</span></label>
                                            <input id="nik" name="nik" type="text" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror">
                                            @if ($errors->has('nik'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('nik') }}</strong>
                                                </div>
                                            @endif
                                            <input id="order_month" name="order_month" type="text" value="{{ $order_month }}" class=" form-control" hidden>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="status_employee">Employment status<span class="text-danger">*</span></label>
                                            <select id="status-employee" name="status_employee" class="form-control @error('status_employee') is-invalid @enderror">
                                                <option value="" selected>Choose...</option>
                                                <option value="Contract">Contract</option>
                                                <option value="Permanent">Permanent</option>
                                            </select>
                                            @if ($errors->has('status_employee'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('status_employee') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="join_date">Join date<span class="text-danger">*</span></label>
                                            <div>
                                                <input id="join_date" name="join_date" type="date" value="{{ old('join_date') }}" class="form-control @error('join_date') is-invalid @enderror">
                                            </div>
                                            @if ($errors->has('join_date'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('join_date') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <div class="form-group clearfix">
                                                <label for="end_date">End status date</label>
                                                <div>
                                                    <input id="endDate" name="end_date" type="date" class="form-control" placeholder="No end date" value="{{ old('end_date') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <fieldset>
                                            <div class="form-group clearfix has-validation">
                                                <label for="division_id">Division<i class="fas fa-info-circle"></i></label>
                                                <select id="division_id" name="division_id" data-live-search="true" required class="selectpicker form-control @error('division_id') is-invalid @enderror">
                                                    <option value="division_id" selected>Select Division</option>
                                                    @foreach ($division as $x)
                                                        <option value="{{ $x->id }}">{{ $x->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('division_id'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('division_id') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6">
                                        <fieldset>
                                            <div class="form-group clearfix">
                                                <label for="department_id">Department<i class="fas fa-info-circle"></i></label>
                                                <select id="department" name="department_id" data-live-search="true" class="selectpicker form-control @error('department_id') is-invalid @enderror">
                                                    <option value="">Select Department</option>
                                                    @foreach ($department as $x)
                                                        <option value="{{ $x->id }}">{{ $x->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('department_id'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('department_id') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="location_id">Branch<span class="text-danger">*</span></label>
                                            <select id="location" name="location_id" data-live-search="true" class="selectpicker form-control @error('location_id') is-invalid @enderror">
                                                <option value="" value="">Choose...</option>
                                                @foreach ($location as $x)
                                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('location_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('location_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="organization_id">PT.<span class="text-danger">*</span></label>
                                            <select id="organization_id" name="organization_id" data-live-search="true" class="selectpicker form-control @error('organization_id') is-invalid @enderror">
                                                <option value="">Choose...</option>
                                                @foreach ($organization as $x)
                                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('organization_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('organization_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="job_position">Job position <span class="text-danger">*</span></label>
                                            <select id="job_position" name="job_position" data-live-search="true" class="selectpicker form-control @error('job_position') is-invalid @enderror">
                                                <option value="">Choose...</option>
                                                @foreach ($jobposition as $x)
                                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('job_position'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('job_position') }}</strong>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="job_level_id">Job level<span class="text-danger">*</span></label>
                                            <select id="job_level_id" name="job_level_id" class="form-control @error('job_level_id') is-invalid @enderror">
                                                <option value="">Choose...</option>
                                                @foreach ($position as $x)
                                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('job_level_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('job_level_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="grade">Grade</label>
                                            <select class="form-control" id="grade" name="grade">
                                                <option value="">Choose...</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="class">Golongan</label>
                                            <select class="form-control" name="golongan" id="class">
                                                <option value="">Select class</option>
                                                <option value="midle">Midle</option>
                                                <option value="top">Top</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="schedule_id">Schedule <span class="text-danger">*</span></label>
                                            <select id="schedule_id" name="schedule_id" class="form-control @error('schedule_id') is-invalid @enderror">
                                                <option value="">Select schedule</option>
                                                @foreach ($schedule as $x)
                                                    <option value="{{ $x->id }}"> {{ $x->name }} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('schedule_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('schedule_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="approval_line_id">Approval line </label>
                                            <select id="approval_line_id" data-live-search="true" name="approval_line_id" class="selectpicker form-control @error('approval_line_id') is-invalid @enderror">
                                                <option value="" selected>Select approval line</option>
                                                @foreach ($approval_line as $x)
                                                    <option value="{{ $x->id }}"> {{ $x->nik }} - {{ $x->name }} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('approval_line_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('approval_line_id') }}</strong>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="manager_id">Manager <i class="fas fa-info-circle"></i></label>
                                            <select id="manager_id" data-live-search="true" name="manager_id" class="selectpicker form-control @error('manager_id') is-invalid @enderror">
                                                <option value="" selected>Select Manager</option>
                                                @foreach ($manager as $x)
                                                    <option value="{{ $x->id }}"> {{ $x->nik }} - {{ $x->name }} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('manager_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('manager_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label>(<span class="text-danger">*</span>) Wajib diisi</label>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <h3>Payroll</h3>
                            <section>
                                <h5 class="mb-0">Salary</h5>
                                <p>Input employee salary info</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="userName">Basic salary<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" style="text-align: right">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="nba_koperasi">Nomor Buku Anggota Koperasi<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nba_koperasi" id="nba_koperasi">
                                        </div>
                                    </div> --}}
                                </div><!-- end row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="">Payment schedule</label>
                                                </div>
                                                <div class="col-sm-6 mt-0 mb-0" style="text-align: right">
                                                    {{-- <a href="">setting</a> --}}
                                                </div>
                                            </div>
                                            <select class="form-control" name="" id="">
                                                <option selected>default</option>
                                                <option value="">1</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Prorate setting</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select prorate setting</option>
                                                <option value="">1</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <fieldset disabled>

                                                <label for="">Cost center</label>
                                                <select class="form-control" name="" id="">
                                                    <option selected>Select cost center</option>
                                                    <option value="">1</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Cost center category</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select category</option>
                                                <option value="">1</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="userName">Allowed for overtime</span></label>
                                            <div class="form-inline">
                                                <div class="form-check mb-3 mr-3">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="gender" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="gender">Yes</label>
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3 mr-3">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Overtime working day default</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Chosee</option>
                                                <option value="">LEMBUR HARI KERJA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Overtime day off default</label>
                                            <select class="form-control" name="" id="">
                                                <option value="" selected>Choose...</option>
                                                <option value="">LEMBUR</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Overtime nasional default</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Choose...</option>
                                                <option value="">LEMBUR</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-0">Bank account</h5>
                                <p>The employee's account is used for payroll</p>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group clearfix">
                                            <label for="">Bank Name</label>
                                            <select class="form-control" name="bank_name" id="">
                                                <option value="">Select bank</option>
                                                <option value="BCA">BCA</option>
                                                <option value="BRI">BRI</option>
                                                <option value="BNI">BNI</option>
                                                <option value="Mandiri">Mandiri</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Account number</label>
                                            <div>
                                                <input class=" form-control" type="number" name="bank_account" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Account holder name</label>
                                            <div>
                                                <input class=" form-control" type="text" name="" id="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h5 class="mb-0">Tax configuration</h5>
                                <p>Select the calculation type relevant to your company</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">NPWP</label>
                                            <div>
                                                <input class=" form-control" type="text" name="" id="" placeholder="00.000.000.0.000.000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">PTKP status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="ptkp_status" id="">
                                                <option value="">Select PTKP status</option>
                                                <option value="TK0">TK0</option>
                                                <option value="TK1">TK1</option>
                                                <option value="TK2">TK2</option>
                                                <option value="K0">K0</option>
                                                <option value="K1">K1</option>
                                                <option value="K2">K2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Tax method</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select...</option>
                                                <option value="">Netto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Tax salary <span class="text-danger">*</span></label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select...</option>
                                                <option value="">Non-taxable</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Taxable date <i class="fas fa-info-circle"></i> </label>
                                            <div>
                                                <input class="form-control" type="date" name="" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Employment tax status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select...</option>
                                                <option value="">Pegawai tetap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="userName">Baginning netto <i class="fas fa-info-circle"></i></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" style="text-align: right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="userName">PPH21 paid <i class="fas fa-info-circle"></i></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" style="text-align: right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="mb-0">BPJS configuration</h5>
                                <p>Employee BPJS payment arrangements</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">BPJS ketenagakerjaan number</label>
                                            <div>
                                                <input type="text" class=" form-control" placeholder="0">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">NPP BPJS ketenagakerjaan</label>
                                            <div>
                                                <input type="text" class=" form-control" placeholder="Select NPP BPJS ketenagakerjaan ">

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group clearfix">
                                            <label for=""> BPJS ketenagakerjaan date <i class="fas fa-info-circle"></i> </label>
                                            <div>
                                                <input class="form-control" type="date" id="example-date-input">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">BPJS kesehatan number</label>
                                            <div>
                                                <input class=" form-control" type="text" name="" id="" placeholder="0">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">BPJS kesehatan family</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select BPJS kesehatan family</option>
                                                <option>1</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">BPJS kesehatan date </label>
                                            <div>
                                                <input class="form-control" type="date" id="example-date-input">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">BPJS kesehatan cost</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Select ..</option>
                                                <option>By employee</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group clearfix">
                                            <label for="">JHT cost</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Choose...</option>
                                                <option value="">By employee</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Jaminan pensiun cost</label>
                                            <select class="form-control" name="" id="">
                                                <option selected>Chosee...</option>
                                                <option value="">By employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <label for="">Jaminan pensiun date
                                            </label>
                                            <div>
                                                <input class="form-control" type="date" id="example-date-input">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </section>
                            <h3>Finish</h3>
                            <section>
                                <div class="form-group clearfix row">
                                    <div class="col-lg-12">
                                        <div class="checkbox checkbox-primary">
                                            <input id="checkbox-h" type="checkbox">
                                            <label for="checkbox-h">
                                                I agree with the <a href="#">Terms and Conditions</a>.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('change', '#status-employee', function() {
            var statusemployee = $("#status-employee").val();
            if (statusemployee == "Permanent") {
                $("#endDate").attr('disabled', 'disabled');
            } else {
                $("#endDate").prop('disabled', false);
                $("#endDate").val('');
            }
        });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
