

<style>img{width: 100%; max-width: 1363px;} </style>
<?php
//$str = "CSC 111";
//echo str_replace(" ","",$str);
//update stripAllSpacesDemo set Name=REPLACE(Name,' ','');
if(isset($_POST['import'])){
$levelm = $_POST['level'];
$sesm = $_POST['session'];
    		//check if input file is empty
    		if(!empty($_FILES['fileName']['name'])){
    			$filename = $_FILES['fileName']['tmp_name'];
    			$fileinfo = pathinfo($_FILES['fileName']['name']);
     //check file extension
    			if(strtolower($fileinfo['extension']) == 'csv'){
    				//check if file contains data
    				if($_FILES['fileName']['size'] > 0){
     $file = fopen($filename, 'r'); $flag = true;
while(($impData = fgetcsv($file, 1000, ',')) !== FALSE){ 
       $matno = trim($impData[0]);
$codenospace = str_replace(' ', '', $impData[2]);
 $Codem = trim($codenospace); 
 $depatment = getDep($matno);
 $semester = getcid($Codem,$depatment,$levelm,"1");
 $coursecode = getcid($Codem,$depatment,$levelm);
$studentpro = getstudentpro($impData[0]);
$recordData = ($impData[4] + $impData[5]);
$gradepoint  =  gradpoint($recordData,$studentpro);
$creditunit = ($impData[3]);
$resultcheck = mysqli_query($condb,"select * from student_tb where  RegNo= '".trim($impData[0])."' AND verify_Data = 'TRUE' ")or die(mysqli_error($condb)); 
if(mysqli_num_rows($resultcheck)>0){
 if($flag) { $flag = false; continue; }
 //$query = mysqli_query($condb,"INSERT INTO courses (dept_c,C_title,C_code,C_unit,semester,C_level,fac_id,c_cat) VALUES ('".safee($condb,$dept_c)."','".$impData[2]."', '".trim($impData[1])."', '".$impData[3]."','".$impData[4]."','".$impData[5]."','".safee($condb,$facadd)."','".$impData[6]."')")or die(mysqli_error($condb)); //$query = mysqli_query($condb,$sql);
   $queryex = mysqli_query($condb,"select * from results where  student_id= '".trim($impData[0])."' AND dept = '".$depatment."' AND course_id = '".$coursecode."' AND course_code = '".$Codem."' AND level = '".$levelm."' AND session = '".$sesm."' AND semester = '".$semester."' AND prog = '".$studentpro."' ");
   if(mysqli_num_rows($queryex)>0){
    //$import = "REPLACE INTO results (student_id,course_id,course_code,dept,level,session,semester,c_unit,assessment,exam,total,grade,gpoint,qpoint) VALUES ('".trim($impData[0])."','".$coursecode."','".$Codem."','".$depatment."','".$levelm."','".$sesm."','".$semester."', ".$impData[3].",".$impData[4].",'".$impData[5]."','".$recordData."','".grading($recordData,$studentpro)."','".gradpoint($recordData,$studentpro)."','".($gradepoint * $creditunit)."','".$studentpro."')";  
    $import = "UPDATE results SET session = '".$sesm."',c_unit = '".$impData[3]."',assessment = '".$impData[4]."',exam = '".$impData[5]."',total = '".$recordData."',grade = '".grading($recordData,$studentpro)."',gpoint = '".gradpoint($recordData,$studentpro)."',qpoint = '".($gradepoint * $creditunit)."' where student_id ='".trim($impData[0])."'  AND dept = '".$depatment."' AND prog = '".$studentpro."' AND course_id = '".$coursecode."' AND course_code = '".$Codem."'";
   $result = mysqli_query($condb,$import) or die (mysqli_error($condb));}else{
   $import = "INSERT INTO results (student_id,course_id,course_code,dept,level,session,semester,c_unit,assessment,exam,total,grade,gpoint,qpoint,prog) VALUES ('".trim($impData[0])."','".$coursecode."','".$Codem."','".$depatment."','".$levelm."','".$sesm."','".$semester."', ".$impData[3].",".$impData[4].",'".$impData[5]."','".$recordData."','".grading($recordData,$studentpro)."','".gradpoint($recordData,$studentpro)."','".($gradepoint * $creditunit)."','".$studentpro."')";  
    $result = mysqli_query($condb,$import) or die (mysqli_error($condb)); 
        }
   $countno = mysqli_num_rows($result); 
     if($result){
        $queryval = mysqli_query($condb,"select DISTINCT course_id,course_code,level,semester,dept,session,prog  from results where dept = '".$depatment."' AND course_id = '".$coursecode."' AND course_code = '".$Codem."' AND level = '".$levelm."' AND session = '".$sesm."' AND semester = '".$semester."' AND prog = '".$studentpro."' ")or die(mysqli_error($condb)); 
while($Getv = mysqli_fetch_array($queryval)){ 
mysqli_query($condb,"INSERT INTO uploadrecord (staff_id,course,session,semester,level,date_up,scat,dept,prog)
VALUES('".$session_id."','".$Getv['course_code']."','".$sesm."','".$Getv['semester']."','".$Getv['level']."',Now(),'".$admin_valid."','".$Getv['dept']."','".$Getv['prog']."')");
    }
        
		        redirect('Result_am.php?view=bupload');
    						}else{ message("Cannot import data. Something went wrong.", "error");
		        redirect('Result_am.php?view=bupload'); }  
    					}}
                        
                        redirect('Result_am.php?view=bupload');
                        message($countno." Result Was Successfully Upload.", "success");
                        }
    				else{ message("File contains empty data", "error");
		        redirect('Result_am.php?view=bupload');
    				}}else{ message("Please upload CSV files only", "error");
		        redirect('Result_am.php?view=bupload');}}else{
    			message("File empty", "error");
		        redirect('Result_am.php?view=bupload');}}
     
    	//else{ 	message("Please import a file first", "error");
		        //redirect('add_Courses.php?view=impc');
    //	} 
     
?>
<div class="x_panel">
                
             
                <div class="x_content">

                    		<form name="register" method="post" enctype="multipart/form-data" id="register">
<input type="hidden" name="insid" value="<?php echo $_SESSION['insid'];?> " />
                      
                      <span class="section">Upload Result in Batches</span>
                      <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
           Upload Result CSV file using this Excel Formate below. 
                  </div> 
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
<div id="patient_status"><img src="../assets/media/importbatch.png"  style="box-shadow:0 2px 4px 3px gray; font-size:15px; ;"  alt="Sample Of How the Excel Sheet will Look like"></div></div><br>
    
    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
    <label for="heard">Academic Session</label>
    <select name="session" id="session"  required="required" class="form-control">
  <option value="">Select Session</option><?php echo fill_sec(); ?></select></div>
  
<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
<label for="heard">Level</label>
<select class="form-control" name="level" id="level"  required="required">
<option>Select Level</option><?php 
$resultsec2 = mysqli_query($condb,"SELECT * FROM level_db where prog = '$class_ID'  ORDER BY level_order ASC");
while($rssec2 = mysqli_fetch_array($resultsec2)){ echo "<option value='$rssec2[level_order]'>$rssec2[level_name]</option>";	}
?></select></div>
 
 <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback"><label for="heard">Upload CSV file here: </label>
<input name="fileName" class="input-file uniform_on" id="fileInput" type="file" readonly="readonly" >
</div>
               <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                        
                        </div>
                      </div>
                    <div  class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback>
                        <div class="col-md-6 col-md-offset-3">
                         <?php   if (authorize($_SESSION["access3"]["rMan"]["rup"]["edit"])){ ?>  
                          <button type="submit" name="import"  id="import" data-placement="right" class="btn btn-primary col-md-4" title="Click To Import Student Details for Result Processing" ><i class="glyphicon glyphicon-upload"></i> Upload</button><?php } ?>   <?php   //if (authorize($_SESSION["access3"]["sConfig"]["avc"]["view"])){ ?> 
                        <button  name="goback"  id="goback" type='button' onClick="window.location.href='Result_am.php?view=aimp_re';" class="btn btn-primary " title="Click to go back" ><i class="fa fa-backward icon-large"></i> Go Back </button>
						<?php //} ?> 
                       <script type="text/javascript">
	                                            $(document).ready(function(){
	                                            $('#import').tooltip('show');
	                                            $('#import').tooltip('hide');
	                                            });
	                                            </script>
                       <div class='imgHolder2' id='imgHolder2'><img src='uploads/tabLoad.gif'></div></form>
                        </div></div>
									
                        
                        
                        
                        
                       </div> 
                 