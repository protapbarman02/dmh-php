<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-index-right-panel admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Diagnosis</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexDiagnosis.php" class="right-top-link active">Diagnosis</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-index">
    <div class="admin-index-cards">
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_PACKAGE_LOC; ?>testPackages.png" class="admin-index-card-img">
        </div>
        <p>Test Packages</p>
        <button class="admin-index-card-btn"><a href="packages.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_TEST_LOC; ?>testIndex.jpg" class="admin-index-card-img">
        </div>
        <p>Tests</p>
        <button class="admin-index-card-btn"><a href="tests.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>red-blood-cells.png" class="admin-index-card-img">
        </div>
        <p>Test Components</p>
        <button class="admin-index-card-btn"><a href="test_components.php" class="text-dark">Manage</a></button>
      </div>
    </div>
    <div class="admin-index">

</section>
</main>
<?php
require('includes/footer.php');
?>