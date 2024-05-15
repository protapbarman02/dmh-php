<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-index-right-panel admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Staffs</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexStaffs.php" class="right-top-link active">Staffs</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-index">
    <div class="admin-index-cards">
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>doctorAppointments.png" class="admin-index-card-img">
        </div>
        <p>Doctors</p>
        <button class="admin-index-card-btn"><a href="doctor.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>technician.png" class="admin-index-card-img">
        </div>
        <p>Technicians</p>
        <button class="admin-index-card-btn"><a href="technician.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>storeStaff.png" class="admin-index-card-img">
        </div>
        <p>Store Staffs</p>
        <button class="admin-index-card-btn"><a href="store_staff.php" class="text-dark">Manage</a></button>
      </div>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>