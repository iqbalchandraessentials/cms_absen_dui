<div class="modal fade" id="modal-tambah-lokasi" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <p>EDIT</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pinjammobil.update', $data['id']) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="active">Active</label>
                                        <select id="active" name="active" class="form-control">
                                            <option value="{{ $data['active'] }}">-- {{ $data['active'] == 0 ? 'Active' : 'InActive' }} --</option>
                                            <option value="0">Active</option>
                                            <option value="1">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="merek">Merek</label>
                                        <input required class="form-control" id="merek" name="merek" value="{{ $data['merek'] }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input required type="text" name="type" class="form-control" value="{{ $data['type'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_polisi">Nomor Polisi</label>
                                        <input required type="text" class="form-control mb-3" name="no_polisi" value="{{ $data['nopol'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor_rangka">Nomor Rangka</label>
                                        <input type="text" class="form-control mb-3" name="nomor_rangka" value="{{ $data['nomor_rangka'] }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="nomor_mesin">Nomor Mesin</label>
                                        <input class="form-control" id="nomor_mesin" name="nomor_mesin" value="{{ $data['nomor_mesin'] }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="pajak_berakhir">Pajak Berakhir</label>
                                        <input type="date" class="form-control" id="pajak_berakhir" name="pajak_berakhir" value="{{ $data['pajak_berakhir'] }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="stnk_berakhir">STNK Berakhir</label>
                                        <input type="date" class="form-control" id="stnk_berakhir" name="stnk_berakhir" value="{{ $data['stnk_berakhir'] }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="stnk_berakhir">PIC</label>
                                        <select id="pic_id" name="pic_id" class="form-control">
                                            <option value="{{ $data['vehicle_pic']['pic_id'] }}">-- {{ $data['vehicle_pic']['pic'] }} --</option>
                                            @foreach ($pic as $y)
                                                <option value="{{ $y->id }}">{{ $y->users->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="stnk_berakhir">location</label>
                                        <select id="lokasi_id" name="lokasi_id" class="form-control">
                                            <option value="{{ $data['vehicle_lokasi']['lokasi_id'] }}">-- {{ $data['vehicle_lokasi']['lokasi'] }} --</option>
                                            @foreach ($location as $y)
                                                <option value="{{ $y->id }}">{{ $y->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="last_km">Last KM</label>
                                        <input required type="text" name="last_km" id="last_km" class="form-control" value="{{ $data['last_km'] ?? '-' }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control-file" id="image" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
