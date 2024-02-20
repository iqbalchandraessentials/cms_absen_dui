<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <p>Create</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('report_absence.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <select id="user_id" name="user_id" data-live-search="true"
                            class="selectpicker form-control ">
                            @foreach ($employee as $x)
                                <option value="{{ $x->id }}"> {{ $x->nik }} - {{ $x->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date">
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="H">H (Hadir)</option>
                                    <option value="CT">CT (Cuti Tahunan)</option>
                                    <option value="CB">CB (Cuti Besar)</option>
                                    <option value="SDSD">SDSD (Sakit Dengan Surat Dokter)</option>
                                    <option value="STSD">STSD (Sakit Tanpa Surat Dokter)</option>
                                    <option value="DLK">DLK (Dinas Luar Kantor)</option>
                                    {{-- @foreach ($list_timeoff as $x)
                                <option value="{{ $x->code }}"> {{ $x->name }} </option>
                                @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Shift</label>
                                <select id="shift_id" name="shift_id" class="form-control" required>
                                    @foreach ($shift as $x)
                                        <option value="{{ $x->id }}"> {{ $x->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Clock In</label>
                                <input type="time" name="check_in" required class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Clock Out</label>
                                <input type="time" name="check_out" required class="form-control">
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


{{-- Export Excel --}}
<div class="modal fade" id="exportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('export.jadwal') }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export</h5>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <label>Start Date</label>
                            <div class="input-group">
                                <input type="text" required class="form-control" placeholder="mm/dd/yyyy"
                                    data-provide="datepicker" name="start_date" data-date-autoclose="true"
                                    autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label>Untill Date</label>
                            <div class="input-group">
                                <input type="text" required name="end_date" class="form-control" placeholder="mm/dd/yyyy"
                                    data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <fieldset>
                        <div class="form-group mt-2 clearfix">
                            <label for="Organization">Organization <i class="fas fa-info-circle"></i></label>
                            <select class="form-control" id="Organization" name="organization_id">
                                <option value="all" selected>-- All --</option>
                                @foreach ($organization as $x)
                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </div>
        </form>
    </div>
</div>
