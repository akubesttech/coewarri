
<?php  include('header.php'); ?>
<?php include('session.php'); ?>
	 <?php
 		$status = FALSE;
if ( authorize($_SESSION["access3"]["sTime"]["examt"]["create"]) || 
authorize($_SESSION["access3"]["sTime"]["examt"]["edit"]) || 
authorize($_SESSION["access3"]["sTime"]["examt"]["view"]) || 
authorize($_SESSION["access3"]["sTime"]["examt"]["delete"]) ) {
 $status = TRUE;
}
 ?>
		    	

 <?php include('admin_slidebar.php'); ?>
    <?php include('navbar.php');
    	if ($status === FALSE) {
message("You don't have the permission to access this page", "error");
		        redirect('./'); 
}
     ?>
  <?php $get_RegNo=  isset($_GET['id']) ? $_GET['id'] : '';
  $get_staff= isset($_GET['allot_id']) ? $_GET['allot_id'] : '';
  	
  ?>
    <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
          <div class="page-title">
<div class="title_left">
<h3>School Time Table Management
</h3>
</div>
</div><div class="clearfix"></div>
          

            <div class="row">
              <div class="col-md-12">
                
				 <!-- /Organization Setup Form -->
				
					<?php 
				/*	$num=$get_RegNo;
				if ($num!==null){
			include('editUser.php');
			}else{
			
				include('addlecturetime.php'); } */
                if (isset($_POST['delete_edate'])){
	 if(empty($class_ID)){
				message("No Programme Record Selected Yet,please select to continue", "error");
				redirect('lecture_time.php?view=letime');
			}elseif(empty($_POST['selector'])){
				message("Select at least one record to proceed !", "error");
		       redirect('lecture_time.php?view=letime');
				}else{ $id=$_POST['selector'];  $N = count($id);
for($i=0; $i < $N; $i++){
    $resultd = mysqli_query($condb,"DELETE FROM utmedate where id='$id[$i]'");
    message('Examination Schedule Successfully Deleted', 'success');
	redirect('lecture_time.php?view=letime'); }}}
				?>
				
                   <!-- /Organization Setup Form End -->
                 
                  
                  
                </div>
              </div>
            </div>



             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                 
                    <h2><!-- List Of Lecture Time Set --!>
					<?php if($class_ID > 0){ ?> <a href='javascript:void(0);' onclick="window.open('lecture_time.php?view=opro','_self')" style='color:blue;'>[Goto Select Programme] </a>   <?php echo " Selected Programme - "; }else{ echo " No Programme Selected ";}  ?><strong><?php echo getprog($class_ID); ?></strong>
					</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                  <?php 
						$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
					switch ($view) {
                	case 'l_add' :
		            $content    = 'addlecturetime.php';		
		            break;
                    case 'examt' :
		            $content    = 'addexamtime.php';		
		            break;
	                case 'load01' :
		            $content    = 'lt_list.php';		
		            break;
		            case 'load02' :
		            $content    = 'et_list.php';		
		            break;
                    
                    case 'etime' :
		            $content    = 'setutmetime.php';		
		            break;
		            case 'letime' :
		            $content    = 'utmetime.php';		
		            break;
		            
	                default :
		            //$content    = 'searchStud.php';
					$content    = 'olist.php';
                            }
                     require_once $content;
					?>

                    
                    
                  </div>
                </div>
              </div>



            
            
          </div>
        </div>
        <!-- /page content -->
        <?php 


        ?>
  
         <?php include('footer.php'); ?>