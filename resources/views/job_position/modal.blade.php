    {{-- Modal tambah posisi --}}
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px">
                    <p>Job Position</p>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('job-position.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nama Job Position</label>
                                        <input type="text" name="name" class="form-control">
                                        <input type="text" name="status" value="1" hidden>
                                    </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
