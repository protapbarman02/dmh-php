<?php $ROOT = '../';
require($ROOT . "includes/header.php");
?>
<main class="main-content site-wrapper-reveal">
  <!-- search area -->
  <div class="container-fluid" style="margin-bottom:28px; padding:0px; margin-right:0;">
    <div class="medicine-search-area">
      <div class="medicine-search-area-child">
        <div class="Home_insideSearchContainer__9TmTk">
          <h1 class="buyMedicineTitle">Find Your Specialist</h1>
          <div class="Home_searchSelectMain__VL1lN">
            <form class="SearchPlaceholder_searchRoot__LWDXI" action="<?php echo $ROOT; ?>search.php" method="get">
              <i class="icofont-search-1 medicine-search-icon"></i>
              <input id="searchProduct" name="search" placeholder="Enter Doctor or health concern" class="SearchPlaceholder_inputBx__uFLF2">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- call us -->
  <div class="container" style="margin-bottom: 56px;">
    <div class="medicine-search-area">
      <div class="call-us-area-child ">
        <div class="call-us-area_9TmTk">
          <h1 class="call-us-heading text-light">Need Help?</h1>
          <div class="call-us-number">
            <h3 class="text-light">Call Us</h3>
            <h3><a href="tel:+918327507847" class="text-light">+91-83275-07847</a></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- specialization -->
  <section class="service-area" style="margin-bottom: 56px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title text-center">
            <h2 class="title">Our Specialists</span></h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="row service-style2">
            <?php
            $res = mysqli_query($con, "select sp_id,sp_name,sp_image from specialization where sp_id !=1 and sp_status!=0");
            while ($row = mysqli_fetch_assoc($res)) {
            ?>
              <!-- loop -->
              <div class="col-6 col-sm-4 col-md-3 col-lg-2 service-item">
                <a href="specialization.php?sp_id=<?php echo $row['sp_id']; ?>">
                  <div class="icon">
                    <img src="<?php echo SITE_IMAGE_SPECIALIZATION_LOC . $row['sp_image']; ?>" alt="spec">
                  </div>
                  <div class="content">
                    <h6 class="service-name" style="color:#339999;"><?php echo $row['sp_name']; ?></h6>
                  </div>
                </a>
              </div>
            <?php
            }
            ?>
            <!-- loop end -->
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<?php
require($ROOT . "includes/footer.php");
?>