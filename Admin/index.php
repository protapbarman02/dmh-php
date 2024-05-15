<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-index-right-panel admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Dashboard</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link active">Dashboard</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-index">
    <div class="admin-index-cards">
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_TEST_LOC; ?>tests.jpg" class="admin-index-card-img">
        </div>
        <p>Diagnosis</p>
        <button class="admin-index-card-btn"><a href="indexDiagnosis.php" class="text-dark">Manage</a></button>
      </div>

      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>medicine.png" class="admin-index-card-img">
        </div>
        <p>Medicines</p>
        <button class="admin-index-card-btn"><a href="indexMedicine.php" class="text-dark">Manage</a></button>
      </div>

      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>appointment.jpg" class="admin-index-card-img">
        </div>
        <p>Appointments</p>
        <button class="admin-index-card-btn"><a href="indexAppointments.php" class="text-dark">Manage</a></button>
      </div>

      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>order.jpg" class="admin-index-card-img">
        </div>
        <p>Medcine Orders</p>
        <button class="admin-index-card-btn"><a href="medicine_order.php" class="text-dark">Manage</a></button>
      </div>

      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ADMIN_LOC; ?>staffs.jpg" class="admin-index-card-img">
        </div>
        <p>Staffs</p>
        <button class="admin-index-card-btn"><a href="indexStaffs.php" class="text-dark">Manage</a></button>
      </div>

      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_PATIENT_LOC; ?>patient.jpg" class="admin-index-card-img">
        </div>
        <p>Patients</p>
        <button class="admin-index-card-btn"><a href="patients.php" class="text-dark">Manage</a></button>
      </div>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>