<?php
include('lib/dbcon.php'); 
dbcon(); 
if(isset($_POST['save_perm'])){
$id=$_POST['selector'];

//$id = $_POST['module1'];
$userrole = $_POST['role1'];
$addrole = $_POST['perma']; $addupdate =$_POST['permb'] ; 
 $adddelete = $_POST['permc'] ; $addview = $_POST['permd'] ;
               
$N = count($id);
for($i=0; $i < $N; $i++)
{ 
mysqli_query($condb,"update role_rights set rr_create = '".safee($condb,gnum($addrole[$i]))."' , rr_edit ='".safee($condb,gnum($addupdate[$i]))."' , rr_delete ='".safee($condb,gnum($adddelete[$i]))."' , rr_view = '".safee($condb,gnum($addview[$i]))."' where rr_modulecode = '".safee($condb,$id[$i])."' and rr_rolecode='".safee($condb,$userrole[$i])."'"); //or die(mysqli_error($condb));

}
header("location:userPermission.php?view=Edit");
}


?>