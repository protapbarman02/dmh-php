<?php
require("header.php");
if (!isset($_SESSION['isDoctorLoggedIn']) || $_SESSION['isDoctorLoggedIn'] != "yes") {
  if (isset($_SESSION['isStaffLoggedIn']) || isset($_SESSION['isLoggedIn'])) {
    unset($_SESSION['isStaffLoggedIn']);
    header("location:../error.php");
    die();
  }
  header("location:login.php");
  die();
} else {
  $profileImage = 0;
  $d_id = $_SESSION['d_id'];
  $sql = "SELECT * FROM doctor WHERE d_id='$d_id';";
  $result = mysqli_query($con, $sql);
  $rowData = mysqli_fetch_assoc($result);
  $d_image = $rowData['d_image'];
  $d_name = $rowData['d_name'];
  if ($d_image != '') {
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
  <div class="loggedin-container profile-cont-doc">
    <?php if ($profileImage == 1) {
      echo "<img src='" . SITE_IMAGE_DOCTOR_LOC . $d_image . "' alt='profile-icon' class='profile-icon'>";
    } else {
      echo "<img src='" . SITE_IMAGE_ICON_LOC . "profile-icon.png' alt='profile-icon' class='profile-icon'>";
    }
    ?>
    <b class="login-text" id="login-text"><?php echo $d_name; ?></b>
    <ul class="login-type-container">
      <li><a class="login-type-link" href="<?php echo $ROOT ?>logout.php">Log Out</a></li>
    </ul>
  </div>
</header>
<main class="admin-panel-main">
  <nav id="admin-nav" class="admin-left-panel admin-nav-hide">
    <div class="nav-menu-title">Menu</div>
    <div class="admin-nav-cont cont-active">
      <a href="index.php" class="admin-nav-link">Dashboard</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>dashboard.png" class="admin-nav-icon  " alt="right-arrow">
    </div>
    <div class="admin-nav-cont">
      <a href="profile.php" class="admin-nav-link">My Profile</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>dashboard.png" class="admin-nav-icon  " alt="right-arrow">
    </div>
    <div class="admin-nav-cont">
      <a href="allAppointments.php" class="admin-nav-link">All Appointments</a>
      <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>patient.png" class="admin-nav-icon  " alt="">
    </div>
    <div class="admin-nav-cont">
      <a href="../logout.php" class="admin-nav-link">Logout</a>
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