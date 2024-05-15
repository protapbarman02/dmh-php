<?php $ROOT = '../';
require($ROOT . "includes/db.inc.php");
require($ROOT . "includes/functions.php");
if (!isset($_POST['type'])) {
  echo "type is not set";
  exit();
}
$result = mysqli_query($con, "SELECT lab_app_date, COUNT(*) AS count FROM `lab_appointment` GROUP BY lab_app_date ORDER BY lab_app_date DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
$last_appointment_date = $row['lab_app_date'];
$count = $row['count'];
if ($count < 20) {
  $lab_app_date = $last_appointment_date;
} else if ($count == 20) {
  $lab_app_date = date('Y-m-d', strtotime($last_appointment_date . ' +1 day'));
}
$price = $_POST['price'];

$res = mysqli_query($con, "select p_phn,p_email from patient where p_id={$_SESSION['uid']}");
$row = mysqli_fetch_assoc($res);
$email = $row['p_email'];
$phn = $row['p_phn'];

if ($_POST['type'] == 'test') {
  if (isset($_SESSION['test']) && !empty($_SESSION['test'])) {
    $res = mysqli_query($con, "INSERT INTO `lab_appointment` (`p_id`,`lab_app_date`, `p_phn`, `p_email`, `lab_fee`,`lab_type`, `lab_create_time`) VALUES ({$_SESSION['uid']}, '$lab_app_date','$phn', '$email', '$price', '{$_POST['type']}',CURRENT_TIMESTAMP())");
    if ($res) {
      $insert_id = mysqli_insert_id($con);
      foreach ($_SESSION['test'] as $test) {
        $t_id = $test['t_id'];
        $price = $test['t_final_fee'];
        $res2 = mysqli_query($con, "INSERT INTO `lab_app_details` (`lab_id`, `p_id`, `lab_d_product_id`, `lab_d_product_type`, `lab_d_product_price`) VALUES ($insert_id, {$_SESSION['uid']}, $t_id, 'test', $price)");
        if ($res2) {
          $res3 = mysqli_query($con, "DELETE FROM cart WHERE `cart`.`c_product_id` = $t_id and `cart`.`p_id`={$_SESSION['uid']} and `cart`.`c_product_table`='test'");
          if (!$res3) {
            echo "cart delete failed";
            exit();
          }
        } else {
          echo "appointment details upload failed";
          exit();
        }
      }
    } else {
      echo "appointment upload failed";
      exit();
    }
    echo "done";
    exit();
  }
}
if ($_POST['type'] == 'package') {
  if (isset($_SESSION['package']) && !empty($_SESSION['package'])) {
    $res = mysqli_query($con, "INSERT INTO `lab_appointment` (`p_id`,`lab_app_date`, `p_phn`, `p_email`, `lab_fee`,`lab_type`, `lab_create_time`) VALUES ({$_SESSION['uid']}, '$lab_app_date','$phn', '$email', '$price', '{$_POST['type']}', CURRENT_TIMESTAMP())");
    if ($res) {
      $insert_id = mysqli_insert_id($con);
      foreach ($_SESSION['package'] as $package) {
        $pk_id = $package['pk_id'];
        $price = $package['pk_pay_fee'];
        $res2 = mysqli_query($con, "INSERT INTO `lab_app_details` (`lab_id`, `p_id`, `lab_d_product_id`, `lab_d_product_type`, `lab_d_product_price`) VALUES ($insert_id, {$_SESSION['uid']}, $pk_id, 'package', $price)");
        if ($res2) {
          $res3 = mysqli_query($con, "DELETE FROM cart WHERE `cart`.`c_product_id` = $pk_id and `cart`.`p_id`={$_SESSION['uid']} and `cart`.`c_product_table`='package'");
          if (!$res3) {
            echo "cart delete failed";
            exit();
          }
        } else {
          echo "appointment details upload failed";
          exit();
        }
      }
    } else {
      echo "appointment upload failed";
      exit();
    }
    echo "done";
  }
}
