<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-index-right-panel admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Appointments</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexAppointments.php" class="right-top-link active">Appointments</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-index">
    <div class="admin-index-cards">

      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>doctorAppointments.png" class="admin-index-card-img">
        </div>
        <p>Doctor Appointments</p>
        <button class="admin-index-card-btn"><a href="doctor_appointment.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>allAppointments.png" class="admin-index-card-img">
        </div>
        <p>Lab Appointments</p>
        <button class="admin-index-card-btn"><a href="lab_appointment.php" class="text-dark">Manage</a></button>
      </div>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>