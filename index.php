<?php $ROOT = '';
require("includes/header.php");
?>
<main class="main-content site-wrapper-reveal">
  <!-- top menu section  -->
  <section class="home-slider-area slider-default bg-img" data-bg-img="<?php echo SITE_IMAGE_OTHERS_LOC; ?>main-slide-01.jpg" style="margin-bottom:56px;">
    <div class="container">
      <div class="row ">
        <div class="col-lg-12">
          <div class="slider-content-area" data-aos="fade-zoom-in" data-aos-duration="1300">
            <h2>Your Health <span>Is Our Priority</span></h2>
          </div>
          <div class="swiper-container service-slider-container ">
            <div class="swiper-wrapper service-slider service-category d-flex flex-wrap justify-content-center align-items-center">
              <div class="swiper-slide category-item">
                <a href="diagnosis/allPackage.php">
                  <div class="icon">
                    <i class="icofont-love"></i>
                  </div>
                  <h4>Health Packages</h4>
                  <p>Book Your test Package</p>
                </a>
              </div>
              <div class="swiper-slide category-item">
                <a href="diagnosis/allTest.php">
                  <div class="icon">
                    <i class="icofont-blood-test"></i>
                  </div>
                  <h4>All Lab Tests</h4>
                  <p>Book Your Test</p>
                </a>
              </div>
              <div class="swiper-slide category-item">
                <a href="doctorAppointment/index.php">
                  <div class="icon">
                    <i class="icofont-stethoscope-alt"></i>
                  </div>
                  <h4>Specialists</h4>
                  <p>Book a visit</p>
                </a>
              </div>
              <div class="swiper-slide category-item ">
                <a href="medicine/index.php">
                  <div class="icon">
                    <i class="icofont-capsule"></i>
                  </div>
                  <h4>Medicine</h4>
                  <p>Buy all your meds</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- most availed health packages  -->
  <section class="pricing-area pricing-default-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title text-center" data-aos="fade-up" data-aos-duration="400">
            <h5>Most availed</h5>
            <h2 class="title"><a href="diagnosis/allPackage.php?sort=book_count">Health Packages</a></h2>
          </div>
        </div>
      </div>
      <div class="row row-gutter-0 pricing-items-style1" data-aos="fade-up" data-aos-duration="400">
        <?php
        $resultPackage = mysqli_query($con, "select * from package where pk_status!=0 order by pk_book_count LIMIT 6 OFFSET 0");
        while ($rowPackage = mysqli_fetch_assoc($resultPackage)) {
        ?>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 p-2 my-2 text-center">
            <div class="pricing-item item-one d-flex flex-column align-items-center">
              <div class="pricing-title">
                <p style="color:#339999;font-weight:bold;" class="fs-6"><?php echo substr($rowPackage['pk_name'], 0, 12);
                                                                        if (strlen($rowPackage['pk_name']) > 12) {
                                                                          echo "...";
                                                                        } ?></p>
              </div>
              <div class="pricing-content">
                <ul class="pricing-list">
                  <?php
                  $packageResult = mysqli_query($con, "select t_id from test_pack_joint where test_pack_joint.pk_id={$rowPackage['pk_id']}");
                  $testCount = mysqli_num_rows($packageResult);
                  $subTestCount = 0;
                  while ($testRow = mysqli_fetch_assoc($packageResult)) {
                    $testComponentRes = mysqli_query($con, "select tc_id from test_components where t_id={$testRow['t_id']}");
                    $subTestCount += mysqli_num_rows($testComponentRes);
                  }
                  ?>
                  <li class="desc">Includes</li>
                  <li><i class="icofont-check-circled"></i><?php echo $testCount; ?> Tests</li>
                  <?php if ($subTestCount > 0) { ?><li><i class="icofont-check-circled"></i><?php echo $subTestCount; ?> Sub Tests</li><?php  } ?>

                </ul>
              </div>
              <div class="pricing-amount">
                <h6 style="text-decoration:line-through; color:grey;"><?php echo $rowPackage['pk_pay_fee']; ?> Rs/-</h6>
                <h5><?php echo $rowPackage['pk_fee']; ?><span style="color:black; font-size:1rem"> Rs/-</span></h5>
              </div>
              <div class="pricing-footer">
                <a class="btn-theme btn-border" href="diagnosis/package.php?pk_id=<?php echo $rowPackage['pk_id']; ?>">Book Now</a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- call us -->
  <div class="container" style="margin-bottom: 56px;">
    <div class="medicine-search-area">
      <div class="call-us-area-child ">
        <div class="call-us-area_9TmTk">
          <h1 class="call-us-heading text-light">Need Help?</h1>
          <div class="call-us-number">
            <h3 class="text-light">Call Us</h3>
            <h3 class="text-light">+91-83275-07847</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- most availed tests  -->
  <section class="pricing-area pricing-default-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title text-center" data-aos="fade-up" data-aos-duration="400">
            <h5>Most availed</h5>
            <h2 class="title"><a href="diagnosis/allTest.php?sort=book_count">Lab Tests</a></h2>
          </div>
        </div>
      </div>
      <div class="row row-gutter-0 pricing-items-style1" data-aos="fade-up" data-aos-duration="400">
        <?php
        $resultTest = mysqli_query($con, "select t_id,t_name,t_fee,t_final_fee from test where t_status!=0 order by t_book_count LIMIT 6 OFFSET 0");
        while ($rowTest = mysqli_fetch_assoc($resultTest)) {
        ?>
          <div class="col-6 col-sm-6 col-md-4 col-lg-2 p-2 my-2">
            <div class="pricing-item item-one d-flex flex-column justify-content-between align-items-center">
              <div class="pricing-title">
                <p style="color:#339999;font-weight:bold;" class="fs-6"><?php echo substr($rowTest['t_name'], 0, 12);
                                                                        if (strlen($rowTest['t_name']) > 12) {
                                                                          echo "...";
                                                                        } ?></p>
              </div>

              <div class="pricing-content">
                <ul class="pricing-list">
                  <li class="desc">Includes</li>
                  <li><i class="icofont-check-circled"></i>
                    <?php
                    $testComponentRes = mysqli_query($con, "select tc_id from test_components where t_id={$rowTest['t_id']}");
                    $subTestCount = mysqli_num_rows($testComponentRes);
                    if ($subTestCount > 0) {
                    ?>
                    <?php echo "$subTestCount" . " Tests";
                    } else {
                      echo "1" . " Test";
                    }
                    ?>
                  </li>
                </ul>
              </div>

              <div class="pricing-amount">
                <h6 style="text-decoration:line-through; color:grey;"><?php echo $rowTest['t_final_fee']; ?> Rs/-</h6>
                <h5><?php echo $rowTest['t_fee']; ?><span style="color:black; font-size:1rem"> Rs/-</span></h5>
              </div>
              <div class="pricing-footer">
                <a class="btn-theme btn-border" href="diagnosis/test.php?t_id=<?php echo $rowTest['t_id']; ?>">Book Now</a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </section>

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
                    <h5 class="service-name"><?php echo $row['sp_name']; ?></h5>
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

  <!-- most purchased medicines -->
  <section class="container top-items">
    <div class="row d-flex flex-column">
      <div class="col m-2">
        <div class="row d-flex">
          <div class="col text-center">
            <h2 style="color:#339999;"><a href="medicine/allMedicine.php?sort=order_count">Frequently Purchased Medicines</a></h2>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="medi-carousel-container" id="carousel1">
          <div class="medi-carousel mx-4">
            <?php
            $topMedRes = mysqli_query($con, "select m_id, m_image,m_name,m_price,m_mrp from medicine where m_status!=0 order by order_count limit 10 offset 0");
            while ($topMedRow = mysqli_fetch_assoc($topMedRes)) {
            ?>
              <!-- loop -->
              <div class="single-product medi-carousel-item">
                <div class="d-flex flex-column align-items-center" style="height:125px;">
                  <a href="medicine/medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $topMedRow['m_image']; ?>" alt=""></a>
                </div>
                <div class="product-details p-2 d-flex flex-column justify-content-end">
                  <p><a href="medicine/medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>">
                      <b><?php echo $topMedRow['m_name']; ?></b>
                    </a>
                  </p>
                  <div class="money d-flex flex-column">
                    <p class="text-success fs-6">₹<?php echo $topMedRow['m_mrp']; ?> Rs/-</p>
                    <p class="text-decoration-line-through"> (<?php echo $topMedRow['m_price']; ?> Rs/-)</p>
                  </div>
                </div>
              </div>
              <!-- loop end -->
            <?php
            }
            ?>
          </div>
          <button class="medi-prev-btn"><i class="icofont-arrow-left"></i></button>
          <button class="medi-next-btn"><i class="icofont-arrow-right"></i></button>
        </div>
      </div>
    </div>
  </section>
</main>
<?php require("includes/footer.php"); ?>