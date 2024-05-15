<?php $ROOT = '';
include("includes/header.php");
if (isset($isLoggedIn) && $isLoggedIn == 1) {
	header("location:profile.php");
	die();
} else {
	if (isset($_POST['submit']) && ($_POST['submit'] == 'submit')) {
		$fname = trim($_POST['fname']);
		$dob = trim($_POST['dob']);
		$gender = trim($_POST['gender']);
		$phn = trim($_POST['phone']);
		$email = trim($_POST['email']);
		$pass = md5(trim($_POST["pass"]));
		$stmt = $con->prepare("INSERT INTO `patient` (`p_name`,`p_dob`,`p_gen`,`p_phn`,`p_email`,`p_pass`,`p_reg_date`, `p_status`) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP(), 1)");
		$stmt->bind_param("ssssss", $fname, $dob, $gender, $phn, $email, $pass);
		$check = $stmt->execute();
		if ($check) {
?>
			<script>
				window.location.href = "login.php";
			</script>
<?php
			exit();
		} else {
			echo "signup failed";
		}
		$stmt->close();
	}
}
?>
<main class="main-content site-wrapper-reveal">
	<!--== Start Contact Area ==-->
	<section class="contact-area" style="background-color: #339999;">
		<div class="container">
			<div class="row sign_otp_full">
				<div class="col-lg-12">
					<div class="contact-form">
						<div class="section-title text-center">
							<h2 class="title">WELCOME!</h2>
						</div>
						<form class="contact-form-wrapper" id="signup-form" action="<?php echo currentPage(); ?>" method="post">
							<div class="row justify-content-center">
								<div class="col-8">
									<div class="form-group">
										<label for="fname">Full Name</label>
										<input class="form-control" type="text" name="fname" id="fname" placeholder="Enter your full name">
										<p id="name_err" class="log-error"></p>
									</div>
								</div>
							</div>
							<div class="row justify-content-center col-md">
								<div class="col-8 col-lg-4">
									<div class="form-group">
										<label>Gender :</label>
										<div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="gender" id="male" value="Male">
												<label class="form-check-label" for="male">Male </label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="gender" id="female" value="Female">
												<label class="form-check-label" for="female">Female</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="gender" id="others" value="Others">
												<label class="form-check-label" for="others">Others</label>
											</div>
										</div>
										<p id="gen_err" class="log-error"></p>
									</div>
								</div>
								<div class="col-lg-4 col-8">
									<label for="dob">DOB:</label>
									<input type="date" name="dob" id="dob" class="form-control">
									<p id="dob_err" class="log-error"></p>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-8">
									<div class="form-group">
										<label for="phone">Phone Number</label>
										<input class="form-control" type="tel" name="phone" id="phone" placeholder="📞1234567890">
										<p id="phone_err" class="log-error"></p>
									</div>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-6">
									<div class="form-group">
										<label for="email">Email</label>
										<input class="form-control" type="email" name="email" id="email" placeholder="abc@gmail.com">
										<p id="email_err" class="log-error"></p>
									</div>
								</div>
								<div class="col-2 mt-4">
									<button type="button" class="btn btn-warning btn-lg" id="send-otp-btn" onclick="email_sent_otp()">Send OTP</button>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-8 col-lg-4">
									<div class="form-group">
										<label for="phone">Create Password</label>
										<input class="form-control" type="password" name="pass" id="password" placeholder="Enter password">
										<p id="pass_err" class="log-error"></p>
									</div>
								</div>
								<div class="col-8 col-lg-4">
									<div class="form-group">
										<label for="cpassword">Confirm Password</label>
										<input class="form-control" type="password" id="cpassword" placeholder="Re-enter password">
										<p id="cpass_err" class="log-error"></p>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<div class="form-group mb-0">
									<button class="btn btn-theme btn-block" type="submit" id="signup_btn" onclick="sign_valid()" name="submit" value="submit">SIGN UP</button>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<div class="form-group mb-0">
									<a href="login.php">Existing Patient?</a>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="otp-overlay-con col-lg-4 col-md-6 col-8 py-4 bg-light">
					<div class="row">
						<div class="col">
							<div class="section-title text-center">
								<h3>Please enter OTP sent to <span id="getEmail" style="color:#339999; font-size:1rem"></span></h3>
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-lg-6 col-12">
							<div class="otp-inp">
								<input type="text" id="email_otp" placeholder="Enter OTP" class="email_verify_otp form-control">
							</div>
							<div class="log-error col-12" id="otp_err"></div>
						</div>
						<div class="col-12 mt-4">
							<button type="button" class="btn btn-theme col-12" onclick="email_verify_otp()">Verify</button>
						</div>
					</div>
					<div class="resend">didn't recieve otp? <span onclick="email_sent_otp()" style="color:#339999;">resend...</span></div>
				</div>
			</div>
		</div>
		</div>
		</div>
	</section>
	<!--== End Contact Area ==-->
