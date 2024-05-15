<?php
require('includes/db.inc.php');
?>

<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
  $email = $_SESSION['email'];
  $pass = md5($_POST['password']);
  $sql = "UPDATE `patient` SET `p_pass`='$pass' WHERE `p_email`='$email';";
  $result = mysqli_query($con, $sql);
  if ($result) {
?>
    <script>
      window.location.href = "login.php";
    </script>
  <?php
  } else {

  ?>
    <script>
      alert("password update failed, please try after sometime...");
      window.location.href = "forget_password.php";
    </script>
<?php
  }
}
?>