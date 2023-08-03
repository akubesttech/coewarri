<div  >
 <?php 
 //error_reporting(E_ALL);
//ini_set('display_errors', 1);
 $i = 0; if ($i%2) {$classo = 'row1';} else {$classo = 'row2';}$i += 1;
 include('lib/dbcon.php'); 
dbcon();
include('session.php');
$baseaccoutcode = "GTB";
$querysch = mysqli_query($condb,"select * from schoolsetuptd ")or die(mysqli_error($condb));
							  $rowsch = mysqli_fetch_array($querysch);
							  $sinitial = $rowsch['initial'];
function getbank($get_dep,$type=0){ 
$query2_hod = mysqli_query(Database::$conn,"select * from bank where b_sort = '".trim($get_dep)."' ")or die(mysqli_error($condb));
$count_hod = mysqli_fetch_assoc($query2_hod);
 if($type == "1"){$nameclass22=$count_hod['acc_num'];}elseif($type == "2"){ 
 $nameclass22=$count_hod['b_code']; }else{ $nameclass22=$count_hod['acc_name'];}
return $nameclass22;}
                               
$amct = 0;
$ramm = 0;
$amper = 0 ;
$amper2 = 0;
$ntal = 0;
$ffamt = 0;
$finsamt = 0 ; $finst2 = 0;
$intallm = setinstallment ;
//total student
$stud_rec = mysqli_query($condb,"select * from student_tb WHERE app_type ='".safee($condb,$class_ID)."' and Asession = '".safee($condb,$default_session)."'")or die(mysqli_error($condb)); $stud_count = mysqli_num_rows($stud_rec);
//total student delta 
$stud_rec2 = mysqli_query($condb,"select * from student_tb WHERE app_type ='".safee($condb,$class_ID)."' AND Asession = '".safee($condb,$default_session)."' AND state = 'Delta' ")or die(mysqli_error($condb)); $stud_count2 = mysqli_num_rows($stud_rec2);   $nonIndigene = $stud_count - $stud_count2;
//no of level indigene
$nooflevel=mysqli_query($condb,"SELECT DISTINCT level FROM fee_db where  ft_cat = '1' and Cat_fee = '1' and  program ='".safee($condb,$class_ID)."' "); $clind = mysqli_num_rows($nooflevel);
//no of level noindigene
$noofleveln=mysqli_query($condb,"SELECT DISTINCT level FROM fee_db where  ft_cat = '1' and Cat_fee = '0'  and program ='".safee($condb,$class_ID)."' "); $clnind = mysqli_num_rows($noofleveln);

//Indigene
$qindigene=mysqli_query($condb,"SELECT  SUM(f_amount)as totalamounti  FROM fee_db where  ft_cat = '1' and Cat_fee = '1'  and program ='".safee($condb,$class_ID)."' "); 
$get_amountin = mysqli_fetch_array($qindigene);  if($clind > 0 ){$amountin = $get_amountin['totalamounti']/$clind;}else{ $amountin = $get_amountin['totalamounti'];} 
  $amountinet = $amountin ;