</main>
<script>
	$("#signup_btn").attr("disabled", "true");

	function getEmail() {
		var email = jQuery('#email').val().trim();
		return email;
	}
	let isOTPVerified = 0;

	function email_sent_otp() {
		jQuery('.log-error').html('');
		let email = getEmail();
		var phone = $('#phone').val().trim();
		jQuery('#getEmail').html(email);
		if (phone.length != 10) {
			jQuery('#phone_err').html('Please enter valid phone number');
		}
		if (email == '') {
			jQuery('#email_err').html('Please enter email id');
		}
		if (phone.length == 10 && email != '') {
			let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (emailRegex.test(email)) {
				jQuery('#send-otp-btn').html('Please wait..');
				jQuery('#send-otp-btn').attr('disabled', true);
				jQuery.ajax({
					url: 'send_otp.php',
					type: 'post',
					data: 'email=' + email + '&phn=' + phone + '&type=sign',
					success: function(result) {
						console.log(result);
						if (result == 'send') {
							jQuery('#send-otp-btn').attr('disabled', true);
							jQuery(".otp-overlay-con").css("display", "block");
							jQuery("#signup-form").css("opacity", "0.3");
						} else if (result == 'email_present') {
							jQuery(".otp-overlay-con").css("display", "none");
							jQuery("#signup-form").css("opacity", "1");
							jQuery('#send-otp-btn').html('Send OTP');
							jQuery('#send-otp-btn').attr('disabled', false);
							jQuery('#email_err').html('Email id already exists');
						} else if (result == 'phn_present') {
							jQuery(".otp-overlay-con").css("display", "none");
							jQuery("#signup-form").css("opacity", "1");
							jQuery('#send-otp-btn').html('Send OTP');
							jQuery('#send-otp-btn').attr('disabled', false);
							jQuery('#phone_err').html('phone number already exist already exists');
						} else {
							jQuery(".otp-overlay-con").css("display", "none");
							jQuery("#signup-form").css("opacity", "1");
							jQuery('#send-otp-btn').attr('disabled', false);
							jQuery('#send-otp-btn').html('Send OTP');
							jQuery('#email_err').html('Please try after sometime');
						}
					}
				});
			} else {
				jQuery('#email_err').html('Please enter valid email id');

			}
		}
	}

	function email_verify_otp() {
		jQuery('#otp_err').html('');
		var email_otp = jQuery('#email_otp').val().trim();
		if (email_otp == '') {
			jQuery('#otp_err').html('Please enter OTP');
		} else {
			jQuery.ajax({
				url: 'check_otp.php',
				type: 'post',
				data: 'otp=' + email_otp,
				success: function(result) {
					if (result == 'done') {
						isOTPVerified = 1;
						jQuery(".otp-overlay-con").css("display", "none");
						jQuery('#send-otp-btn').html('verified');
						jQuery('#send-otp-btn').attr('disabled', true);
						jQuery("#signup-form").css("opacity", "1");
						jQuery('#email').attr('readonly', true);
						jQuery('#phone').attr('readonly', true);
						jQuery('.log-error').html('');
					} else {
						jQuery('#otp_err').html('Please enter valid OTP');
					}
				}

			});
		}
	}
	// validation
	$(':input').focus(function() {
		$('.log-error').text('');
		jQuery("#signup_btn").attr("disabled", false);
	});

	function sign_valid() {
		// Reset error messages
		$('.log-error').text('');

		// Validate Full Name
		var fullName = $('#fname').val().trim();
		if (fullName.length < 5) {
			jQuery("#signup_btn").attr("disabled", true);
			$('#name_err').html('Please enter your full name.');
			return;
		}

		// Validate Gender
		var selectedGender = $('input[name="gender"]:checked').val();
		if (!selectedGender) {
			jQuery("#signup_btn").attr("disabled", true);
			$('#gen_err').text('Please select your gender.');
			return;
		}

		// Validate Date of Birth
		var dob = $('#dob').val().trim();
		if (dob === '') {
			jQuery("#signup_btn").attr("disabled", true);
			$('#dob_err').text('Please enter your date of birth.');
			return;
		}

		if (isOTPVerified == 0) {
			jQuery("#signup_btn").attr("disabled", true);
			$('#email_err').text('Please verify your email.');
			return;

		}

		// Validate Password
		var password = $('#password').val().trim();
		if (password === '') {
			jQuery("#signup_btn").attr("disabled", true);
			$('#pass_err').text('Please enter a password.');
			return;
		}

		// Validate Confirm Password
		var confirmPassword = $('#cpassword').val().trim();
		if (confirmPassword === '' || confirmPassword !== password) {
			jQuery("#signup_btn").attr("disabled", true);
			$('#pass_err').text('Passwords do not match.');
			return;
		}
		jQuery("#signup_btn").attr("disabled", false);

	}
</script>
<?php
require("$ROOT" . "includes/footer.php");
?>