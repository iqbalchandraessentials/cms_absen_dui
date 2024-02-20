 {{-- Modal tambah Cuti karyawan --}}
 <div class="modal fade" id="DvisionModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header" style="height: 50px">
                 <p>Create Cuti Karyawan </p>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             </div>
             <div class="modal-body">
                 <form method="post" action="{{ route('cuti-tahunan.create') }}" autocomplete="off" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label>Name</label>
                                 <select id="user_id" name="user_id" data-live-search="true" required class="selectpicker form-control">
                                     <option>Select User</option>
                                     @foreach ($user as $x)
                                         <option value="{{ $x->id }}">{{ $x->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <div class="form-group">
                                         <label>Kuota Tahunan</label>
                                         <input name="kuota_cuti" type="number" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col">
                                     <div class="form-group">
                                         <label>Sisa Kuota</label>
                                         <input type="number" name="sisa_cuti" class="form-control">
                                     </div>
                                 </div>
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
