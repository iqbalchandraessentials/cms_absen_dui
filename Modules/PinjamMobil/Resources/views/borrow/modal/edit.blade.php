<div class="modal fade" id="modal-edit-borrow" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <p>EDIT</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('borrow-vehicles.update', $data['id']) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="merek">Driver</label>
                                        <select name="driver" id="driver" class="form-control">
                                            @if (isset($data['driver']['name']))
                                                <option value="{{ $data['driver']['id'] }}" selected>{{ $data['driver']['name'] }}</option>
                                            @endif
                                            @foreach ($all_driver as $item)
                                                @if (!isset($data['driver']['name']) || $item->id != $data['driver']['id'])
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="merek">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            @if (isset($data['status_ga']))
                                                <option value="{{ $data['status_ga'] }}" selected>
                                            @endif
                                            @php
                                                $status = $data['status_ga'];
                                            @endphp
                                            @if ($status == 0)
                                                Menunggu approval GA
                                            @elseif($status == 1)
                                                Disetujui
                                            @elseif($status == 2)
                                                Ditolak
                                            @elseif($status == 3)
                                                Dibatalkan user
                                            @else
                                                Menunggu approval atasan
                                            @endif
                                            </option>
                                            <option value="2" {{ $status == '2' ? 'disabled' : '' }}>Cancel</option>
                                        </select>
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
