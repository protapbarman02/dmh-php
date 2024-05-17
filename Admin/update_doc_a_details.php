<?php $ROOT = "../";
require($ROOT . 'includes/db.inc.php');
require($ROOT . 'includes/functions.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $res = mysqli_query($con, "update doc_appointment set doc_a_time='{$_POST['time']}',doc_a_status='{$_POST['status']}' where doc_a_id={$_POST['doc_a_id']}");
  if (!$res) {
    echo "failed";
    exit();
  } else {
    echo "success";
    exit();
  }
}
