<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <h5>Import Rosters</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <form action="{{ route('roster.import') }}" method="post" enctype="multipart/form-data" accept=".xls,.xlsx">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Choose Start Date:') }}</label>
                                        <input id="start_date" name="start_date" required class="form-control" style="border-radius: 20px 20px 20px 20px" type="date">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('Choose End Date:') }}</label>
                                        <input id="end_date" name="end_date" required class="form-control" style="border-radius: 20px 20px 20px 20px" type="date">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center">
                                        <input type="file" name="excel_file" id="excel_file" class="mr-0">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info import-btn">Import</button>
            </div>
            </form>
        </div>
    </div>
</div>
