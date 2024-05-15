<?php
require("$ROOT" . "includes/db.inc.php");
require("$ROOT" . "includes/config.php");
require("$ROOT" . "includes/functions.php");
?>
<?php
$isLoggedIn = 0;
$profileImage = 0;
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == "yes") {
  $isLoggedIn = 1;
  $uid = $_SESSION['uid'];
  $sql = "SELECT * FROM patient WHERE p_id=$uid";
  $res = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($res);
  $patientName = $row['p_name'];
  $patientImage = $row['p_image'];
  if ($patientImage != '') {
    $profileImage = 1;
  }
} else {
  if (isset($_SESSION['isStaffLoggedIn']) || isset($_SESSION['isDoctorLoggedIn'])) {
    unset($_SESSION['isStaffLoggedIn']);
    unset($_SESSION['isDoctorLoggedIn']);
  } else {
    $_SESSION['uid'] = null;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>🩺Diagnostics And Medicine Hub</title>
  <link href="<?php echo "$ROOT"; ?>assets/css/root.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/bootstrap/bootstrap-grid.min.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/bootstrap/bootstrap-reboot.min.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/bootstrap/bootstrap-utilities.min.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/bootstrap/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/error.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/carousel.css" rel="stylesheet" />
  <link href="<?php echo "$ROOT"; ?>assets/css/style.css" rel="stylesheet" />
  <script src="<?php echo "$ROOT"; ?>assets/js/jquery-main.js"></script>
  <script src="<?php echo "$ROOT"; ?>assets/js/carousel.js"></script>
  <script src="<?php echo "$ROOT"; ?>assets/js/jspdf.2.5.1.min.js"></script>
  <script src="<?php echo "$ROOT"; ?>assets/js/html2canvas.js"></script>
  <script src="<?php echo "$ROOT"; ?>assets/js/dompurify.min.js"></script>
  <link href="<?php echo "$ROOT"; ?>assets/css/p.css" rel="stylesheet" />
</head>

<body>

  <input type="hidden" id="patient_id" value="<?php echo $_SESSION['uid'] ?>">
  <div class="wrapper">
    <header class="header-area header-default sticky-header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12 ">
            <div class="header-align justify-content-between">
              <div class="header-logo-area">
                <a href="<?php echo $ROOT; ?>index.php">
                  <img class="logo-main" src="<?php echo SITE_IMAGE_OTHERS_LOC; ?>logo.svg" alt="Logo" />
                  <img class="logo-light" src="<?php echo SITE_IMAGE_OTHERS_LOC; ?>logo-light.svg" alt="Logo" />
                </a>
              </div>
              <div class="header-navigation-area">
                <ul class="main-menu nav justify-content-center">
                  <li class=""><a href="<?php echo $ROOT; ?>index.php">Home</a></li>
                  <li class="has-submenu"><a href="<?php echo $ROOT; ?>diagnosis/index.php">Diagnosis</a>
                    <ul class="submenu-nav">
                      <li><a href="<?php echo $ROOT; ?>diagnosis/allPackage.php">Test Packages</a></li>
                      <li><a href="<?php echo $ROOT; ?>diagnosis/allTest.php">Tests</a></li>
                    </ul>
                  </li>
                  <li class="has-submenu"><a href="<?php echo $ROOT; ?>doctorAppointment/index.php">Specialists</a>
                  </li>
                  <li><a href="<?php echo "$ROOT"; ?>medicine/index.php">Medicines</a></li>
                  <?php
                  if ($isLoggedIn == 1) {
                  ?>
                    <li class="active"><a href="<?php echo "$ROOT"; ?>profile.php">My Profile</a></li>
                  <?php
                  }
                  ?>
                  <!-- <li><a href="<?php //echo "$ROOT"; 
                                    ?>contact.php">Contact</a></li> -->
                </ul>
              </div>
              <div class="header-action-area" id="hide_for_profile_page">
                <div class="login-reg">
                  <a href="<?php echo "$ROOT"; ?>login.php" class="login-icon-link">
                    <?php
                    if ($isLoggedIn == 1) {
                      if ($profileImage == 1) {
                        echo "<img src='" . SITE_IMAGE_PATIENT_LOC . $patientImage . "' alt='profile-icon' class='profile-icon'>";
                      } else {
                        echo "<img src='" . SITE_IMAGE_ICON_LOC . "profile-icon.png' alt='profile-icon' class='profile-icon'>";
                      }
                    } else {
                      echo "<img src='" . SITE_IMAGE_ICON_LOC . "profile-icon.png' alt='profile-icon' class='profile-icon'>";
                    }
                    ?>
                  </a>
                  <a href="<?php echo "$ROOT"; ?>login.php" class="login-text-link">
                    <b class="login-text" id="login-text">
                      <?php
                      if ($isLoggedIn == 1) {
                        echo $patientName;
                      } else {
                        echo "login";
                      }
                      ?>
                    </b>
                  </a>
                  <?php
                  if ($isLoggedIn == 1) {
                  ?>
                    <div class="user-options">
                      <li><a class="user-options-link" href="<?php echo $ROOT; ?>profile.php">Profile</a></li>
                      <li><a class="user-options-link" href="<?php echo $ROOT; ?>my_orders.php">My Orders</a></li>
                      <li><a class="user-options-link" href="<?php echo $ROOT; ?>mycart.php">Cart</a></li>
                      <li><a class="user-options-link" href="<?php echo $ROOT; ?>logout.php">Log Out</a></li>
                    </div>
                  <?php }
                  ?>
                </div>
                <button class="btn-menu d-lg-none">
                  <span></span>
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- all alerts by all pages  -->
        <!-- bootstrap alerts -->
        <div class="alert alert-warning alert-dismissible fade show alert-custom-test-page alert-custom">
          <strong></strong> <span></span>
          <button type="button" class="btn-close" id="btn-close"></button>
        </div>
      </div>
    </header>
  </div>
  <input type='hidden' id='isLoggedIn' value='<?php echo $isLoggedIn; ?>'>
  <script>
    $(document).ready(function() {
      if (jQuery("#isLoggedIn").val() == 1) {
        $(".login-icon-link").attr("href", "<?php echo $ROOT; ?>profile.php");
        $(".login-text-link").attr("href", "<?php echo $ROOT; ?>profile.php");
      }
    });
    let patient_id = $("#patient_id").val();

    function viewCart(table, type) {
      $.ajax({
        method: 'post',
        url: '../viewCart.php',
        data: 'table=' + table + '&type=' + type,
        success: function(resultView) {
          $(".cart-table-small").html(resultView);
        }
      });
    }
  </script>