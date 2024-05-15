<?php
$ROOT = "../";
require("header.php");
$userMsg = '';
$passMsg = '';
if (isset($_SESSION['isDoctorLoggedIn']) && $_SESSION['isDoctorLoggedIn'] == "yes") {
  header("location:index.php");
} else {
  if (isset($_SESSION['isLoggedIn']) || isset($_SESSION['isStaffLoggedIn'])) {
    unset($_SESSION['isLoggedIn']);
    unset($_SESSION['isStaffLoggedIn']);
  }
}
if (isset($_POST['submit']) && $_POST['submit'] != null) {
  $d_email = trim($_POST['d_email']);
  $d_pass = md5(trim($_POST['d_pass']));
  $stmt = $con->prepare("SELECT * FROM `doctor` WHERE `d_email`=?");
  $stmt->bind_param("s", $d_email);
  $stmt->execute();
  $result = $stmt->get_result();
  $rowCount = $result->num_rows;
  if ($rowCount > 0) {
    $rowData = $result->fetch_assoc();
    if ($rowData['d_pass'] == $d_pass) {
      $_SESSION['isDoctorLoggedIn'] = "yes";
      $_SESSION['d_id'] = $rowData['d_id'];
      header("location:index.php");
    } else {
      $passMsg = "password did not match";
    }
  } else {
    $userMsg = "email does not exist";
  }
  $stmt->close();
}
?>
<main class="login-form-main">
  <section class="login-form-section">
    <form class="login-form" action="<?php echo currentPage(); ?>" method="post">
      <div class="form-title">
        Doctor Login
      </div>
      <div class="form-input">
        <label for="s_uname">Username</label>
        <input type="text" id="s_uname" name="d_email" placeholder="Enter Username">
        <div class="log-err"><?php echo $userMsg; ?></div>
      </div>
      <div class="form-input">
        <label for="s_pass">Password</label>
        <input type="password" id="s_pass" name="d_pass" placeholder="Enter Password">
        <div class="log-err"><?php echo $passMsg; ?></div>
      </div>
      <div class="captcha">
        <label for="captcha-input">Enter Captcha</label>
        <div class="captcha-form mb-2">
          <input type="text" id="captcha-form" placeholder="Enter captcha text">
          <button type="button" class="captcha-refresh" onclick="generateCaptcha()">
            <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>reset.png" alt="aa">
          </button>
        </div>
        <div class="preview"></div>
      </div>
      <p class="log-err"></p>
      <div class="form-input">
        <button type="submit" name="submit" value="submit" id="login-btn">Login</button>
      </div>
    </form>
  </section>
</main>
<script>
  $(document).ready(() => {
    generateCaptcha();
  })

  function generateCaptcha() {
    let captchaValue = "";
    let value = btoa(Math.random() * 1000000000);
    value = value.substr(0, 5);
    captchaValue = value;
    captchaValue = captchaValue.replace(/[oO0]/g, '');
    let captcha = captchaValue.split("").map((char) => {
      const rotate = -25 + Math.floor(Math.random() * 50);
      const size = Math.floor(Math.random() * 20) + 16;
      return `<span style="transform:rotate(${rotate}deg); font-size:${size}px;">${char}</span>`;
    }).join("");
    $(".preview").html(captcha);
  }
  $(".login-form").on("submit", function(e) {
    $(".log-err").html('');
    let captcha = $(".preview").text();
    let captchaInput = $("#captcha-form").val();
    let s_uname = $("#s_uname").val();
    let s_pass = $("#s_pass").val();
    if (s_uname == '') {
      $(".log-err:eq(0)").html('please enter username');
      e.preventDefault();
      return;
    }
    if (s_pass == '') {
      $(".log-err:eq(1)").html('please enter password');
      e.preventDefault();
      return;
    }
    if (captchaInput == '') {
      $(".log-err:eq(2)").html('please enter captcha');
      e.preventDefault();
      return;
    }
    if (captchaInput !== captcha) {
      $(".log-err:eq(2)").html('captcha-error');
      e.preventDefault();
      return;
    }
  });
</script>
<?php
require("$ROOT" . "admin/footer.php");
?>