<?php //if($_GET['o_id'] != md5($_SESSION['emailp'])){
//echo "<script>window.location.assign('apply_b.php?view=ep_view');</script>";
//} 
 $sql_svery=mysqli_query($condb,"SELECT * FROM fshop_tb WHERE md5(ftrans_id ) ='".safee($condb,$_GET['txno'])."'");
$dform_checkexist2 = mysqli_num_rows($sql_svery);
if($dform_checkexist2 < 1){ message("The page you are trying to access is not Available.", "error");
redirect('apply_b.php?view=f_select'); }
$dform_get2 = mysqli_fetch_assoc($sql_svery); $ftranid = $dform_get2['ftrans_id']; $sname = $dform_get2['fsname'];$oname = $dform_get2['foname'];
$fullname = $sname." ".$oname; $feename = $dform_get2['feen'];
$femail = $dform_get2['femail']; $fphone = $dform_get2['fphone']; $ftype = $dform_get2['ftype'];$fsession = $dform_get2['session'];
$fcharge = $dform_get2['charge']; $famount  = $dform_get2['famount']; $dategen  = $dform_get2['dategen']; $tpayamt = $famount + $fcharge;
$transdate1 = $dform_get2['fdate_paid']; $orderPin = $feeinfo['pin'];$orderSerial = $feeinfo['serial'];

?>
   <section id="content" role="document">
        <main style="min-height: 168px;">
                    <div class="container">
                        

<div class="row">
    <div class="col-xs-12">
        <div id="breadcrumbs-share">
            <section id="breadcrumbs">
                <ul class="breadcrumb">
                                <li><a href="./">Home</a> </li>

                </ul>
            </section>
        </div>
    </div>
</div>
                    </div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-9 link-icons">
        <div  id="print_content">
            <div class="row">
                <div class="col-xs-12">
            <h3>Payment Status  </h3>
        </div>
        <div class="col-xs-12 primary-content link-icons">
<p class="first-paragraph"><font color="green" size="4"><i class='fa fa-check'></i> Your Pin Order was Successful,
Please Check Your email (inbox or spam) for the Pin Details.<br>Alternatively you can use your payment reference code to retrive your Pin
(Please keep your pin save).
</font></p>
                </div>
                
        <div class="margin-md-top row cards section-cards">
           <div class="col-xs-12">
           
            <div class="row nopadding nomargin" id="cards">
            
					<!-- form window  --!>	
	
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		 <h3 class="panel-title"><font size="4"><small>Payment Reference </small> ( <?php echo $ftranid; ?> )</font> </h3>
			    		
			 			</div>
			 			
			 			<div class="panel-body">
			    	<div id="center">

		<div class="inner_right_demo">
	<!--	<form name="register2" action="https://voguepay.com/pay/" method="post" enctype="multipart/form-data" id="register2"> --!>
	 <form name="register2" action="#" method="post" enctype="multipart/form-data" id="register2">
			<input type="hidden" name="insid" value="<?php echo $_SESSION['insid'];?> " />
			<input type='hidden' name='v_merchant_id' value='demo' /> <!-- 9919-0054594 --!>
			
			<input type='hidden' name='merchant_ref1' value='<?php echo $transref;?>' />
			<!--<input type='hidden' name='notify_url' value='http://www.ucnettechnologies.net/notification.php' />
            <input type='hidden' name='success_url' value='https://64.71.77.20/SOMA/studregprint.php' />
             <input type='hidden' name='fail_url' value='http://www.ucnettechnologies.net/failed.php' /> --!>
            <input type='hidden' name='emailx' value='<?php echo $payemail;?>' /> 
			<input type='hidden' name='total' value='<?php echo $amountdue ;?>' />
			<div class="form_box">
			 <div class="clear" style="overflow: auto;">
			 
        <table  border="1">
       
  <tr class="row2">
  <td width="20%" colspan="1" height="15"><strong> Full Name:</strong></td>
    <td width="31%" colspan="4"><?php echo $fullname;  //$_SESSION['snamef']." ".$_SESSION['oname']; ?></td>
    
    </tr>
    <tr class="row1">
  <td width="20%" colspan="1" height="20"><strong> Email:</strong></td>
    <td width="20%" colspan="1"><?php echo $femail ;// $_SESSION['emailp']; ?></td>
      <td width="20%" colspan="1" height="20"><strong> Mobile No:</strong></td>
    <td width="20%" colspan="1"><?php $fphonen = substr($fphone, 1,12); echo "+234".$fphonen ; //$_SESSION['mobile']; ?></td>
   </tr>
   <tr class="row2">
   <td width="20%" colspan="1" height="20"><strong> Payment Type:</strong></td>
    <td width="20%" colspan="1"><?php echo getftype($feename) ;// $_SESSION['emailp']; ?></td>
   <td width="20%" colspan="1" height="20"><strong> Academic Session:</strong></td>
    <td width="20%" colspan="1"><?php echo $fsession; ?></td> </tr>
   <tr class="row1">
    <td width="20%" colspan="1" height="20"><strong> Programme:</strong></td>
    <td width="20%" colspan="4"><?php echo getprog($ftype); //$_SESSION['ftype2']." Form" ;?></td>
   </tr>
 <tr class='row2' style="display:none;"> 
