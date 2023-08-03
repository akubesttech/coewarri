<?php

session_start();
//require_once("dbcontroller.php");
//$db_handle = new DBController();
include('lib/dbcon.php'); 
dbcon();

//$coursid = $_POST['code'];
if(!empty($_POST["action"])) {
    switch($_POST["action"]) {
        case "add":
		if(!empty($_POST["prog"])) {
	$_SESSION["regno"] = $_POST["regno"];
   $_SESSION["prog"] = $_POST["prog"];
  $_SESSION["dep"] = $_POST["dep"];
  $_SESSION["sem"] = $_POST["sem"];
		$sql = "SELECT * FROM courses WHERE C_id='".safee($condb,$_POST["code"])."' Order by C_id ASC ";
    $result = mysqli_query($condb,$sql);
    while($row = mysqli_fetch_assoc($result)) {
			$productByCode[] = $row; //$semd = $productByCode[0]["semester"];
             $itemArray = array($productByCode[0]["C_id"]=>array('C_id'=>$productByCode[0]["C_id"],'C_code'=>$productByCode[0]["C_code"], 'title'=>$productByCode[0]["C_title"], 'prog'=>$_POST["prog"], 'unit'=>$productByCode[0]["C_unit"],
    'semester'=>$productByCode[0]["semester"], 'level'=>$_POST["lev"], 'ccat'=>$productByCode[0]["c_cat"],'regno1'=>$_POST["regno"], 'sec1'=>$_POST["secm"],
    'dep'=>$_POST["dep"]
    ));
		} 
  
  if(!empty($_SESSION["cart_item"])) {
    $cartCodeArray = array_keys($_SESSION["cart_item"]);
				if(in_array($productByCode[0]["C_id"],$cartCodeArray)) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["C_id"] == $k)
								$_SESSION["cart_item"][$k]["prog"] = $_POST["prog"];
                                
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
              
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
		  	  $cartCodeArray = array_keys($_SESSION["cart_item"]);
		  if(in_array($_POST["code"],$cartCodeArray)) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_POST["code"] == $k)
                    unset($_SESSION["cart_item"][$k]);
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
            }
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;		
}
}
?>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
    $sumcunit1 = 0;

?>	
<table cellpadding="10" cellspacing="1">
<tbody>
  <tr > <th><input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"></th> 
                         <th>Course Code</th>
                         <th>Course Title</th>
                          <th>Credit Unit</th>
                          <th>Semester</th>
                          <th>Level</th>
                          <th>Course Status</th>
                         <th>Registration Status</th>
                            <th>Remark</th>
                         </tr>
      <!--  Carryover Courses  start --!>                  
                                 <?php 
                             
