 {{-- Modal tambah lokasi --}}
 <div class="modal fade" id="modal-tambah-lokasi" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
     aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header" style="height: 50px">
                 <p>Lokasi</p>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('location.store') }}" method="post">
                     @csrf
                     <div class="row">
                         <div class="col-md-12">
                             <div class="row">
                                 <div class="col-6">
                                     <div class="form-group">
                                         <label for="name">Name</label>
                                         <input class="form-control" id="name" name="name"
                                             placeholder="Nama Lokasi">
                                     </div>
                                 </div>
                                 <div class="col-6">
                                     <div class="form-group">
                                         <label for="radius">Radius(m)</label>
                                         <input type="text" name="radius" class="form-control" placeholder="Radius">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="longitude">Longitude</label>
                                         <input type="text" class="form-control mb-3" name="longitude"
                                             placeholder="Longitude">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="Latitude">Latitude</label>
                                         <input type="text" class="form-control mb-3" name="latitude"
                                             placeholder="Latitude">
                                     </div>
                                 </div>
                                 <div class="col-12">
                                     <div class="form-group">
                                         <label for="name">Address</label>
                                         <input class="form-control" id="lokasi" name="location"
                                             placeholder="Lokasi">
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
