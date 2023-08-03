<?php
include('lib/dbcon.php'); 
dbcon();

$request = $_POST['request'];   // request

// Get username list
if($request == 1){
    $search = $_POST['search'];
//$query = "SELECT * FROM student_tb WHERE RegNo like'%".$search."%' AND reg_status = '1' AND verify_Data = 'TRUE'";
$query = "SELECT * FROM student_tb WHERE RegNo = '".safee($condb,$search)."' AND reg_status = '1' AND verify_Data = 'TRUE'";
    $result = mysqli_query($condb,$query);
    
    while($row = mysqli_fetch_array($result) ){
        $response[] = array("value"=>$row['stud_id'],"label"=>$row['RegNo']);
    }

    // encoding array to json format
    echo json_encode($response);
    mysqli_close($condb);
}

// Get details
if($request == 2){
    $userid = $_POST['userid'];
    $sql = "SELECT * FROM student_tb WHERE stud_id=".$userid;

    $result = mysqli_query($condb,$sql);

    $users_arr = array();

    while( $row = mysqli_fetch_array($result) ){
        $userid = $row['stud_id'];
        $matno = trim($row['RegNo']);
        $firstname = $row['FirstName'];
        $lastname = $row['SecondName'];
        $faculty = $row['Faculty'];
        $dept1 = $row['Department'];
         $prog = $row['app_type'];
         $sec = $row['Asession'];
         $lev = $row['p_level'];
        $faculty2 = getfacultyc($row['Faculty']);
        $dept2 = getdeptc($row['Department']);
        $gender = $row['Gender'];
        $cgpa = getcgpa($matno,$prog,$sec,$lev);
    $users_arr[] = array("id" => $userid, "fname" => $firstname,"lname" => $lastname, "fac" =>$faculty, "dept1" =>$dept1, "cgpa" =>$cgpa,"fac2" =>$faculty2, "dept2" =>$dept2, "sex" =>$gender);
    }

    // encoding array to json format
    echo json_encode($users_arr);
   mysqli_close($condb);
}

// Get courses
if($request == 3){
    $depn = $_POST['dept'];
    $slev = $_POST['slev'];
    $ssem = $_POST['ssem'];
     $Regn = getmatid($_POST['reg']);
      $sec = getsecbyid($_POST['sec']);
    $sql = "SELECT * FROM courses WHERE dept_c='".$depn."' AND C_level = '".$slev."' AND semester = '".$ssem."' ";

    $result = mysqli_query($condb,$sql);
    $users_arr = array();
    while( $row = mysqli_fetch_array($result) ){
        $Cid = $row['C_id'];
        $viewreg_query = mysqli_query($condb,"select * from coursereg_tb WHERE sregno = '".safee($condb,$Regn)."' AND session = '".safee($condb,$sec)."'  AND course_id = '".safee($condb,$Cid)."' AND creg_status='1' AND semester = '".safee($condb,$ssem)."'")or die(mysqli_error($condb));
        if(mysqli_num_rows($viewreg_query)>0){ $status = 'Already Registered'; $rst = 'disabled';}else{ $status = 'Not Registered'; $rst = '';}
        $C_code = trim($row['C_code']);
        $C_title = $row['C_title'];
        $C_unit = $row['C_unit'];
        $c_cat = $row['c_cat'];
        	if($c_cat > 0){  $cstat = "checked"; $c_cat ="C" ;}else{  $cstat = ""; $c_cat ="E"; }
    $users_arr[] = array("C_id" => $Cid, "ccode" => $C_code,"ctitle" => $C_title, "cunit" =>$C_unit, "ccat" =>$c_cat, "csta" =>$status, "sec" =>$sec,"rst" =>$rst );
    }

    // encoding array to json format
    echo json_encode($users_arr);
   mysqli_close($condb);
}


?>