//Non Indigene
$qnon_indigene=mysqli_query($condb,"SELECT SUM(f_amount)as totalamountn FROM fee_db where  ft_cat = '1' and Cat_fee = '0'  and program ='".safee($condb,$class_ID)."' "); $get_amountnon = mysqli_fetch_array($qnon_indigene);  
if($clnind > 0 ){$amountnon = $get_amountnon['totalamountn']/$clnind;}else{ $amountnon = $get_amountnon['totalamountn']; }
$ramm = $amountinet + $amountnon ;
if(!empty($ramm)){  $amct = round($ramm / $intallm,0) ;  }
$amper  = 90 / 100 * $amct ;
$amper2  = 50 / 100 * $amct ;
function getnopaid($pro,$get_dep,$newDate,$newDate2,$amt,$ist=0,$fcat=0,$sec = 0) {
$amper  = 90 / 100 * $amt ;
$amper2  = 50 / 100 * $amt ;      
//$query2_hod = "select app_no,stud_reg from payment_tb where prog = '".safee(Database::$conn,$pro)."' AND  ft_cat = '$get_dep' AND pay_status = '1' AND pay_date BETWEEN '".safee(Database::$conn,$newDate)."' AND '".safee(Database::$conn,$newDate2)."'";
//if($ist =="1" && $get_dep == "1"){$query2_hod .= " AND  paid_amount > '".safee(Database::$conn,$amper)."' ";}
//if($ist =="2" && $get_dep == "1"){$query2_hod .= " AND  paid_amount > '".safee(Database::$conn,$amper2)."' ";}
//if($ist =="3" && $get_dep == "1"){$query2_hod .= " AND  paid_amount < '".safee(Database::$conn,$amper2)."' ";}
//if(($get_dep) == "4"){$query2_hod .= " ORDER BY app_no";}else{
//$query2_hod .= " ORDER BY stud_reg ";}
$query2_hod = "SELECT DISTINCT regno FROM feecomp_tb fc LEFT JOIN payment_tb pt ON pt.fee_type = fc.Batchno  WHERE pt.session = '".safee(Database::$conn,$sec)."' AND pt.prog = '".safee(Database::$conn,$pro)."' AND pt.pay_status = '1' AND pt.pay_date BETWEEN '".safee(Database::$conn,$newDate)."' AND '".safee(Database::$conn,$newDate2)."' ";   
if(strlen($get_dep) > 1){$query2_hod .= " AND fc.bcode = '".safee(Database::$conn,$get_dep)."' "; }
else{$query2_hod .= " AND fc.fcat = '".safee(Database::$conn,$fcat)."' ";}
if($ist =="1"){$query2_hod .= " AND  f_amount > '0' ";} //".safee(Database::$conn,$amper)."
//if($ist =="2"){$query2_hod .= " AND  f_amount > '".safee(Database::$conn,$amper2)."' ";}
//if($ist =="3"){$query2_hod .= " AND  f_amount < '".safee(Database::$conn,$amper2)."' ";}
$query2_hod .= " GROUP BY regno";
$qerynp = mysqli_query(Database::$conn,$query2_hod)or die(mysqli_error($condb));
$count_st1 = mysqli_num_rows($qerynp); 
$viewf_q = mysqli_query(Database::$conn,"select * from fshop_tb where  ftype = '".safee(Database::$conn,$pro)."'  AND fdate_paid BETWEEN '".safee(Database::$conn,$newDate)."' AND '".safee(Database::$conn,$newDate2)."' and fpay_status ='1' ")or die(mysqli_error($condb));
$count_st2 = mysqli_num_rows($viewf_q); if($ist == "4"){ return $count_st2;}else{return $count_st1;}
}

function getamtpaid($pro,$get_dep,$newDate,$newDate2,$amt,$ist=0,$fcat = 0,$sec = 0) {
$amper  = 0;//90 / 100 * $amt ;
$amper2  = 50 / 100 * $amt ;  $count_st1 = 0 ;  
//$query2_hod = "select SUM(paid_amount) AS amtpaid from payment_tb where prog = '".safee(Database::$conn,$pro)."' AND  ft_cat = '$get_dep' AND pay_status = '1' AND pay_date BETWEEN '".safee(Database::$conn,$newDate)."' AND '".safee(Database::$conn,$newDate2)."'";
//if($ist =="1" && $get_dep == "1"){$query2_hod .= " AND  paid_amount > '".safee(Database::$conn,$amper)."' ";}
//if($ist =="2" && $get_dep == "1"){$query2_hod .= " AND  paid_amount > '".safee(Database::$conn,$amper2)."' ";}
//if($ist =="3" && $get_dep == "1"){$query2_hod .= " AND  paid_amount < '".safee(Database::$conn,$amper2)."' ";}
//$query2_hod .= " GROUP BY ft_cat ";

$query2_hod = "SELECT SUM(f_amount) as amtpaid,bcode,fcat FROM feecomp_tb fc LEFT JOIN payment_tb pt ON pt.fee_type = fc.Batchno AND pt.ft_cat = fc.fcat WHERE pt.session = '".safee(Database::$conn,$sec)."' AND pt.prog = '".safee(Database::$conn,$pro)."' AND pt.pay_status = '1' AND pt.pay_date BETWEEN '".safee(Database::$conn,$newDate)."' AND '".safee(Database::$conn,$newDate2)."' ";   
if(strlen($get_dep) > 1){$query2_hod .= " AND fc.bcode = '".safee(Database::$conn,$get_dep)."' "; }
else{$query2_hod .= " AND fc.fcat = '".safee(Database::$conn,$fcat)."' ";}
if($ist =="1"){$query2_hod .= " AND  f_amount > '0' ";}
//if($ist =="2"){$query2_hod .= " AND  f_amount > '".safee(Database::$conn,$amper2)."' ";}
//if($ist =="3"){$query2_hod .= " AND  f_amount < '".safee(Database::$conn,$amper2)."' ";}
$query2_hod .= " GROUP BY fc.bcode,fcat";

$qerynp = mysqli_query(Database::$conn,$query2_hod)or die(mysqli_error($condb));
//$count_st1 = mysqli_fetch_assoc($qerynp);
while($paidmain = mysqli_fetch_array($qerynp)){ 
    $bamt = $paidmain['amtpaid'];
    $count_st1 = + $bamt ;
    } 
$viewf_q = mysqli_query(Database::$conn,"select SUM(fpamount) AS amtpaid2 from fshop_tb where  ftype = '".safee(Database::$conn,$pro)."'  AND fdate_paid BETWEEN '".safee(Database::$conn,$newDate)."' AND '".safee(Database::$conn,$newDate2)."' and fpay_status ='1' ")or die(mysqli_error($condb));
$count_st2 = mysqli_fetch_assoc($viewf_q); if($ist == "4"){ return $count_st2['amtpaid2'];}else{return $count_st1;}
}

