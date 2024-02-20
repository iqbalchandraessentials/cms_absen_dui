<div class="modal fade bs-example-modal-center" id="modal-edit-lokasi" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit lokasi</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-9">
                            <select id="location-select" name="location_id" onchange="locationTable()">
                                @foreach ($locations as $x)
                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn button" style="width: 95px; height: 35px; text-align:center; padding: 5px; color:white;">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="table-location" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-center" id="modal-timeoff" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Jumlah Timeoff Yang Diajukan </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-dark text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Number Of Request</th>
                                    <th scope="col">Limit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CT</td>
                                    <td>{{ $cuti->CT }}</td>
                                    <td>{{ $limit[0]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CB</td>
                                    <td>{{ $cuti->CB }}</td>
                                    <td>{{ $limit[1]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CM</td>
                                    <td>{{ $cuti->CM }}</td>
                                    <td>{{ $limit[2]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CMA</td>
                                    <td>{{ $cuti->CMA }}</td>
                                    <td>{{ $limit[3]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CKA</td>
                                    <td>{{ $cuti->CKA }}</td>
                                    <td>{{ $limit[4]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CIM</td>
                                    <td>{{ $cuti->CIM }}</td>
                                    <td>{{ $limit[6]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CKM</td>
                                    <td>{{ $cuti->CKM }}</td>
                                    <td>{{ $limit[7]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CRM</td>
                                    <td>{{ $cuti->CRM }}</td>
                                    <td>{{ $limit[8]->duration }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col">
                        <table class="table table-dark text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Number Of Request</th>
                                    <th scope="col">Limit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>SDSD</td>
                                    <td>{{ $cuti->SDSD }}</td>
                                    <td>{{ $limit[16]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>STSD</td>
                                    <td>{{ $cuti->STSD }}</td>
                                    <td>{{ $limit[20]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>DLK</td>
                                    <td>{{ $cuti->DLK }}</td>
                                    <td>{{ $limit[18]->duration }}</td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>CL</td>
                                    <td>{{ $cuti->CL }}</td>
                                    <td>{{ $limit[9]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CK</td>
                                    <td>{{ $cuti->CK }}</td>
                                    <td>{{ $limit[11]->duration }}</td>
                                </tr>
                                <td>UL</td>
                                <td>{{ $cuti->UL }}</td>
                                <td>{{ $limit[19]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CR</td>
                                    <td>{{ $cuti->CR }}</td>
                                    <td>{{ $limit[21]->duration }}</td>
                                </tr>
                                <tr>
                                    <td>CFM</td>
                                    <td>{{ $cuti->CFM }}</td>
                                    <td>{{ $limit[22]->duration }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="table-location" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-center" id="modal-edit-resign" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p>Resign Date</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="date" name="resign_date" class="form-control" placeholder="mm/dd/yyyy">
                                <input type="text" value="0" name="active" hidden>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn button" style="width: 95px; height: 35px; text-align:center; padding: 5px; color:white;">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="table-location" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-center" id="modal-edit-data" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h5 class="mt-0">Personal data</h5>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input name="name" type="text" class="form-control" value="{{ $data->name }}">
                                </div>
                                <div class="form-group">
                                    <label>Nomor Handphone</label>
                                    <input name="mobile_phone" type="text" class="form-control" value="{{ $data->mobile_phone }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" type="email" class="form-control" value="{{ $data->email }}">
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input name="birth_place" type="text" class="form-control" value="{{ $data->birth_place }}">
                                </div>
                                @if ($data->organization_id == 10)
                                    <div class="form-group">
                                        <label>Is Updated</label>
                                        <select name="is_updated" class="form-control">
                                            <option value="{{ $data->is_updated }}"> --
                                                {{ $data->is_updated == 1 ? 'Yes' : 'No' }} --</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="gender" id="jenis_kelamin" class="form-control">
                                        <option value="{{ $data->gender }}"> -- {{ $data->gender }} --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status Perkawinan</label>
                                    <select name="marital_status" id="status" class="form-control" name="marital_status">
                                        <option value="{{ $data->marital_status }}"> -- {{ $data->marital_status }}
                                            --</option>
                                        <option value="married">Married</option>
                                        <option value="single">Single</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select name="religion" id="agama" class="form-control">
                                        <option value="{{ $data->religion }}"> -- {{ $data->religion }} --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Protestan">Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input name="birth_date" type="date" class="form-control" value="{{ $data->birth_date }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-0">Identity & address</h5>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ID type</label>
                                    <select name="id_type" disabled id="id_type" class="form-control">
                                        <option value="KTP">KTP</option>
                                        <option value="Pasport">Pasport</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Citizen ID address</label>
                                    <textarea name="citizen_id_address" type="text" class="form-control">{{ $data->citizen_id_address }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ID number</label>
                                    <input type="text" class="form-control" value="{{ $data->citizen_id }}">
                                </div>
                                <div class="form-group">
                                    <label>Residential address</label>
                                    <textarea name="resindtial_address" type="text" class="form-control">{{ $data->resindtial_address }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-0">Contact Emergency</h5>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="emergency_name">Employment name</label>
                                    <input type="text" name="emergency_name" class="form-control" value="{{ $data->emergency_name }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Phone number</label>
                                    <input type="text" name="emergency_number" class="form-control" value="{{ $data->emergency_number }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-0">Employment data</h5>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input name="nik" type="text" class="form-control" value="{{ $data->nik }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Schedule</label>
                                    <select id="schedule_id" name="schedule_id" class="form-control @error('schedule_id') is-invalid @enderror">
                                        @if (isset($user_schedule))
                                            <option value="">{{ $user_schedule->schedule->name }}</option>
                                        @else
                                            <option value="">-</option>
                                        @endif
                                        @foreach ($jadwal as $x)
                                            <option value="{{ $x->id }}"> {{ $x->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="status_employee">Employment status<span class="text-danger">*</span></label>
                                    <select id="status-employee" required name="status_employee" class="form-control @error('status_employee') is-invalid @enderror">
                                        <option value="{{ $data->status_employee }}" selected>
                                            {{ $data->status_employee }}</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Permanent">Permanent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="join_date">Join date</label>
                                    <input id="join_date" name="join_date" type="date" class="form-control" value="{{ $data->join_date }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="end_date">End date</label>
                                    <input id="end_date" name="end_date" type="date" class="form-control" {{ $data->status_employee == 'Permanent' ? 'disabled' : '' }} value="{{ $data->end_date }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="division">Division </label>
                                    <select id="division" name="division_id" data-live-search="true" class="selectpicker form-control">
                                        <option value="{{ $data->division_id }}" selected>{{ $data->division }}
                                        </option>
                                        @foreach ($division as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="location_id">Branch<span class="text-danger">*</span></label>
                                    <select id="location" required name="location_id" data-live-search="true" class="selectpicker form-control">
                                        <option value="{{ $data->location_id }}" selected>{{ $data->location }}
                                        </option>
                                        @foreach ($locations as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="job_position">Job position <span class="text-danger">*</span></label>
                                    <select id="job_position" name="job_position" data-live-search="true" class="selectpicker form-control">
                                        <option value="{{ $data->job_position }}">{{ $data->position }}</option>
                                        @foreach ($jobposition as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="approval_line_id">Approval line </label>
                                    <select id="approval_line_id" name="approval_line_id" data-live-search="true" class="selectpicker form-control ">
                                        @if ($data->approval_line_id == null)
                                            <option value="">-</option>
                                        @else
                                            <option value="{{ $data->approval_line_id }}">{{ $data->approval_line }}
                                            </option>
                                        @endif
                                        @foreach ($approval_line as $x)
                                            <option value="{{ $x->id }}"> {{ $x->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select id="department" name="department_id" required data-live-search="true" class="selectpicker form-control ">
                                        <option value="{{ $data->department_id }}">{{ $data->department }}</option>
                                        @foreach ($department as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="organization_id">PT.<span class="text-danger">*</span></label>
                                    <select id="organization_id" required name="organization_id" data-live-search="true" class="selectpicker form-control ">
                                        <option value="{{ $data->organization_id }}">{{ $data->organization }}
                                        </option>
                                        @foreach ($organization as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="job_level_id">Job level</label>
                                    <select id="job_level_id" name="job_level_id" class="form-control ">

                                        <option value="{{ $data->job_level_id }}">{{ $data->level }}</option>
                                        @foreach ($position as $x)
                                            <option value="{{ $x->id }}">{{ $x->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="manager">Manager </label>
                                    <select id="manager" name="manager_id" data-live-search="true" class="selectpicker form-control ">
                                        @if ($data->manager_id == null)
                                            <option value="">-</option>
                                        @else
                                            <option value="{{ $data->manager_id }}">{{ $data->manager }}</option>
                                        @endif
                                        @foreach ($manager as $x)
                                            <option value="{{ $x->id }}"> {{ $x->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <p>Create</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('absence.create', $data->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" required class="form-control" name="date">
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" required name="status" class="form-control" value="H" placeholder="H (Hadir)" readonly>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label>Shift</label>
                                <select id="shift_id" required name="shift_id" class="form-control">
                                    @foreach ($shift as $x)
                                        <option value="{{ $x->id }}">{{ $x->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Clock In</label>
                                <input type="time" name="check_in" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Clock Out</label>
                                <input type="time" name="check_out" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Overtime Before</label>
                                <input type="number" name="overtime_before" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Overtime After</label>
                                <input type="number" name="overtime_after" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
