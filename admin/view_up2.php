 <?php $status = FALSE;
if ( authorize($_SESSION["access3"]["rMan"]["vure"]["create"]) || 
authorize($_SESSION["access3"]["rMan"]["vure"]["edit"]) || 
authorize($_SESSION["access3"]["rMan"]["vure"]["view"]) || 
authorize($_SESSION["access3"]["rMan"]["vure"]["delete"]) ) {
 $status = TRUE;
}
if ($status === FALSE) {
//die("You dont have the permission to access this page");
message("You don't have the permission to access this page", "error");
		        redirect('./'); 
}
  ?>
  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                  
                    <h2>List of Uploaded Results</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                    <p class="text-muted font-13 m-b-30">
                  
                    </p>
                  <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
        This page will Enable you to View / Delete Wrongly uploaded Result. <?php //echo $admin_valid ; datatable-buttons ?>
                  </div>
                  <div> <table><form action="" method="post">
   <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                       <label for="heard"><?php echo $SGdept1; ?></label>
                            	  <select name="dept1" id="dept1" required="required"  class="form-control"  >
                           <option value="">Select <?php echo $SGdept1; ?></option>
                              <?php $querydep = mysqli_query($condb,"SELECT * FROM dept ORDER BY d_name ASC");
while($depart = mysqli_fetch_array($querydep)){echo "<option value='$depart[dept_id]'>$depart[d_name]</option>";	}?>
                          </select>
                      </div>
                      
                      <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                       <label for="heard">Course Code</label>
                            	  <select name="cos" id="cos" required="required" class="form-control"  >
                           <option value="">Select Courses</option>
                           <?php $qcourse = mysqli_query($condb,"SELECT DISTINCT course_code FROM results ORDER BY course_code ASC");
while($courseup = mysqli_fetch_array($qcourse)){echo "<option value='$courseup[course_code]'>$courseup[course_code]</option>";	}?>
                          </select>
                      </div>
                      
<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                       <label for="heard">Academic Session</label>
                            <select name="sec" id="sec"  required="required" class="form-control">
  <option value="">Select..</option><?php echo fill_sec(); ?>
</select></div>
                      
                      <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
						  	  <label for="heard">Semester</label>
                            	  	 <select class="form-control" name="sem" id="sem"  required="required">
<option value="">Select..</option>
<option value="First">First</option>
<option value="Second">Second</option></select>
                      </div>
                      
                      	   <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
						  	  <label for="heard">Level</label>
                            	  	 <select class="form-control" name="level" id="level"  required="required">
<option value="">Select..</option>
<?php $resultsec2 = mysqli_query($condb,"SELECT * FROM level_db where prog = '$class_ID'  ORDER BY level_order ASC");
while($rssec2 = mysqli_fetch_array($resultsec2)){echo "<option value='$rssec2[level_order]'>$rssec2[level_name]</option>";	}?>
 </select>
                      </div>
                        <div  class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" ><div id="cccv2" >
 <?php   if (authorize($_SESSION["access3"]["rMan"]["vure"]["view"])){ ?> 
    <button   name="uploadedresults" id="uploadedresults"  type="button" onclick = 'ajaxUploadedResults()'  class="btn btn-primary " title="Click to Search Uploaded Results" ><i class="fa fa-search"></i> Search  </button> 
   
   <script type="text/javascript">$(document).ready(function(){
	                                            $('#searchrem').tooltip('show');
	                                            $('#searchrem').tooltip('hide');
	                                            });     </script> <?php } ?><hr/>
                                                
  </div></div>
  </form>                    
</table>
                  </div>
                  
<form action="Delete_adminupresult.php" method="post">
                   <div style="width: 100%;" style="overflow: auto;" id = 'ajaxDivn'>

                    
                    </div>
                    
                      	</form>
                    
                    
                  </div>
                </div>
              </div>