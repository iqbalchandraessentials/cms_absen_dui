<div class="row g-0">
    <div class="col-md-2 mr-0" style="padding-right: 0; min-width: 15%;">
        <img class="img-fluid
        rounded-circle"
            src="{{ asset('style/dist/assets/images/users/avatar-1.jpg') }}" alt="Gambar Card"
            style="width: 65px; height: 65px;">
    </div>
    <div class="col-md-7 ml-0">
        <p class="mb-0 mt-2" style="font-weight: bold; text-align:left">{{ $data->user->name}}</p>
        <p>{{ $data->user->job_position}}</p>
    </div>

    {{-- Jika status approved --}}
    <div class="col-md-3">
        @if ($data->approve==0)
        <h5><span class="badge badge-light">PENDING<i class="fas fa-check-circle rounded-circle ml-2"
            style="color: #f1b53d"></i></span></h5>
        @elseif ($data->approve==1)
        <h5><span class="badge badge-light">APPROVED<i class="fas fa-check-circle rounded-circle ml-2"
            style="color: rgb(36, 194, 57)"></i></span></h5>
    </td>
        @endif
    </div>
</div>
<hr>

<div class="row mb-0">
    <div class="col-md-8">
        <p class="mb-0">Request date</p>
        <p class="mb-0">Overtime date</p>
        <p class="mb-0">Duration</p>
    </div>
    <div class="col-md-4" style="text-align: right">
        <p class="mb-0">{{$data->created_at}}</p>
        <p class="mb-0">{{$data->selected_date}}</p>
        <p class="mb-0">{{$data->overtime_duration_after}}</p>
    </div>
</div>
<div class="accordion" id="accordionExample">
    <div class="row mt-3">
        <div class="col-md-8">
            <p style="font-weight: bold">Detail</p>
        </div>
        <div class="col-md-4">
            <div class="accordion" id="accordionExample">
                <div class="collapse-container">
                    <div class="collapse-header">
                        <i class="fas fa-angle-down float-right" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                data-parent="#accordionExample">
                <div class="row mb-0">
                    <div class="col-md-7">
                        <p class="mb-0">Shift</p>
                        <p class="mb-0">Overtime before shift</p>
                        <p class="mb-0">Overtime after shift</p>
                        <p class="mb-0">Notes</p>
                    </div>
                    <div class="col-md-5" style="text-align: right">
                        <p class="mb-0">{{$data->user->schedule->shift->last()->schedule_in}} - {{$data->user->schedule->shift->last()->schedule_out}} {{$data->user->schedule->shift->last()->name}}</p>
                        <p class="mb-0">{{$data->overtime_duration_after}}</p>
                        <p class="mb-0">{{$data->overtime_duration_before}}</p>
                        <p class="mb-0">{{$data->description}}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-outline-secondary waves-effect">Cancel request</button>
</div>

