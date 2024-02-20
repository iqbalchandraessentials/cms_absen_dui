<div class="modal fade" id="modal-tambah-karyawan" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <p>Karyawan</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="@stack('action-address')" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="table-responsive">

                                <table id="DataTable" class="table DataTable table-bordered detailTable dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Organization</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all as $c)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="user_id[]" value="{{ $c->id }} " id="check-all">
                                                </td>
                                                <td>{{ $c->nik }}</td>
                                                <td>{{ $c->name }} {{ $c->active == 0 ? '❌' : '' }} </td>
                                                <td>{{ $c->department }}</td>
                                                <td>{{ $c->organization }}</td>
                                                <td>{{ $c->location }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn-Save">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