$regm = getmatid($_SESSION["regno"]);  
$sql_gradesetl = mysqli_query($condb,"select * from grade_tb where prog ='".safee($condb,$_SESSION['prog'])."' and grade_group ='01' Order by b_max ASC limit 1 ")or die(mysqli_error($condb)); $getmg2 = mysqli_fetch_array($sql_gradesetl);   $getpassl = $getmg2['b_max'];
$sql1="select * from results where  total <= '".safee($condb,$getpassl)."' and student_id='".safee($condb,$regm)."' and semester = '".safee($condb,$_SESSION["sem"])."'";
$result1=mysqli_query($condb,$sql1) or die("Could not access table".mysqli_error($condb));
while($row1=mysqli_fetch_array($result1)){ 
$viewreg_query1 = mysqli_query($condb,"select * from coursereg_tb WHERE sregno = '".safee($condb,$regm)."' AND creg_status='1' AND semester = '".safee($condb,$_SESSION["sem"])."' AND course_id = '".safee($condb,$row1['course_id'])."' ")or die(mysqli_error($condb)); 
if(mysqli_num_rows($viewreg_query1)>0){ $status2 = 'Already Registered';  $enebles = "disabled"; }else{ $status2 = 'Not Registered'; $enebles = ""; }
$result3=mysqli_query($condb,"select * from courses where dept_c = '".safee($condb,$_SESSION['dep'])."' AND semester = '".safee($condb,$_SESSION["sem"])."' AND C_id = '".safee($condb,$row1['course_id'])."' ") or die(mysqli_error($condb));
if(mysqli_num_rows($result3)>0){ $row_utme3 = mysqli_fetch_array($result3); ?>
<tr> <td width="30"><input id="optionsCheckbox" class="uniform_on1" name="selector[]" type="checkbox" payamt="<?php echo $row_utme3['C_unit']; ?>" value="<?php echo $row_utme3['C_id']; ?>" CHECKED="CHECKED" <?php echo $enebles; ?> >
	</td><td><?php echo "<font color='red'>$row_utme3[C_code]</font>"; ?></td>
					 <td><?php echo $row_utme3['C_title']; ?></td>
                          <td><?php echo $row_utme3['C_unit']; ?></td>
                          <td><?php echo $row_utme3['semester']; ?></td>
                          <td><?php echo getlevel($row_utme3['C_level'],$_SESSION['prog']); ?></td>
                          <td>-------</td>
<td> <?php echo $status2; ?> </td> <td>Carryover</td></tr> <?php }else{echo ".";}
$sumcunit1 += $row_utme3['C_unit'];
 
 } 
 
 
 
		?>     
    <!--  Carryover Courses  end --!>                   
     <?php	
    
    foreach ($_SESSION["cart_item"] as $item){
       $glev = getlevel($item['level'],$item['prog']);
        $coursstatus = $item['ccat'];
       $Regn = getmatid($item['regno1']);  $sec = getsecbyid($item['sec1']);
        if($coursstatus > 0){  $cstat = "checked"; $cstat2 ="C" ;}else{  $cstat = ""; $cstat2 ="E"; }
         $viewreg_q = mysqli_query($condb,"select * from coursereg_tb WHERE sregno = '".safee($condb,$Regn)."' AND session = '".safee($condb,$sec)."'  AND course_id = '".safee($condb,$item['C_id'])."' AND creg_status='1' AND semester = '".safee($condb,$item['semester'])."'")or die(mysqli_error($condb));
        if(mysqli_num_rows($viewreg_q)>0){ $status = 'Already Registered';}else{ $status = 'Not Registered';}
        
                ?>        
				<tr class="wrapm_<?php echo $item["C_id"]; ?>">
               <td><input id="optionsCheckbox" class="uniform_on1" name="selector[]" type="checkbox" payamt="<?php echo $item['unit']; ?>" CHECKED="CHECKED"  value="<?php echo $item['C_id']; ?>">
                </td>
				<td><strong><?php echo $item["C_code"]; ?></strong></td>
   	            <td><strong><?php echo $item["title"]; ?></strong></td>
   	            <td><strong><?php echo $item["unit"]; ?></strong></td>
   	           <td><strong><?php echo $item['semester']; ?></strong></td>
				<td><?php echo $glev; ?></td> 
                <!-- <td> <select name='sem[]<?php //echo $item['C_id']; ?>' id="sem" class="form-control" >
                          <?php echo getSem($item['semester']);?></select></td>
                          
                          <td><select name='level[]<?php //echo $item['C_id']; ?>' id="level" class="form-control" >
                           <option value="<?php echo $item['level']; ?>" selected="selected"><?php echo $glev; ?></option>
                                             <?php echo getRlev($item['prog']); ?>  </select> 
                                             </td> --!>
				<td><?php echo $cstat2; ?></td>
				<td align=right><?php echo $status; ?></td>
				<td><a href="javascript:void(0);" id="rem_<?php echo $item["C_id"]; ?>" onClick="cartAction('remove','<?php echo $item["C_id"]; ?>','','','','')" class="cart-action btn btn-danger">Remove Course</a></td>
				</tr>
				<?php
        $item_total += ($item["unit"]);
		}
		?>

<tr>
<td colspan="9" align=right><strong>Total:</strong> <?php echo $item_total + $sumcunit1 ; ?></td>
</tr>

</tbody>
</table>		
  <?php
}
?>