<?php
require '../includes/db.inc.php';

if (!isset($_SESSION['uid'])) {
 echo "not_logged_in";
 exit();
} else {
 if ((!isset($_POST['product_id'])) || (!isset($_POST['table']))) {
  echo "something_went_wrong";
  exit();
 } else {
  $patient_id = $_SESSION['uid'];
  $product_id = $_POST['product_id'];
  $productTable = $_POST['table'];

  $checkSql = "SELECT * FROM cart WHERE p_id = $patient_id AND c_product_table = '$productTable' AND c_product_id = $product_id";
  $checkResult = $con->query($checkSql);
  if ($checkResult->num_rows > 0) {
   echo "already there";
   exit();
  } else {
   $insertSql = "INSERT INTO cart (p_id, c_product_table, c_product_id, c_qty, c_added_at) VALUES ($patient_id, '$productTable', $product_id, 1, CURRENT_TIMESTAMP())";
   $con->query($insertSql);
   echo "success_cart_added";
   exit();
  }
 }
}
