@extends('layouts.app')
<!-- @push('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush -->
@section('title', 'Add Schedule')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Schedule</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form id="basic-form" method="post" action="{{ route('schedule.store') }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <h3>Create Schedule</h3>
                            <section>
                                <h5 class="mb-0">Personal data</h5>
                                <p>Fill all employee personal basic information data </p>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group has-validation">
                                            <label for="name">Name<span class="text-danger">*</span></label>
                                            <div>
                                                <input id="name" autofocus name="name" value="{{ old('name') }}" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group has-validation">
                                            <label>Weeks<span class="text-danger">*</span></label>
                                            <select class="form-control" name="weeks" id="weeks">
                                                <option value="1">1 weeks</option>
                                                <option value="2">2 weeks</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3>Initial Shift</h3>
                                <h5 class="mb-0">Personal data</h5>
                                <p>Fill all employee personal basic information data </p>
                                <div id="dynamic-content"></div>
                            </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
        // Initial load
        generateDynamicContent();

        // Handle change event of the dropdown
        $("#weeks").on("change", function () {
            generateDynamicContent();
        });

        function generateDynamicContent() {
            var selectedWeeks = $("#weeks").val();
            var dynamicContent = $("#dynamic-content");

            // Clear previous content
            dynamicContent.empty();

            for (var i = 0; i < selectedWeeks; i++) {
                dynamicContent.append(`
                    <div class="row" id="week-${i + 1}">
                        <div class="row" id="first-week">
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Monday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Tuesday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Wednesday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Thursday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Friday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Saturday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group has-validation">
                                            <h4><label class="badge badge-pill badge-primary" for="name">Sunday<span class="text-danger">*</span></label></h4>
                                            <div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">shift-name</label>
                                                    <div class="col-sm-8">
                                                        <input name="ShiftName[]" type="text" class="form-control" required >
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-in</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftIn[]" type="time" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">clock-out</label>
                                                    <div class="col-sm-8">
                                                        <input name="timeShiftOut[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-start</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakStart[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">break-end</label>
                                                    <div class="col-sm-8">
                                                        <input name="breakEnd[]" type="time" class="form-control" required>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                `);
            }
        }
    });
</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
