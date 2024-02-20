<div class="modal fade" id="modal-tambah-lokasi" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="height: 50px">
                <p>Edit</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                 <form action="{{ route('pic-vehicles.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                     @csrf
                     <div class="row">
                         <div class="col-md-12">
                             <div class="row">
                                 <div class="col-12">
                                     <div class="form-group">
                                         <label for="name">Active</label>
                                         <select id="active" name="active" class="form-control">
                                            <option value="{{ $data['active'] }}">-- {{ $data['active'] == 0 ? 'Active' : 'InActive' }} --</option>
                                            <option value="0">Active</option>
                                            <option value="1">InActive</option>
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