<td width='20%' colspan='2' height='20'><strong> Pin:</strong></td>
  <td width='20%' colspan='4' height='20'> <?php echo $orderPin; ?></td>
  </tr> <tr class='row1'style="display:none;"><td width='20%' colspan='2' height='20'><strong> Serial:</strong></td>
<td width='20%' colspan='4' height='20'> <?php echo $orderSerial; ?></td> </tr>
<tr class="row2">
    <td width="20%" colspan="1" height="20"><strong> Application Fee:</strong></td>
    <td width="20%" colspan="1">&#8358;<!--<strike>N</strike> --!><?php echo " ".number_format($famount,2); ?></td>
     <?php  if($fcharge > 0){?>
       <td width="20%" colspan="1" height="20"><strong> Commission:</strong></td>
    <td width="20%" colspan="1">&#8358;<?php echo " ".number_format($fcharge,2); ?></td>
    <?php }else{?>
     <td width="20%" colspan="1" height="20"><strong></strong></td>
    <td width="20%" colspan="1"></td>
     <?php }?>
   </tr>
    <tr class="row1">
      <td width="19%" height="20" colspan="1"><strong> Transaction Date:</strong></td>
      <td width="20%" colspan="3"><?php echo $transdate1; ?></td>
  </tr>
   
<tr class="row2">
  <td width="20%" colspan="2" height="20"><strong> </strong></td>
    
     <td width="20%" colspan="1" height="20"><strong> Total:</strong></td>
    <td width="20%" colspan="1" style="text-shadow: 1px 0px #0000FF; text-decoration-style: solid; font-weight: bold;">&#8358; <?php echo " ".number_format($tpayamt,2); //$_SESSION['mobile']; ?></td>
    </tr>
		
		<tr style="border-width: 0px;text-align:left;padding-top: 20px;">
           <td height="10" colspan="1"><div id="cccv" ><button name="Login_Reprint" class="btn btn-success" data-placement="right" type="submit" title="Click to Download Payment Slip" style="display:none;">Download Payment Slip</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   <button name="Login_Reprint" class="btn btn-success" onclick="window.open('apply_b.php?view=New','_self')" data-placement="right" type="button" title="Click to apply now">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apply Now&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
		   
		   </div></td>
            <td height="10" colspan="1"><div id="ccc2">&nbsp;&nbsp;&nbsp;<button name="Login_Reprint" class="btn btn-primary" data-placement="right" type="submit" title="Click to Print" onClick="return Clickheretoprint();" >Print</button></div>
	
			</td> 
          <td  height="10" colspan="3" id="ccc3">
          <img src="css/images/epaylogo.png" width="224" height="50"></a>
        </td>
          
          
        </tr>
		</table>
          
      </div>
	
			</div>
			</form>
		</div></div>
    
			    	</div>
	    		</div>
    	
    	
    
    	
    	
						
                </div>
                
                
            </div>
        </div></div>



            </div>
            
        </div>
        <div class="col-xs-12 col-md-3 sidebar-right margin-lg-bottom">
            <!-- right feature space -->
            
   <!-- <div class="apply-box">
        <a class="btn btn-default expand padding-md" href="https://applyalberta.ca/APAS.Web.Public/ApplicationServices/default.aspx?StartingAction=ApplyNow">APPLY NOW</a>
    </div> --!>

 <?php include("sidenews.php"); ?>
</div>
            
        </div>
    </div>
</div>


        </main>
    </section>
    
  