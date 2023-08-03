   <?php $depart = $student_dept;
   $resultsec4 = mysqli_query(Database::$conn,"SELECT level_order,level_name FROM level_db where prog = '$student_prog'  ORDER BY level_order ASC limit 1");
$getminl = mysqli_fetch_array($resultsec4);  $getminlevel = $getminl['level_order'];
$level=$_GET['level'];
$semester= $_GET['semester'];
if(empty($_GET['session'])){ $secM = $default_session ;}else{ $secM = $_GET['session'] ;}
$roc = isset($_GET['chkroc']) ? $_GET['chkroc'] : '';
if(empty($roc)){ $faction = "Reg_course.php"; $mess = "Please Note that all Carryover courses must be Registered first before any other Course Registration."; 
if($level >= $student_level ||  $getminlevel < $student_level ){$ckn = "0";
}else{$ckn = "1";} }else{ $faction = ""; $ckn = "0"; $mess = "Please Select Appropriate Outstanding Course (s) to Register.";}
$sumcunit1 = 0;
$sumcunit2 = 0;
$sumcunit3 = 0;
$sumcunit4 = 0;
$glev = getlevel($level,$student_prog);
//&& $student_level !== $getminlevel
 ?>
   <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                  
                    <h2>Course Registration list:</h2>
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
                    </button>  <?php echo $mess; ?> 
                  </div>
             
                    <form action="<?php echo $faction; ?>" method="post">
                     <input type="hidden" name="nlevm" value="<?php echo $level;?> " />
                      <input type="hidden" name="session" value="<?php echo $secM;?> " />
                    <table id="datatable-button" class="table table-striped table-bordered">
                    <?php $queryprog = mysqli_query($condb,"SELECT * FROM level_db WHERE prog = '".safee($condb,$student_prog)."'  ORDER BY level_order ASC"); 
                    foreach($queryprog as $rolname){?>
                         	<a href="javascript:void(0);" 
                             class="btn btn-info addcourse"  id="delete2" data-placement="right" 
                             title="Click to Load Courses under this Level / Semeser " data-did="<?php echo $student_dept; ?>"  data-lid="<?php echo $rolname['level_order']; ?>" data-sid="<?php echo $semester; ?>"
                             data-reg="<?php echo $session_id; ?>" data-sec="<?php echo $default_sesid; ?> " data-lev="<?php echo $level; ?>"
                              ><i class="fa fa-plus user-profile-icon"></i>
                              <?php echo $rolname['level_name']." - ".$semester;?></a>
                                <?php } ?><a href="javascript:void(0);" 
                             class="btn btn-info addmore"  id="delete2" data-placement="right" 
                             title="Click to Load More Courses" data-did="<?php echo $student_dept; ?>"  data-lid="<?php echo $rolname['level_order']; ?>" data-sid="<?php echo $semester; ?>"
                             data-reg="<?php echo $session_id; ?>" data-sec="<?php echo $default_sesid; ?> " data-lev="<?php echo $level; ?>"
                              ><i class="fa fa-plus user-profile-icon"></i>
                              Add More Courses</a> <hr>
                    <?php if(empty($roc)){ ?>
                    	<a data-placement="top" title="Click to Register Selected Courses"   data-toggle="modal" href="#reg_course" id="delete"  class="btn btn-info" name=""  ><i class="fa fa-save icon-large"> Register Courses </i></a> <?php }else{ ?>
                        <button class="btn btn-info" name="outreg" title="Click to Register Selected Outstanding Courses" id="delete"><i class="fa fa-save icon-large"></i> Register Courses </button><?php } ?>

                    		<a href="#" onclick="window.open('course_manage.php?view=S_CO','_self')" class="btn btn-info"  id="delete2" data-placement="right" title="Click to Go back" ><i class="fa fa-backward icon-large"></i> Go back</a>
                     
									<script type="text/javascript">
									 $(document).ready(function(){
									 $('#delete').tooltip('show'); $('#delete1').tooltip('show'); $('#delete2').tooltip('show');
									 $('#delete').tooltip('hide'); 	 $('#delete1').tooltip('hide'); $('#delete2').tooltip('hide');
									 });
									</script>
										<?php include('modal_delete.php'); ?>
                 
        <div class="clear-float"></div>
<div id="shopping-cart">
<div class="txt-heading">Added Courses :: <?php echo strtoupper($glev." ".$semester." SEMESTER"); ?><a id="btnEmpty" class="cart-action" onClick="cartAction('empty','','','','','');" >Remove All Added Courses</a></div>
<div id="cart-item">

</div>
</div>            
                      
                      	</form>
                    </table>
                  </div>
                </div>
              </div>