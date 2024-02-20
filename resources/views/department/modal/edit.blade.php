 {{-- Modal edit lokasi --}}
 <div class="modal fade" id="modal-tambah-lokasi" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header" style="height: 50px">
                 <p>Edit</p>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('department.update', $data->id) }}" method="post">
                     @csrf
                     @method('PUT')
                     <div class="row">
                         <div class="col-md-12">
                             <div class="row">
                                 <div class="col-6">
                                     <div class="form-group">
                                         <label for="name">Name</label>
                                         <input class="form-control" id="name" name="name" placeholder="Nama Lokasi" value="{{ $data->name }}">
                                     </div>
                                 </div>
                                 <div class="col-6">
                                     <div class="form-group">
                                         <label for="code">code</label>
                                         <input type="text" name="code" class="form-control" value="{{ $data->code }}">
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
