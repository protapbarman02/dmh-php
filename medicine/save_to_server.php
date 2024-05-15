<?php
require('../includes/db.inc.php');
if ($_FILES['pdf']) {
 $uploadedFile = $_FILES['pdf'];
 if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
  echo "file error failed" . "<br>";
  exit;
 }
 $destination = '../assets/invoice/' . $uploadedFile['name'];
 if (move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
  $check = mysqli_query($con, "update `medicine_order` set `mo_invoice_file`='{$uploadedFile['name']}' where mo_id={$_SESSION['mo_id']}");
  if (!$check) {
   echo "db file name upload failed" . "<br>";
  } else if ($check) {
   if ($_SESSION["send_email_pdf"] == 1) {
    include('../smtp/PHPMailerAutoload.php');
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = "protapb303@gmail.com";
    $mail->Password = "xkhyqhqyixfmcspm";
    $mail->SetFrom("protapb303@gmail.com");
    $mail->addAddress($_SESSION['email']);
    $mail->IsHTML(true);
    $mail->Subject = 'Invoice PDF';
    $mail->Body = 'Please find the attached PDF invoice.';
    $pdfData = file_get_contents($destination);
    $mail->addStringAttachment($pdfData, 'document.pdf', 'base64', 'application/pdf');
    $mail->SMTPOptions = array('ssl' => array(
     'verify_peer' => false,
     'verify_peer_name' => false,
     'allow_self_signed' => false
    ));
    if ($mail->send()) {
     echo "db uploaded+send" . "<br>";
    } else {
     echo "db uploaded+send failed" . "<br>";
    }
   }
  }
  http_response_code(200);
 } else {
  echo "file uploaded failed" . "<br>";
 }
} else {
 echo "file recieved failed" . "<br>";
}
