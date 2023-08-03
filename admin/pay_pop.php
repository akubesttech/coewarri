
    <?php 
include('lib/dbcon.php'); 
dbcon();
include('session.php');
//if($_GET['nov'] > 10){ $ndown = "height:600px;";}else{$ndown = "";}

 ?> 
 <?php  $get_userid= isset($_GET['userId']) ? $_GET['userId'] : ''; 
$user_query = mysqli_query($condb,"select * from fshop_tb  where  form_id ='".safee($condb,$get_userid)."'")or die(mysqli_error($condb));
													$row_b = mysqli_fetch_array($user_query);
												   
$forderquery = mysqli_query($condb,"select fpay_status,fpamount from fshop_tb where fpay_status > 0 and fpamount > 0 and form_id ='$get_userid' ")or die(mysqli_error($condb));
$countpay = mysqli_num_rows($forderquery);
												
$user_query = mysqli_query($condb,"select * from payment_tb  where trans_id ='".safee($condb,$get_userid)."'")or die(mysqli_error($condb));
$row_b = mysqli_fetch_array($user_query); $student_num = $row_b['stud_reg']; $app_number = $row_b['app_no'];
 $feetype = $row_b['fee_type']; $existt = imgExists($row_b['teller_img']); $encryptid = md5($get_userid);
if(substr($feetype,0,1) == "B"){ $feet = getfeecat($row_b['ft_cat']);}else{ $feet = getftype($row_b['fee_type']);}

if(empty($student_num)){ 
$sql2 = "SELECT * FROM new_apply1 left join payment_tb ON payment_tb.app_no = new_apply1.appNo WHERE  appNo ='".safee($condb,$app_number)."' and md5(trans_id) ='".safee($condb,$encryptid)."' ";
}else{  $sql2 = "SELECT * FROM student_tb left join payment_tb ON payment_tb.stud_reg = student_tb.RegNo WHERE  stud_reg ='".safee($condb,$student_num)."' and md5(trans_id) ='".safee($condb,$encryptid)."' ";} 
if(!$qsql1=mysqli_query($condb,$sql2)) { echo mysqli_error($condb); } $rsprint1 = mysqli_fetch_array($qsql1);$feecategory = $rsprint1['ft_cat'];
$chot =  isset($rsprint1['course_choice']) ? $rsprint1['course_choice'] : ''; 	$facultyone = isset($rsprint1['Faculty']) ? $rsprint1['Faculty'] : ''; 
if($chot > 1){   $adep = isset($rsprint1['fact_2']) ? $rsprint1['fact_2'] : '';   $dept = isset($rsprint1['Second_Choice']) ? $rsprint1['Second_Choice'] : ''; 
}else{ $adep = isset($rsprint1['fact_1']) ? $rsprint1['fact_1'] : ''; $dept = isset($rsprint1['First_Choice']) ? $rsprint1['First_Choice'] : '';}                                                
                                                	?>              
 <div class="modal-header">
 <h4 class="modal-title" id="myModalLabel" style="text-shadow:-1px 1px 1px #000;"><font color='darkblue'>Student Payment Information </font>   </h4>
                        </div>

	<div class="modal-body" style="overflow:auto;height:350px;">
					<form method="post"  action="" enctype="multipart/form-data" >
						  
<div class="left col-xs-2" >
	
<table border="0" style="margin:2px; font-size:14px; font-family: Verdana;  width:800px;" class="tble"  >

