<?php $ROOT = "";
include("$ROOT" . "includes/header.php");
if (isset($isLoggedIn) && $isLoggedIn == 1) {
  header("location:profile.php");
  die();
}
?>
<main class="main-content site-wrapper-reveal">
  <!--== Start Contact Area ==-->
  <section class="contact-area" style="background-color: #339999; margin-top:0;">
    <div class="container">
      <div class="row sign_otp_full">
        <div class="col-lg-12">
          <div class="contact-form">
            <div class="section-title text-center">
              <h2 class="title">PASSWORD RECOVERY!</h2>
            </div>

            <div class="contact-form-wrapper email-con">
              <div class="row justify-content-center">
                <div class="col-8">
                  <div class="form-group">
                    <label for="email">Enter email address</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="abc@gmail.com">
                    <p id="email_err" class="log-error"></p>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <div class="form-group mb-0">
                  <button class="btn btn-theme btn-block" type="button" id="email_sent_btn" onclick="email_sent_otp()">Send OTP</button>
                </div>
              </div>
            </div>

            <div class="contact-form-wrapper otp-con">
              <div class="row justify-content-center">
                <div class="col section-title text-center">
                  <h3>Please enter OTP sent to</h3>
                  <span id="getEmail" style="color:#339999; font-size:1rem"></span>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="form-group col-lg-4 col-md-4 col-sm-6 col-8">
                  <label for="email">Your OTP</label>
                  <input class="form-control" type="text" id="email_otp" placeholder="Enter OTP">
                  <p id="otp_err" class="log-error"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="form-group mb-0">
                    <button class="btn btn-theme btn-block" type="button" id="verify-btn" onclick="email_verify_otp()">Verify OTP</button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="form-group mb-0">
                    <div class="resend">didn't recieve otp? <span onclick="email_sent_otp()" style="color:#339999;">resend...</span></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="contact-form-wrapper pass-con">
              <form action="update_password.php" method="post">
                <div class="row justify-content-center">
                  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-8">
                    <label for="email">Create Password</label>
                    <input class="form-control" type="password" name="password" id="fg-password" placeholder="Enter Password">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-8">
                    <label for="email">Confirm Password</label>
                    <input class="form-control" type="password" name="cpassword" id="fg-cpassword" placeholder="Re-Enter Password">
                    <p id="pass_err" class="log-error"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <div class="form-group mb-0">
                      <button class="btn btn-theme btn-block" type="submit" name="submit" value="submit" id="updatePassBtn" onclick="checkPass()">Update Password</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>

          </div>
          <!--  -->

        </div>
      </div>
    </div>
    </div>
  </section>
  <!--== End Contact Area ==-->
</main>

<script>
  $(".otp-con").css("display", "none");
  $(".pass-con").css("display", "none");

  function getEmail() {
    var email = jQuery('#email').val();
    return email;
  }

  function email_sent_otp() {
    $(".log-error").html("");
    var email = getEmail();
    if (email == '') {
      jQuery('#email_err').html('Please enter email id');
    } else {
      let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailRegex.test(email)) {
        jQuery('#email_sent_btn').html('please wait...');
        jQuery('#email_sent_btn').attr('disabled', true);
        jQuery('#getEmail').text(email);

        jQuery.ajax({
          url: 'send_otp.php',
          type: 'post',
          data: 'email=' + email + '&type=forget',
          success: function(result) {
            console.log(result);
            if (result == 'send') {
              $(".email-con").css("display", "none");
              $(".otp-con").css("display", "block");
              console.log("otp sent");
            } else if (result == 'not_exist') {
              $(".email-con").css("display", "block");
              $(".otp-con").css("display", "none");
              jQuery('#email_err').html('email does not exist');
              jQuery('#email_sent_btn').html('Send OTP');
              jQuery('#email_sent_btn').attr('disabled', false);
            } else {
              $(".email-con").css("display", "block");
              $(".otp-con").css("display", "none");
              console.log("otp seding failed");
              jQuery('#email_sent_btn').html('Send OTP');
              jQuery('#email_err').html('please try after sometime...');
              jQuery('#email_sent_btn').attr('disabled', false);
            }
          }
        });
      } else {
        jQuery('#email_err').html('Please enter valid email id');

      }
    }
  }

  function email_verify_otp() {
    $(".log-error").html("");
    // jQuery('#otp_err').html('');
    var email_otp = jQuery('#email_otp').val();
    if (email_otp == '') {
      jQuery('#otp_err').html('Please enter OTP');
    } else {
      jQuery.ajax({
        url: 'check_otp.php',
        type: 'post',
        data: 'otp=' + email_otp,
        success: function(result) {
          console.log(result);
          if (result == 'done') {
            $(".otp-con").css("display", "none");
            $(".pass-con").css("display", "block");
          } else {
            jQuery('#otp_err').html('Please enter valid OTP');

          }
        }

      });
    }
  }
  jQuery('#updatePassBtn').attr('disabled', true);
  $(':input').focus(function() {
    $('#pass_err').html('');
    jQuery("#updatePassBtn").attr("disabled", false);
  });

  function checkPass() {
    jQuery('#pass_err').html('');
    var fgpassword = jQuery('#fg-password').val().trim();
    var fgcpassword = jQuery('#fg-cpassword').val().trim();
    if (fgpassword == '' || fgcpassword == '') {
      jQuery('#updatePassBtn').attr('disabled', true);
      jQuery('#pass_err').html('password can not be empty');
    } else {
      if (fgpassword != fgcpassword) {
        jQuery('#updatePassBtn').attr('disabled', true);
        jQuery('#pass_err').html('password did not match');
      } else {
        jQuery('#pass_err').html('');
        jQuery('#updatePassBtn').attr('disabled', false);
      }
    }
  }
</script>
<?php
include("$ROOT" . "includes/footer.php");
?>