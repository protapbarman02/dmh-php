<?php
require('includes/db.inc.php');
$type = $_POST['type'];
$email = $_POST['email'];
if ($type == "sign") {
  $phn = $_POST['phn'];
  $stmt = $con->prepare("SELECT * FROM `patient` WHERE `patient`.`p_email`=? and p_status=1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $rowCount = $result->num_rows;
  if ($rowCount > 0) {
    echo "email_present";
    die();
  } else {
    $stmt = $con->prepare("SELECT * FROM `patient` WHERE `patient`.`p_phn`=? and p_status=1");
    $stmt->bind_param("s", $phn);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowCount = $result->num_rows;
    if ($rowCount > 0) {
      echo "phn_present";
      die();
    } else {
      $otp = substr(md5(rand(111111, 999999)), 10, 4);
      $_SESSION['EMAIL_OTP'] = $otp;
      $html = "$otp is your otp";
      include('smtp/PHPMailerAutoload.php');
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587;
      $mail->SMTPSecure = "tls";
      $mail->SMTPAuth = true;
      $mail->Username = "protapb303@gmail.com";
      $mail->Password = "xkhyqhqyixfmcspm";
      $mail->SetFrom("protapb303@gmail.com");
      $mail->addAddress($email);
      $mail->IsHTML(true);
      $mail->Subject = "New OTP";
      $mail->Body = $html;
      $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
      ));
      if ($mail->send()) {
        echo "send";
      } else {
      }
    }
  }
} else if ($type == "forget") {
  $sql = "SELECT * FROM `patient` WHERE `p_email`='$email' and p_status=1;";
  $result = mysqli_query($con, $sql);
  $rowCount = mysqli_num_rows($result);
  $rowData = mysqli_fetch_assoc($result);
  if ($rowCount <= 0) {
    echo "not_exist";
    die();
  } else {
    $_SESSION['email'] = $email;
    $otp = substr(md5(rand(111111, 999999)), 10, 4);
    $_SESSION['EMAIL_OTP'] = $otp;
    $html = "$otp is your otp";

    include('smtp/PHPMailerAutoload.php');


    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = "protapb303@gmail.com";
    $mail->Password = "xkhyqhqyixfmcspm";
    $mail->SetFrom("protapb303@gmail.com");
    $mail->addAddress($email);
    $mail->IsHTML(true);
    $mail->Subject = "New OTP";
    $mail->Body = $html;
    $mail->SMTPOptions = array('ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => false
    ));
    if ($mail->send()) {
      echo "send";
    } else {
    }
  }
} else if ($type == "order_confirm") {
  $_SESSION['email'] = $email;
  $otp = substr(md5(rand(111111, 999999)), 10, 4);
  $_SESSION['EMAIL_OTP'] = $otp;
  $html = "$otp is your otp for order confirmation";

  include('smtp/PHPMailerAutoload.php');


  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 587;
  $mail->SMTPSecure = "tls";
  $mail->SMTPAuth = true;
  $mail->Username = "protapb303@gmail.com";
  $mail->Password = "xkhyqhqyixfmcspm";
  $mail->SetFrom("protapb303@gmail.com");
  $mail->addAddress($email);
  $mail->IsHTML(true);
  $mail->Subject = "New OTP";
  $mail->Body = $html;
  $mail->SMTPOptions = array('ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => false
  ));
  if ($mail->send()) {
    echo "send";
  } else {
  }
}