<tr style="background-color:lightblue;box-shadow: 2px 2px gray;">
            <td height="36" colspan="6" style="color: #000080; font-size:16px;  font-family:  vandana;text-shadow: 1px 1px gray;"><strong>Basic Details:</strong></td>
          </tr>
          <tr style="border: 1px solid #98C1D1;"> <td style="font-weight: bold;height: 34px;" colspan="2"><?php
	if(empty($student_num)){echo "Application No : " .ucfirst($app_number);}else{
	 echo "Matric No : " .ucfirst($row_b['stud_reg']) ;}?> </td>
           <td style="font-weight: bold;">Full Name:</td><td  style="font-color:gray;  font-weight:normal; height: 34px;" colspan="3">
           <?php if(empty($student_num)){echo ucwords(getappname($app_number));}else{ echo ucwords(getname($row_b['stud_reg']));} ?></td>
         
         </tr>
          
          <tr style="border: 1px solid #98C1D1;"> <td style="font-weight: bold;"><?php echo $SCategory; ?>:</td><td  style="font-color:gray;  font-weight:normal; height: 34px;">
          <?php if(!empty($student_num)){ echo getfacultyc($facultyone);}else{ echo getfacultyc($adep); } ?> </td>
         <td height="30" style="font-weight: bold;"><?php echo $SGdept1; ?>: </td> <td style="font-color:gray;  font-weight:normal;"><?php if(empty($row_b['stud_reg'])){echo getdeptc($row_b['department']);}else{ echo getdeptc(getDep($row_b['stud_reg']));}?>
          </td>
           <td style="font-weight: bold;">Session:</td><td  style="font-color:gray;  font-weight:normal; height: 34px;">
            <?php echo $row_b['session'];?></td>
          </tr>
<tr style="background-color:lightblue;box-shadow: 2px 2px gray;">
          <td height="36" colspan="6" style="color: #000080; font-size:16px;  font-family:  vandana;text-shadow: 1px 1px gray;"><strong> Payment Details:</strong></td></tr>
<tr style="border: 1px solid #98C1D1;">
          <td style="font-weight: bold;">Transaction ID:</td>
          <td  style="font-color:gray;  font-weight:normal; height: 34px;"><?php echo $row_b['trans_id'] ;?></td>
         <td height="30" style="font-weight: bold;">Payment Type:</td>
          <td style="font-color:gray;  font-weight:normal;"> <?php echo $feet ;?> </td><td height="30" style="font-weight: bold;">Payment Mode:</td>
          <td style="font-color:gray;  font-weight:normal;"><?php echo $row_b['pay_mode'] ;?></td>
        </tr>
        <tr style="border: 1px solid #98C1D1;"><?php  if($row_b['pay_mode']=='Paycard'){?>
          <td style="font-weight: bold;">Bank Name:</td><td  style="font-color:gray;  font-weight:normal; height: 34px;"> <?php echo $row_b['bank_name'] ;?></td>
         <td height="30" style="font-weight: bold;">Teller No:</td>
          <td style="font-color:gray;  font-weight:normal;"> <?php echo $row_b['teller_no'] ;?> </td><td height="30" style="font-weight: bold;">Pin Used:</td>
          <td style="font-color:gray;  font-weight:normal;"><?php echo $row_b['pin'] ;?></td><?php } ?>
          <?php if($row_b['pay_status']=='1'){ ?>
          <td style="font-weight: bold;">Amount Paid:</td><td  style="font-color:gray;  font-weight:normal; height: 34px;"><span class='badge bg-green'><?php echo number_format($row_b['paid_amount'],2) ;?></span></td>
         <?php }else{ ?>
          <td style="font-weight: bold;">Due Amount:</td><td  style="font-color:gray;  font-weight:normal; height: 34px;"><span class='badge bg-green'><?php echo number_format($row_b['dueamount'],2) ;?></span></td>
<?php } ?>
         <td height="30" style="font-weight: bold;">Date of Payment:</td>
          <td style="font-color:gray;  font-weight:normal;"> <?php echo $row_b['pay_date'] ;?> </td>
          <td height="30" style="font-weight: bold;">Payment Status:</td>
          <td style="font-color:gray;  font-weight:normal;"><?php echo getpaystatus($row_b['pay_status']);//if($row_b['pay_status']=='1'){echo "Approved";}else{echo "Not Approved";} ;?> </td>
        </tr>

       <tr >
          <td height="36" colspan="6" style="color: #000080; font-size:16px;  font-family:  vandana;text-shadow: 1px 1px gray;position: inherit;">
          <div id="show2"><a class="btn btn-info" onclick="showDiv('welcomeDiv')" ><i class="fa fa-list"></i>&nbsp;Click to Show/ Hide Fee Components </a>
      <?php if ($existt > 0 ){?> <a class="btn btn-info" onclick="showDiv('welcomeDiv2')" ><i class="fa fa-list"></i>&nbsp;Click to view attachment </a> <?php } ?></div>
          </td></tr>
       
