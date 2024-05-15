<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-index-right-panel admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Medicines</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexMedicine.php" class="right-top-link active">Medicines</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-index">
    <div class="admin-index-cards">
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>allMedicine.png" class="admin-index-card-img">
        </div>
        <p>All Medicines</p>
        <button class="admin-index-card-btn"><a href="medicine.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>medicine_cat.png" class="admin-index-card-img">
        </div>
        <p>Category</p>
        <button class="admin-index-card-btn"><a href="category.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>medicine_cat.png" class="admin-index-card-img">
        </div>
        <p>Sub Category</p>
        <button class="admin-index-card-btn"><a href="medicine_sub_category.php" class="text-dark">Manage</a></button>
      </div>
      <div class="admin-index-card">
        <div class="admin-index-card-cont">
          <img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>medicine_cat.png" class="admin-index-card-img">
        </div>
        <p>Medcine Types</p>
        <button class="admin-index-card-btn"><a href="medicine_type.php" class="text-dark">Manage</a></button>
      </div>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>