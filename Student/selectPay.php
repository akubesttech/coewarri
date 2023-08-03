<div class="x_panel">
<div class="x_content">
	                <form method="POST" class="form-horizontal"  action="Spay_manage.php?view=a_p" enctype="multipart/form-data">
                   <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                      <span class="section">Select Payment</span>
                     <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button> Please Select Approprate information to Continue. </div>
                     <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
						  	  <label for="heard">Level</label>
                            	  <select  class="form-control " name='level' id="level"  required="required" >
                                 <option value="">Select Level</option><?php 
$resultsec2 = mysqli_query($condb,"SELECT * FROM level_db WHERE prog = '".safee($condb,$student_prog)."' ORDER BY level_order ASC");
while($rssec2 = mysqli_fetch_array($resultsec2))
{ echo "<option value='$rssec2[level_order]'>$rssec2[level_name]</option>";	}?>	
</select>
                      </div>
                       <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                       
						  	  <label for="heard">Academic Session</label>
                            <select name="session" id="session"  required="required" class="form-control">
  <option value="">Select Session</option>
<?php echo fill_sec(); ?></select></div>

 
                      <div  class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <div class="col-md-6 col-md-offset-3"> 
                        <button type="submit" name="selpay"  id="save" data-placement="right" class="btn btn-primary" title="Click to Continue to Load Payment Breakdown" ><i class="fa fa-sign-in"></i> Continue</button>
                        
                        <script type="text/javascript">
	                                            $(document).ready(function(){
	                                            $('#save').tooltip('show');
	                                            $('#save').tooltip('hide');
	                                            });
	                                            </script>
	                                            <div class='imgHolder2' id='imgHolder2'><img src='../admin/uploads/tabLoad.gif'></div>
                        </div>
                        
                      </div>
                    </form>
                    
                    
                    
                  </div>
                  