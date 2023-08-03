<?php
session_start();
include('../admin/lib/dbcon.php'); 
dbcon();

 include('session.php'); 
if(isset($_REQUEST['q'])){
	$search = safee($condb,$_REQUEST['q']);
    $ssem = safee($condb,$_REQUEST['sem']);
}
$serial=1;
$viewutme_query = mysqli_query($condb,"SELECT * FROM courses WHERE dept_c='".$student_dept."' AND ( C_code = '$search' OR C_title LIKE '%$search%')  ")or die(mysqli_error($condb));
//$data = array();
while($row_utme = mysqli_fetch_array($viewutme_query)){
$id = $row_utme['C_id'];
//$ssem = $row_utme['semester'];
$lev = $row_utme['C_level'];
$Regn = getmatid($session_id);
$viewreg_query = mysqli_query($condb,"select * from coursereg_tb WHERE sregno = '".safee($condb,$Regn)."' AND session = '".safee($condb,$default_session)."'  AND course_id = '".safee($condb,$id)."' AND creg_status='1' AND semester = '".safee($condb,$ssem)."'")or die(mysqli_error($condb));
        if(mysqli_num_rows($viewreg_query)>0){ $status = 'Already Registered'; $rst = 'disabled';}else{ $status = 'Not Registered'; $rst = '';}
?>     
                        <tr>
 <td width="30"> <input id="optionsCheckbox" class="uniform_on1" name="selector[]" type="checkbox" value="<?php echo $id; ?>" checked></td>
											
											<td> <?php echo $row_utme['C_code']; ?><input type="hidden" id="sem_<?php echo $id; ?>" name="sem" value="<?php echo $ssem; ?>" size="10" /></td>
                                            <?php $in_session2 = "0";
				if(!empty($_SESSION["cart_item"])) {
					$session_code_array = array_keys($_SESSION["cart_item"]);
				    if(in_array($id,$session_code_array)) {
						$in_session2 = "1";
				    }
				}
			?>
                          <td><?php echo $row_utme['C_title']; ?> </td>
                          <td><?php echo $row_utme['C_unit']; ?></td>
                          <td><?php echo ($row_utme['c_cat'] == '1')? "C":"E" ;?></td>
                          <td><?php echo $status;?><input type="hidden" id="qty_<?php echo $id; ?>" name="prog" value="<?php echo $student_prog;?>" size="10" /></td>
          <td width="120">
            <input type="button" id="add_<?php echo $id; ?>" value="Add Course" class="btn btn-primary cart-action" <?php echo $rst; ?> onClick = "cartAction('add','<?php echo $id; ?>','<?php echo $session_id; ?>','<?php echo $default_sesid; ?>','<?php echo $student_dept; ?>','<?php echo $lev; ?>')"
              <?php if($in_session2 != "0") { ?>style="display:none" <?php } ?>  />
            <input type="button" id="added_<?php echo $id; ?>" value="Added" class="btn btn-info btnAdded" <?php if($in_session2 != "1") { ?>style="display:none" <?php } ?>  />
                            
</td>                
												
                        </tr>
                     
                     
                        <?php }  ?>
                        
                        