<?php session_start();
$otp=$_POST['otp'];
if($otp==$_SESSION['EMAIL_OTP']){
	echo "done";
	unset($_SESSION['EMAIL_OTP']);
}else{
	echo "no";
}?>