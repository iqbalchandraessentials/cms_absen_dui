   {{-- Modal add Timeoff List  --}}
   <div class="modal fade" id="timeoffModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header" style="height: 50px">
                   <p>Create Daftar Cuti </p>
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                   <form method="post" action="{{ route('setting_time_off.store') }}" autocomplete="off" enctype="multipart/form-data">
                       @csrf
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="col">
                                       <div class="form-group">
                                           <label>Name</label>
                                           <input name="name" type="text" required class="form-control">
                                       </div>
                                   </div>
                                   <div class="col">
                                       <div class="form-group">
                                           <label>Code</label>
                                           <input type="text" name="code" class="form-control">
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col">
                                       <div class="form-group">
                                           <label>Duration</label>
                                           <input name="duration" type="number" class="form-control">
                                       </div>
                                   </div>
                                   <div class="col">
                                       <div class="form-group">
                                           <label>Attachment</label>
                                           <select id="attachment_mandatory" name="attachment_mandatory" required class="form-control">
                                               <option value="0">No</option>
                                               <option value="1">Yes</option>
                                           </select>
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
