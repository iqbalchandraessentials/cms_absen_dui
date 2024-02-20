 <div class="modal fade" id="exportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <form method="post" action="{{ route('export.timeoff') }}" enctype="multipart/form-data">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                 </div>
                 <div class="modal-body">
                     {{ csrf_field() }}
                     <div class="row">
                         <div class="col">
                             <label>Start Date</label>
                             <div class="input-group">
                                 <input type="text" required class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" name="start_date" data-date-autoclose="true" autocomplete="off">
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="icon-calender"></i></span>
                                 </div>
                             </div>
                         </div>
                         <div class="col">
                             <label>Untill Date</label>
                             <div class="input-group">
                                 <input type="text" required name="end_date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="icon-calender"></i></span>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-primary">Export</button>
                     </div>
                 </div>
         </form>
     </div>
 </div>
