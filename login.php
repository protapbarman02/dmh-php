<?php $ROOT = '';
require("includes/header.php");
if (isset($isLoggedIn) && $isLoggedIn == 1) {
?>
  <script>
    window.location.href = "index.php";
  </script>
  <?php
  exit;
} else {
  $emailError = '';
  $passError = '';
  if (isset($_POST['submit']) && ($_POST['submit'] == 'submit')) {
    $pass = md5(trim($_POST["password"]));
    if ($_POST['type'] == "email") {
      $login_data = trim($_POST["login_data"]);
      $stmt = $con->prepare("SELECT * FROM `patient` WHERE `p_email`=? and `p_status`=1");
      $stmt->bind_param("s", $login_data);
    } else {
      $login_data = trim($_POST["login_data"]);
      $stmt = $con->prepare("SELECT * FROM `patient` WHERE `p_phn`=? and `p_status`=1");
      $stmt->bind_param("s", $login_data);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rowCount = $result->num_rows;

    if ($rowCount > 0) {
      $rowData = $result->fetch_assoc();
      if ($rowData['p_pass'] == $pass) {
        $_SESSION['isLoggedIn'] = "yes";
        $_SESSION['uid'] = $rowData['p_id'];
  ?>
        <script>
          window.location.href = "index.php";
        </script>
<?php
        exit;
      } else {
        $passError = "password did not match";
      }
    } else {
      $emailError = "user does not exist";
    }
    $stmt->close();
  }
}
?>
<main class="main-content site-wrapper-reveal">
  <!--== Start Contact Area ==-->
  <section class="contact-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="contact-form">
            <div class="section-title text-center">
              <h2 class="title">Patient <span>Login</span></h2>
            </div>
            <form class="contact-form-wrapper" id="login-form" action="<?php echo currentPage(); ?>" method="post">
              <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 col-sm-12">
                  <div class="form-group">
                    <input class="form-control" type="text" id="email" name="login_data" placeholder="Enter Email Address/Phone Number">
                    <p class="em-error log-error"><?php echo $emailError; ?></p>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 col-sm-12">
                  <div class="form-group">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password">
                    <p class="ps-error log-error"><?php echo $passError; ?></p>
                  </div>
                </div>
              </div>

              <div class="col-md-12 text-center">
                <div class="form-group mb-0">
                  <button class="btn btn-theme btn-block" type="submit" id="login_btn" name="submit" value="submit">Login</button>
                </div>
              </div>
              <div class="row justify-content-center mt-4">
                <div class="col-lg-3 col-md-4 col-sm-4 align-self-start">
                  <a href="signup.php">New Patient?</a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 align-self-end">
                  <a href="forgot_password.php">Forgot password?</a>
                </div>
              </div>
              <input type="hidden" name="type" id="login-type">
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!--== End Contact Area ==-->
</main>
<script>
  $(document).ready(function() {
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phoneRegex = /^\d{10}$/;
    $("#login-form").on("submit", function(e) {
      $(".log-error").html('');
      let email = $("#email").val().trim();
      let pass = $("#password").val().trim();
      if (email == '' || pass == '') {
        $(".log-error:eq(1)").html('please input login data');
        e.preventDefault();
      } else {
        if (emailRegex.test(email)) {
          $("#login-type").val("email");
        } else if (phoneRegex.test(email)) {
          $("#login-type").val("phn");
        } else {
          $(".log-error:eq(0)").html('invalid credentials');
          e.preventDefault();
        }
      }
    });
  });
</script>
<?php require("includes/footer.php"); ?>