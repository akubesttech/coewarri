<?php include('header.php');?>
 <?php 
                if(!isset($_GET['starts']))
{
  $starts=0;
}
else
{
  $starts=$_GET['starts'];
}
                ?>
<?php 
		//$user_query = mysql_query("select * from schoolsetuptd")or die(mysql_error());
												//	while($row = mysql_fetch_array($user_query)){
												//	$get_FormStatus = $row['RegNo'];
													//}
					$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
					switch ($view) {
                    case 'Program' :
		            $content    = 'Our_pro.php';		
		            break;
		            
		            case 'Dept' :
		            $content    = 'school_dept.php';		
		            break;
		            
	                default :
		           $content    = 'school_dept.php';
				     
                            }
                     require_once $content;
				
				?>
				
				
<?php include('footer.php'); ?>