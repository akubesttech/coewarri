<div>
<?php
include('lib/dbcon.php'); 
dbcon();
include('session.php');
 ?>
<table id="datatable-responsive mytable" class="table table-striped table-bordered">

              <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">      <?php   if (authorize($_SESSION["access3"]["rMan"]["vure"]["delete"])){ ?>
                  <a data-placement="top" title="Click to Delete check item"   data-toggle="modal" href="#delete_adminupresult" id="delete"  
                  class="btn btn-danger" name=""  ><i class="fa fa-trash icon-large"> Delete</i></a> <?php } ?> </div>
                    	&nbsp;&nbsp;&nbsp;  <!--	
								<a href="new_apply.php?view=imp_a" class="btn btn-info"  id="delete2" data-placement="right" title="Click to import Student UTME Exam Result" ><i class="fa fa-file icon-large"></i> Import Data</a> --!>
									<script type="text/javascript">
									 $(document).ready(function(){
									 $('#delete').tooltip('show'); $('#delete1').tooltip('show'); $('#delete2').tooltip('show');
									 $('#delete').tooltip('hide'); 	 $('#delete1').tooltip('hide'); $('#delete2').tooltip('hide');
									 });
									</script>
										<?php include('../admin/modal_delete.php'); ?>
                      <thead>
                        <tr>
                         <th><input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"></th>
                         <th>Course Code</th>
                          <th>Course Title</th>
                          <th><?php echo $SGdept1; ?></th>
                          <th>Session</th>
                          <th>Semester</th>
                          <th>Level</th>
                          <th>Date Uploaded</th>
                          <th>Uploaded By</th>
                         <th>View Info</th>
                        </tr>
                      </thead>
                      
                      
 <tbody>
                 <?php

$depart = $_GET['dept1'];
$couses = $_GET['cos'];
$sec = $_GET['sec'];
$sem = $_GET['sem'];
$level = $_GET['level'];

$queryup = "select * from uploadrecord where prog = '".safee($condb,$class_ID)."'   ";
if(!empty($depart)){$queryup .= " AND dept = '".safee($condb,$depart)."' "; }
if(!empty($couses)){$queryup .= " AND course = '".safee($condb,$couses)."' "; }
if(!empty($sec)){$queryup .= " AND session = '".safee($condb,$sec)."' "; }
if(!empty($sem)){$queryup .= " AND semester = '".safee($condb,$sem)."' "; }
if(!empty($level)){$queryup .= " AND level = '".safee($condb,$level)."' "; }
if ($Rorder > 2 ){$queryup .= " AND staff_id = '".safee($condb,$session_id)."'"; }
$queryup .= "ORDER BY up_id desc limit 0,500";
$viewupco=mysqli_query($condb,$queryup);
while($row_upfile = mysqli_fetch_array($viewupco)){
		$id = $row_upfile['up_id']; $scat = $row_upfile['scat'];
		$course_id = $row_upfile['course'];
?>     
<tr>
                        	<td width="30" >
<input id="optionsCheckbox" class="uniform_on1" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
												</td>
						<td><?php  echo $row_upfile['course']; ?></td>
                          <td><?php echo getcourse($row_upfile['course']); ?></td>
                          <td><?php echo getdeptc($row_upfile['dept']); ?></td>
                          <td><?php echo $row_upfile['session']; ?></td>
                          <td><?php echo $row_upfile['semester']; ?></td>
                          <td><?php echo getlevel($row_upfile['level'],$class_ID); ?></td>
                           <td><?php echo $row_upfile['date_up']; ?></td>
<td><?php if($scat > 1){ echo getstaff2($row_upfile['staff_id']); }elseif($scat == 1){echo getadmin2($row_upfile['staff_id']); }else{ echo "unknown staff" ;};
					//	}else{ echo getstaffr($row_upfile['staff_id']);}
					
							 ?></td>
                          
												<td width="90"><?php   if (authorize($_SESSION["access3"]["rMan"]["vure"]["view"])){ ?>
			<a rel="tooltip"  title="View Student Results For The selected Course <?php echo $row_upfile['course']; ?>" id="delete1" href="?view=v_ares&userId=<?php echo $id;?>" 	  data-toggle="modal" class="btn btn-info"><i class="fa fa-file icon-large"> View Result</i></a> <?php } ?>
												</td>
                        </tr>
                     
                     
                        <?php } ?>
                      </tbody>
                      
                      
                      	
                    </table>
</div>