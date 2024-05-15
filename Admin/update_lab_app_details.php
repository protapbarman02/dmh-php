<?php $ROOT = "../";
require($ROOT . 'includes/db.inc.php');
require($ROOT . 'includes/functions.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $res = mysqli_query($con, "update lab_appointment set lab_app_time='{$_POST['time']}',lab_status='{$_POST['status']}' where lab_id={$_POST['lab_id']}");
  if (!$res) {
    echo "failed";
    exit();
  } else {
    echo "success";
    exit();
  }
}
