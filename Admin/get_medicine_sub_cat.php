<?php $ROOT="../";
require($ROOT."includes/db.inc.php");

$ct_id=$_POST['ct_id'];
$res=mysqli_query($con,"select * from medicine_sub_category where ct_id=$ct_id");
if(mysqli_num_rows($res)>0){
    while($row=mysqli_fetch_assoc($res)){
        echo "<option value='{$row['m_sc_id']}'>{$row['m_sc_name']}</option>";
    }
}
else{
    echo "<option value='1'>N/A</option>";
}
?>