$acctB = $_GET['bkey'];
$gdop = $_GET['ed2'];
$gdop2 = $_GET['ed3'];
$date = str_replace('/', '-', $_GET['ed2'] );
$newDate = date("Y-m-d", strtotime($date));
$date2 = str_replace('/', '-', $_GET['ed3'] );
$newDate2 = date("Y-m-d", strtotime($date2));
//$vquery = "select sum(paid_amount) as amtsum,ft_cat from payment_tb where prog = '".safee($condb,$class_ID)."' AND  pay_status = '1' AND pay_date BETWEEN '".safee($condb,$newDate)."' AND '".safee($condb,$newDate2)."' ";
//$vquery .= " GROUP BY ft_cat";

$vquery = "SELECT SUM(f_amount) as amtsum,bcode,fcat FROM feecomp_tb fc LEFT JOIN payment_tb pt ON pt.fee_type = fc.Batchno AND pt.ft_cat = fc.fcat WHERE pt.session = '".safee($condb,$default_session)."' AND pt.prog = '".safee($condb,$class_ID)."' AND pt.pay_status = '1' AND pt.pay_date BETWEEN '".safee($condb,$newDate)."' AND '".safee($condb,$newDate2)."' ";   
if(!empty($acctB)){$vquery .= " AND fc.bcode = '".safee($condb,$acctB)."' "; }
$vquery .= " GROUP BY fc.bcode,fcat";
$viewutme_query = mysqli_query(Database::$conn,$vquery) or die(mysqli_error(Database::$conn));


$viewutme_query = mysqli_query($condb,$vquery)or die(mysqli_error($condb));
$countvalue = mysqli_num_rows($viewutme_query);


