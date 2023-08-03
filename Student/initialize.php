<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

include('../admin/lib/dbcon.php'); 
dbcon(); 
$curl = curl_init();
$scom = getcomm($_POST['ft_cat'],0,$_POST['matno'],$_POST['sec']);
$scom2 = getcomm($_POST['ft_cat'],$_POST['ft_cat'],$_POST['matno'],$_POST['sec']);
$level = $_POST['lev']; $prog = $_POST['progM'];
$email = $_POST['emailx'];
$amountn = $_POST['total'] ;  //the amount in kobo. This value is actually NGN 300 for 30,000kobo
$amount =  getsplit($amountn,1.526,1.5,15,$scom,$scom2,3) * 100; //amount to pay
$amountcv =  getsplit($amountn,1.526,1.5,15,$scom,$scom2,3) ;  // transcharge 
$amountsa =  getsplit($amountn,1.526,1.5,15,$scom,$scom2,1) * 100;
$amountsb =  getsplit($amountn,1.526,1.5,15,$scom,$scom2,2) * 100;
$bassamount = getsplit($amountcv,1.51,1.5,15,$scom,$scom2,0) * 100;
//account defind
$dev_levey = t_ACCT_Dev ;
$ent_acct = t_ACCT_Ent ;
$tp_acct = t_ACCT_TP ;
$it_acct = t_ACCT_IT ;
$sug_acct = t_ACCT_SUG ;
$tech_acct = t_ACCT_TECH ;
$journal_acct = t_ACCT_JOU ;
//get payment to subaccounts
$dev = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$dev_levey) * 100;
$ent = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$ent_acct) * 100;
$tp = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$tp_acct) * 100;
$it = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$it_acct) * 100;
$sug = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$sug_acct) * 100;
$jour = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$journal_acct) * 100;
$tech1 = getsplintamt($level,$prog,$_POST['ft_cat'],$_POST['st_cat'],$_POST['sec'],$_POST['matno'],$tech_acct);
if(empty($tech1)){ $techm = 0;}else{ $techm = $tech1 - ($scom - $scom2);}
$tech =$techm * 100 ;
$spsum = ($dev + $ent + $tp + $it + $sug + $tech + $jour) ;
$sch_main_amt = $amountsa - $spsum ;
//get panalty account 
$penaltyacct = t_ACCTSP ; 
if($nprog == "4"){ $acctMain = t_ACCTS ; }elseif($nprog == "7"){ $acctMain = t_ACCTD ; }else{ $acctMain = t_ACCTP ;}
if(empty($scom) && ($_POST['ft_cat'] == "8") && !empty($penaltyacct)){$actno = t_ACCTSP ; }else{ $actno = $acctMain ; }
// url to go to after payment
$callback_url = host().'Student/callback.php';   
$urllogin = host().'Student/';
if(empty($scom) && empty($spsum) ){ 
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => "",
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 30,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
  //'bearer' => "subaccount",
    "reference" => $_POST['merchant_ref3'],
    'callback_url' => $callback_url,
    'subaccount' => $actno,//school account
    'transaction_charge' => $bassamount,
   ]),
CURLOPT_HTTPHEADER => [
    //"authorization: Bearer sk_test_07a04bc4d12ea7c4640ba82055729ff1175def5a", //replace this with your own test key
    "authorization: Bearer ".t_gate,
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));  
}else{
    curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => "",
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 30,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
    "reference" => $_POST['merchant_ref3'],
    'callback_url' => $callback_url,
    "split" => ([
      "type" => "flat",
      "bearer_type" => "account",
      "subaccounts" => [
                  [
                  "subaccount" => $acctMain,//school Main account
                  "share" => $sch_main_amt
                  ],
                  [
                  "subaccount" => t_ACCTB,//bisapp account
                  "share" => $amountsb
                  ],
                  [
                  "subaccount" => t_ACCT_Dev,//school acct Dev
                  "share" => $dev
                  ],
                  [
                  "subaccount" => t_ACCT_Ent,//school acct Ent
                  "share" => $ent
                  ],
                  [
                  "subaccount" => t_ACCT_TP,//school acct TP
                  "share" => $tp
                  ],
                  [
                  "subaccount" => t_ACCT_IT,//school acct IT
                  "share" => $it
                  ],
                  [
                  "subaccount" => t_ACCT_SUG,//school acct SUG
                  "share" => $sug
                  ],
                  [
                  "subaccount" => t_ACCT_JOU,//school acct Journals
                  "share" => $jour
                  ],
                  [
                  "subaccount" => t_ACCT_TECH,//school acct TECH
                  "share" => $tech
                  ],
                       ]
                   ]) ,
                  
                  ]),
CURLOPT_HTTPHEADER => [
    //"authorization: Bearer sk_test_07a04bc4d12ea7c4640ba82055729ff1175def5a", //replace this with your own test key
    "authorization: Bearer ".t_gate,
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));
    }


$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx->status){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
  print_r("<a href=".$urllogin."Spay_manage.php?view=a_p class='button' target='_self'><br>if this page still display after 30 sec ..<br> Click Here to <strong> GO Back </strong> to Initiate the Payment Again. </a></strong>"); 
}

// comment out this line if you want to redirect the user to the payment page
//print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
//header('Location: ' . $tranx['data']['authorization_url']);
redirect($tranx['data']['authorization_url']);


?>