<tr >  <td colspan="6"  ><div class="menu2" style="display: none;" id="welcomeDiv"><table  border ="1" style="margin:5px; font-size:12px;  font-weight:bold; width:790px;">
 <thead><tr height="30" width="200" style="background-color:lightblue;box-shadow: 2px 2px gray;color: #000080;">
                         <th>S/N</th><th>Item</th>
                         <th> Description</th>
                          <th>Amount Paid</th></tr>
                      </thead><?php 
      $serial=1; $i = 0;
if(mysqli_num_rows($qsql1)==0){
        echo " <tr style=\"background-color:#CFF\">
          <td colspan=\"4\" height=\"30\">No payment Found For This Session</td> 
        </tr>"; }else{ //$rsprint1 = mysqli_fetch_array($qsql1);
		 $feetp = $rsprint1['fee_type']; $transession = $rsprint1['session']; $fcate = $rsprint1['ft_cat'];  ?>
     <?php if(substr($feetp,0,1) == "B"){ $paycomponent=mysqli_query($condb,"SELECT * FROM feecomp_tb  WHERE Batchno ='".safee($condb,$feetp)."' and pstatus = '1' ");
$serial=1;	$countp =	mysqli_num_rows($paycomponent) ;
while($row_utme = mysqli_fetch_array($paycomponent)){
    if ($i%2) {$classo1 = 'row1';} else {$classo1 = 'row2';}$i += 1;
$ftypecon = $row_utme['feetype']; $amount = $row_utme['f_amount'];
$paysession = $row_utme['session']; $feecategory = $row_utme['fcat']; $penalty = $row_utme['penalty']; if($penalty > 0){ $pens = " ( penalty inclusive).";}else{ $pens ="";} ?>
  <tr  class="<?php echo $classo1; ?>" align="center" height="30" width="30" > <td><?php echo $serial++; ?></td>
<td><?php echo getftype($ftypecon) ;?></td> <td><?php echo "Payment Of " .getftype($ftypecon)." For ".$transession ;?></td>
<td><?php echo number_format($amount,2); ?></td>   </tr> <?php	}}else{  ?>
	<tr  align="center" height="30" width="30" class="row1" > <td><?php echo $serial++; ?></td>
                      <td><?php echo getftype($feetp) ;?></td>
                        <td><?php echo "Payment Of " .getftype($feetp)." For ".$transession ;?></td>
                          <td><?php echo number_format($rsprint1['paid_amount'],2); ?></td>   </tr> <?php } if($countp > 0){ ?>
                        
    <tr class="row2" height="30"> <td colspan="3"><strong>Total Amount Paid:</strong></td>
<td align='center' ><strong><font color="green">&#8358;<?php echo number_format($rsprint1['paid_amount'],2); ?></font></strong></td></tr>
<tr class="row1"><td colspan="4" height="30" align='center' style="font-color:gray; font-weight:normal;"><strong>
<?php echo numtowords($rsprint1['paid_amount'])." Naira Only. "; ?></strong></td></tr>
 </table></div></td> </tr>
  	</form> 
  <?php } if ($existt > 0){?>
  <tr>  <td colspan="6"  ><div class="menu2" style="display: none;" id="welcomeDiv2">
<h4 style="text-shadow:-1px 1px 1px #000;">File Attachment:  </h4>
 <div class="zoomin2"> <img src="<?php   if ($existt > 0 ){print $row_b['teller_img'];}else{ print "payimg/attach.JPG";}?>" id="zoom" alt="Teller image atteched" class="img-rectangle" height="190" width="190" ></div>
<?php }}?> </td> </tr>
</table>

</div>
		</div>

					
				
				
           

<!-- end  Modal -->