$form =  getamtpaid($class_ID,"",$newDate,$newDate2,$amct,"",4,$default_session);
   $formc = getnopaid($class_ID,"",$newDate,$newDate2,$amct,"",4,$default_session);
   $fcom1 = getcomm("3") * $formc;
   $ffamt = $form - $fcom1 ;
   if(!empty($formc)){ $fc = 1 ;}else{ $fc = 0 ;}
  $finst1 = getamtpaid($class_ID,0,$newDate,$newDate2,$amct,"1","1",$default_session);
   //$insc1 = getnopaid($class_ID,"",$newDate,$newDate2,$amct,2,$default_session);
    $insc1 = getnopaid($class_ID,0,$newDate,$newDate2,$amct,"1","1",$default_session);
   $inscom1 = getcomm("1") * $insc1;
   $inscom2 = getcomm("1","1") * $insc1;
  $lostm = round((((300 * $insc1) + $finst1)* 1.5 / 100) - (300 * $insc1),0) ;
    $insfcom = ($inscom1 - $inscom2) - $lostm;
   //$finsamt = $finst1 - $insfcom;
   
   if(!empty($insc1)){ $fc1 = 1 ;}else{ $fc1 = 0 ;}
   $finst2 = getamtpaid($class_ID,"",$newDate,$newDate2,$amct,3,$default_session);
   $insc2 = getnopaid($class_ID,"",$newDate,$newDate2,$amct,3,$default_session);
   if(!empty($insc2)){ $fc2 = 1 ;}else{ $fc2 = 0 ;}
  ?>
  			    	  <table id="customers"> <div style="padding-bottom: 10px;">
                      <tr class="row1" style=" border-top: none;font-size: 15px;"><td colspan="6" >Payment Remittance Summary | <?php if($countvalue > 0){ echo " From :".$newDate." To :".$newDate2; } ?>
                        </td><br></tr>
                        <tr class="row1" style=" border-top: none;"><td colspan="6" >Total Number of Records:<?php echo $countvalue + $fc + $fc1 + $fc2; ?><br>
                        </td><br></tr>
                        
                    </div>  
                        
  <tr>
  <th>Receiving Bank Code </th>
  <th>Institution</th>
  <th>Item</th>
    <th>Account Number ( &#8358; )</th>
    <th>Acquiring Bank Code</th>
     <th>Total Amount</th>
   

  </tr>
<?php 
if($countvalue > 0){ while( $row = mysqli_fetch_array($viewutme_query)){ 
   $nums = getnopaid($class_ID,$row['bcode'],$newDate,$newDate2,$amct,"1",$row['fcat'],$default_session);
   $getcom1 = getcomm($row['fcat']) * $nums;
    $getcom2 = getcomm($row['fcat'],"1") * $nums;
     $retunpa = $getcom1 - $getcom2;
     $topay = getamtpaid($class_ID,$row['bcode'],$newDate,$newDate2,$amct,"1",$row['fcat'],$default_session);
   if($row['bcode'] == "ACCT_iynwlemltfs8cdy"){ $finalamt = $topay - $retunpa; }else{ $finalamt = $topay;}
  
    ?>
  <tr class="<?php echo $classo; ?>">
  <td><?php echo getbank($row['bcode'],2) ; if(empty($row['bcode'])){ if($class_ID == "4"){ echo "UBA";}else{ echo "Zenith Bank";  }}  ?></td>
  <td><?php echo $sinitial; ?></td>
  <td><?php echo getbank($row['bcode']); if(empty($row['bcode'])){if($class_ID == "4"){ echo " COEW TUITION AND OTHERS REGULAR NCE";}else{ echo "COEW TUITION AND OTHERS WKEND";}} 
  ?>
  </td>
  <td><?php echo getbank($row['bcode'],"1"); if(empty($row['bcode'])){ if($class_ID == "4"){ echo " 1021327880";}else{echo "1014900656";}}  ?></td>
  <td><?php echo $baseaccoutcode; ?></td>
   <td><?php echo $tal = number_format($finalamt,2);  ?></td>
  </tr>
  <?php $ntal += $finalamt; }}else{ ?>
   <tr class="row1"><td colspan="6" style="height: 32px;">No Remittance Record Found </td></tr>
  <?php }
  $lostm = round((((300 * $insc1) + $ntal)* 1.5 / 100) - (300 * $insc1),0) ;
    //$insfcom = ($inscom1 - $inscom2) - $lostm;
     $insfcom = ($getcom1 - $getcom2) - $lostm;
   ?>
  <!-- Application Sum -->
  <?php if(!empty($formc)){ ?>
  <tr class="<?php echo $classo; ?>">
  <td><?php echo getbank("","2");  ?></td>
  <td><?php echo $sinitial; ?></td>
  <td><?php echo getfeecat("3"); ?></td>
  <td><?php  echo getbank("","1"); ?></td>
  <td><?php echo $baseaccoutcode; ?></td>
   <td><?php echo $ftal = number_format($ffamt,2); ?></td>
  </tr> <?php } ?>
  
  <!-- First Instalment  Sum 
    <?php //if(!empty($insc1)){ ?>
  <tr class="<?php ///echo $classo; ?>">
  <td><?php //echo getbank("1","2");  ?></td>
  <td><?php //echo $sinitial; ?></td>
  <td><?php //echo getfeecat("1"); ?> 1st Instalment</td>
  <td><?php //echo getbank("1","1");  ?></td>
  <td><?php //echo $baseaccoutcode; ?></td>
   <td><?php  //echo $ital1 = number_format($finsamt,2); ?></td>
  </tr> <?php //} ?>  -->
  <!-- Second installment Sum -->
    <?php if(!empty($insc2)){ ?>
  <tr class="<?php echo $classo; ?>">
  <td><?php echo getbank("1","2");  ?></td>
  <td><?php echo $sinitial; ?></td>
  <td><?php echo getfeecat("1"); ?> 2st Instalment</td>
  <td><?php echo getbank("1","1");  ?></td>
  <td><?php echo $baseaccoutcode; ?></td>
   <td><?php  echo $ital2 = number_format($finst2,2); ?></td>
  </tr> <?php } ?>
  <!-- Smartcity Commisson  Sum --!>
    <?php if(!empty($insfcom)){ ?>
  <tr class="<?php echo $classo; ?>">
  <td><?php echo $baseaccoutcode ;  ?></td>
  <td><?php echo $sinitial; ?></td>
  <td><?php echo "SmartCity Commission"; ?></td>
  <td><?php echo "0526419248";  ?></td>
  <td><?php echo $baseaccoutcode; ?></td>
   <td><?php  echo $ital1 = number_format($insfcom,2); ?></td>
  </tr> <?php } ?> 
  <?php if($countvalue > 0){ $sumall = $ntal + $ffamt + $insfcom + $finst2 ; ?>
  <tr class="row1"><td colspan="6" style="height: 32px;"><?php //echo $number; ?></td></tr>
  <tr class="row2">
  <td colspan="5"><strong><b>Total Transaction Amount :</b></strong></td> <td><strong><b> &#8358; <?php echo number_format($sumall,2); ?></b></strong></td>
  </tr>
  <?php } ?>
   </table>
   </div>