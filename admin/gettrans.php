<?php
include('lib/dbcon.php'); 
dbcon();
// get student transcript search detail
if(isset($_REQUEST['matno'])){
 $tmatno = $_POST['matno'];
    $sql = "SELECT * FROM student_tb WHERE RegNo='".safee($condb,$tmatno)."'";
    $result = mysqli_query($condb,$sql); 
    $users_arr2 = array();
    while( $row = mysqli_fetch_array($result) ){
        $id = $row['RegNo'];
        $fullname = ucwords($row['FirstName']." ".$row['SecondName']." ".$row['Othername']);
        $fact = $row['Faculty'];
        $gdept = $row['Department'];
        $yoe = $row['yoe'];
        $acads = getAcastatus($row['acads']);
        $users_arr2[] = array("RegNo" => $id,"fullname" =>$fullname ,"facn" => $fact,"dept" => $gdept,"yoe" => $yoe,"acad" => $acads);
    }
// encoding array to json format
    echo json_encode($users_arr2);
    exit;
    } 
    
    if(isset($_REQUEST['searchuser'])){
 $staffuname = $_POST['searchuser'];
    $sql = "SELECT * FROM  staff_details WHERE usern_id='".safee($condb,$staffuname)."' OR phone='".safee($condb,$staffuname)."' OR email='".safee($condb,$staffuname)."'";
    $result = mysqli_query($condb,$sql); 
    $users_arr2 = array();
    while( $row = mysqli_fetch_array($result) ){
        $id = $row['usern_id'];
        $Surname = ucwords($row['sname']);
        $fname = ucwords($row['mname']);
        $email = $row['email'];
        $phone = $row['phone'];
        $post = $row['position'];
        $users_arr2[] = array("staff_uid" => $id,"s_name" =>$Surname ,"f_name" => $fname,"s_email" => $email,"s_mobile" => $phone,"post" => $post);
    }
// encoding array to json format
    echo json_encode($users_arr2);
    exit;
    }
    
    if(isset($_REQUEST['matno1'])){
        $staffuname2 = $_POST['matno1'];
   $sql = "SELECT * FROM student_tb WHERE RegNo='".safee($condb,$staffuname2)."'";
    $result = mysqli_query($condb,$sql); 
    $users_arr2 = array();
    
     while( $row = mysqli_fetch_array($result) ){
        $id = $row['RegNo']; $lev = $row['p_level'];
        $fullname = $row['FirstName']." ".$row['SecondName']." ".$row['Othername'];
        //$secondname = $row['SecondName'];
        //$othername = $row['Othername'];
        $faculty = $row['Faculty'];
        $dept1 = $row['Department'];
        $faculty2 = getfacultyc($row['Faculty']);
        $dept2 = getdeptc($row['Department']);$sec = $row['Asession'];
        $prog = $row['app_type']; $progn = getprog($row['app_type']); $scgpa = getcgpa($id,$prog,$sec,$lev); 
       $acads = getAcastatus($row['acads']); $acads2 = $row['acads'];
        $dog = $row['dog']; $comm = $row['comment']; 
    $users_arr2[] = array("RegNo" => $id, "fname" => $fullname, "fac" =>$faculty, "dept1" =>$dept1, "fac2" =>$faculty2, "dept2" =>$dept2,"prog" =>$prog, "progn" =>$progn,"scgpa" =>$scgpa,
    "comm" =>$comm, "sec" =>$sec, "acs" =>$acads,"dog" =>$dog, "acs2" =>$acads2);
    }
    //, "dept1" =>$dept1, "fac2" =>$faculty2, "dept2" =>$dept2,
     //"prog" =>$prog, "progn" =>$progn, "comm" =>$comm, "sec" =>$sec, "acs" =>$acads, "scgpa" =>$scgpa, "dog" =>$dog, "acs2" =>$acads2
// encoding array to json format
 echo json_encode($users_arr2);
   exit;
    }
    
     if(isset($_REQUEST['searchstaff'])){
 $staffuname3 = $_POST['searchstaff'];
    $sql = "SELECT * FROM  staff_details WHERE ( usern_id='".safee($condb,$staffuname3)."'  OR phone='".safee($condb,$staffuname3)."' OR email='".safee($condb,$staffuname3)."') AND access_level2 > 1  ";
    $result = mysqli_query($condb,$sql);  
    $users_arr2 = array();
   while( $row = mysqli_fetch_array($result) ){
        $checkcourse =  mysqli_query($condb,"select *  from course_allottb where assigned = '".safee($condb,$row['staff_id'])."'  AND a_lotstatus > 0 ");
        $Ccount = mysqli_num_rows($checkcourse);
        $id = $row['usern_id']; $actid = $row['staff_id'];
        $fullname = ucwords($row['sname'])." ".ucwords($row['mname'])." ".ucwords($row['oname']);
        $cos = $row['cos'];
        $heq = $row['heq'];
        $email = $row['email'];
        $post = $row['position'];
        $users_arr2[] = array("staff_uid" => $id,"s_idno" => $actid,"f_name" =>$fullname,"cos" => $cos,"heq" => $heq,"ccount" => $Ccount,"email" => $email,"post" => $post );
       // 
    }
// encoding array to json format
    echo json_encode($users_arr2);
    exit;
    }
    
    if(isset($_REQUEST['sregNo'])){
 $staffuname3 = $_POST['sregNo'];
    $sql = "SELECT * FROM  student_tb WHERE RegNo='".safee($condb,$staffuname3)."'";
    $result = mysqli_query($condb,$sql);  
    $users_arr2 = array();
   while( $row = mysqli_fetch_array($result) ){
      $id = $row['stud_id']; $actid = $row['RegNo'];
    $users_arr2[] = array("matid" => $id,"mstatus" => $actid );
       }
// encoding array to json format
    echo json_encode($users_arr2);
    exit;
    }
    
    // matno exemption for fees
    if(isset($_REQUEST['matnoex'])){
 $tmatnox = $_POST['matnoex'];
    $sql = "SELECT * FROM student_tb WHERE RegNo = '".safee($condb,$tmatnox)."' OR e_address = '".safee($condb,$tmatnox)."'";
    $result = mysqli_query($condb,$sql); 
    $users_arr2 = array();
    while( $row = mysqli_fetch_array($result) ){
        $id = $row['RegNo']; $actid = $row['RegNo']; $level = getlevel($row['p_level'],$row['app_type']);
        $fullname = ucwords($row['FirstName']." ".$row['SecondName']." ".$row['Othername'])." (".$level.")";
       $users_arr2[] = array("Regm" => $id,"Reg2" => $actid,"fullname" =>$fullname);
    }
// encoding array to json format
    echo json_encode($users_arr2);
    exit;
    } 
?>