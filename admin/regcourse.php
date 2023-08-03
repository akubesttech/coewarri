<?php  
 if(isset($_POST["employee_id"]))  
 {  
      $output = '';  
      include('lib/dbcon.php'); 
dbcon();
 
      $query = "SELECT * FROM coursereg_tb WHERE sregno = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($condb, $query);  $serial=1;
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">
		    <thead>
                        <tr>
                     <th><input type="checkbox" name="chkall3" id="chkall3" onclick="return checkall2(selector[]);" > </th>
                         <th>S/N</th>
                         <th>Course Code</th>
                         <th>Course Title</th>
                          <th>Credit Unit</th>
                         <th>Status</th>
                       </tr>
                      </thead>
		   ';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
<td ><input type="checkbox" name="selector3[]" id="optionsCheckbox2" class="selector3" checked="checked" value="'. $row['creg_id'].'" /></td>  
                     <td >'.$serial++ .'</td>
					 <td>'.$row["c_code"].'</td>
					 <td >'.getcourse($row["c_code"]).'</td>
					 <td >'.$row["c_unit"].'</td>
					 <td >'.$row["name"].'</td>  
                </tr>  
                  
                ';  
      }  
      $output .= "</table></div>";  
      echo $output;  
 }  
 ?>