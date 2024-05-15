<?php
require("header.php");
if (!isset($_SESSION['isStaffLoggedIn']) || $_SESSION['isStaffLoggedIn'] != "yes") {
  if (isset($_SESSION['isLoggedIn']) || isset($_SESSION['isDoctorLoggedIn'])) {
    unset($_SESSION['isDoctorLoggedIn']);
    header("location:../error.php");
    die();
  }
  header("location:login.php");
  die();
} else {
  $profileImage = 0;
  $s_id = $_SESSION['s_id'];
  $sql = "SELECT * FROM staff WHERE s_id='$s_id';";
  $result = mysqli_query($con, $sql);
  $rowData = mysqli_fetch_assoc($result);
  $s_name = $rowData['s_name'];
  $s_image = $rowData['s_image'];
  if ($s_image != '') {
    $profileImage = 1;
  }
}
?>
<header class="admin-header-container">
  <div class="menu-container" id="sidebarCollapseAdmin">
    <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>down-arrow-menu.png" id="menu-icon" alt="menu">
  </div>
  <div class="logo-container">
    <div class="logo-part">
      <a href="index.php">
        <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>logo.svg" alt="logo" class="home-logo">
      </a>
    </div>

  </div>
  <div class="loggedin-container">
    <?php if ($profileImage == 1) {
      echo "<img src='" . SITE_IMAGE_ADMIN_LOC . $s_image . "' alt='profile-icon' class='profile-icon'>";
    } else {
      echo "<img src='" . SITE_IMAGE_ICON_LOC . "profile-icon.png' alt='profile-icon' class='profile-icon'>";
    }
    ?>
    <b class="login-text" id="login-text"><?php echo $s_name; ?></b>
    <ul class="login-type-container">
      <li><a class="login-type-link" href="<?php echo $ROOT ?>logout.php">Log Out</a></li>
    </ul>
  </div>
</header>
<main class="admin-panel-main">
  <nav id="admin-nav" class="admin-left-panel admin-nav-hide">
    <div class="nav-menu-title">Menu</div>
    <div class="admin-nav-cont cont-active">
      <a href="index.php" class="admin-nav-link text-dark">Dashboard</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>dashboard.png" class="admin-nav-icon  " alt="right-arrow">
    </div>
    </div>
    <div class="admin-nav-cont">
      <a href="doctor_appointment.php" class="admin-nav-link text-dark">Doctor Appointments</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>doctor-appointment.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="lab_appointment.php" class="admin-nav-link text-dark">Lab Appointments</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>diagnosis-appointment.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="specialization.php" class="admin-nav-link text-dark">Specialization</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>heart.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="packages.php" class="admin-nav-link text-dark">Test Packages</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>package.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="tests.php" class="admin-nav-link text-dark">Tests</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>test.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="test_components.php" class="admin-nav-link text-dark">Test Components</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>red-blood-cells.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="doctor.php" class="admin-nav-link text-dark">Doctors</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>doctor.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="store_staff.php" class="admin-nav-link text-dark">Store Staffs</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>staff.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="technician.php" class="admin-nav-link text-dark">Technicians</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>lab-technician.png" class="admin-nav-icon  " alt="">

    </div>

    <div class="admin-nav-cont">
      <a href="medicine.php" class="admin-nav-link text-dark">Medicines</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>drug.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="category.php" class="admin-nav-link text-dark">Medicine Categories</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>category2.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="medicine_type.php" class="admin-nav-link text-dark">Medicine Types</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>category2.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="medicine_order.php" class="admin-nav-link text-dark">Medicine Orders</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>order.png" class="admin-nav-icon  " alt="">

    </div>
    <div class="admin-nav-cont">
      <a href="patients.php" class="admin-nav-link text-dark">Patients</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>patient.png" class="admin-nav-icon  " alt="">

    </div>
  </nav>
  <script>
    $("#sidebarCollapseAdmin").click(() => {
      $("#admin-nav").toggleClass("admin-nav-hide");
      $("#admin-nav").css("transition", "0.5s");
      $(".admin-nav-icon").toggleClass("admin-nav-icon-hide");
      $(".admin-nav-icon").css("transition", "0.5s");
      $("#menu-icon").toggleClass("menu-icon-rotate");
      $("#menu-icon").css("transition", "0.5s");
    });
  </script>