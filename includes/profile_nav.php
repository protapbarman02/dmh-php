<?php
include("$ROOT" . "includes/header.php");
if (isset($isLoggedIn) && $isLoggedIn != 1) {
?>
  <script>
    window.location.href = "login.php";
  </script>
<?php
  die();
}
$res = mysqli_query($con, "select * from patient where p_id={$_SESSION['uid']}");

while ($row = mysqli_fetch_assoc($res)) {
  $p_name = $row['p_name'];
  $p_email = $row['p_email'];
  $p_image = $row['p_image'];
}
?>

<main class="main-content site-wrapper-reveal profile-page">
  <div class="container d-flex responsive-col-to-row">
    <div class="col-lg-3 col-md-4 col-sm-12 text-light shadow-lg rounded m-2" style="background-color: #339999;">
      <div class="p-2 border-bottom">
        <a href="profile.php" class="text-light"><img src="<?php echo SITE_IMAGE_PATIENT_LOC . $p_image; ?>" alt="profile" class="profile-icon"> Hello, <span class="fw-bolder"><?php echo $p_name; ?></span> </a>
      </div>
      <div>
        <div class="col d-flex flex-column">
          <div class="row d-flex flex-column mx-4 profile-nav-items">
            <div class="col py-2"><a href="myCart.php">My Cart</a></div>
            <div class="col py-2"><a href="my_orders.php" <?php if ($page == 'order') {
                                                            echo 'id="profile-nav-item-active"';
                                                          } ?>>Medicine Orders</a></div>
            <div class="col py-2"><a href="my_lab_appointments.php" <?php if ($page == 'lab_apps') {
                                                                      echo 'id="profile-nav-item-active"';
                                                                    } ?>>My Lab Appointments</a></div>
            <div class="col py-2"><a href="my_doc_appointments.php" <?php if ($page == 'doc_apps') {
                                                                      echo 'id="profile-nav-item-active"';
                                                                    } ?>>My Doctor Appointments</a></div>
          </div>

          <div class="row d-flex flex-column mx-4 profile-nav-items">
            <div class="col py-2 border-bottom"><span class="fw-bolder">My Account</span></div>
            <div class="col py-2"><a href="profile.php" <?php if ($page == 'profile') {
                                                          echo 'id="profile-nav-item-active"';
                                                        } ?>>Profile Settings</a></div>
            <div class="col py-2"><a href="my_address.php" <?php if ($page == 'address') {
                                                              echo 'id="profile-nav-item-active"';
                                                            } ?>>Manage Addresses</a></div>
          </div>
        </div>
      </div>
      <div class="border-top">
        <div class="col py-4 px-4">
          <a href="logout.php" class="text-reset"><img src="<?php echo SITE_IMAGE_ICON_LOC; ?>logout.png" alt="logout" class="logout-icon"> Logout </a>
        </div>
      </div>
    </div>
    <script>
      $("#hide_for_profile_page").css("visibility", "hidden");
    </script>