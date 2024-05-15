<?php
$ROOT = "../";
require("$ROOT" . "includes/header.php");
?>
<main class="main-content site-wrapper-reveal" style="margin-top: 0px;">

  <!-- search area -->
  <div class="container-fluid" style="margin-bottom:28px; padding:0px; margin-right:0;">
    <div class="medicine-search-area">
      <div class="medicine-search-area-child">
        <div class="Home_insideSearchContainer__9TmTk">
          <h1 class="buyMedicineTitle">Find Your Diagnosis</h1>
          <div class="Home_searchSelectMain__VL1lN">
            <form class="SearchPlaceholder_searchRoot__LWDXI" action="queryDiagnosis.php" method="get">
              <i class="icofont-search-1 medicine-search-icon"></i>
              <input id="searchProduct" name="search" placeholder="Search Lab Tests or Health Packages" class="SearchPlaceholder_inputBx__uFLF2">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- category division -->
  <section style="margin-bottom:56px;">
    <div class="Grid_grid_diagnosis">
      <!-- loop -->
      <div class="Grid_Item__KaQ4v">
        <div class="OB">
          <a href="allTest.php" aria-label="Apollo Products" class="cardAnchorStyle PB ">
            <div class="QB"><img src="<?php echo SITE_IMAGE_OTHERS_LOC; ?>test_index.jpg" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh  "></div>
            <h2 class="ub sb RB Pb">All Tests</h2>
          </a>
        </div>
      </div>
      <!-- loop -->
      <div class="Grid_Item__KaQ4v">
        <div class="OB">
          <a href="allPackage.php" aria-label="Baby Care" class="cardAnchorStyle PB ">
            <div class="QB"><img src="<?php echo SITE_IMAGE_OTHERS_LOC; ?>package_index.jpg" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh  "></div>
            <h2 class="ub sb RB Pb">Health Packages</h2>
          </a>
        </div>
      </div>
      <div class="Grid_Item__KaQ4v">
        <div class="OB">
          <a href="tel:+918327507847" aria-label="Personal Care" class="cardAnchorStyle PB ">
            <div class="QB"><img src="<?php echo SITE_IMAGE_OTHERS_LOC; ?>call.jpg" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh  "></div>
            <h2 class="ub sb RB Pb">Book On Call</h2>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- top sell test -->
  <div class="container-fluid" style="background-color:#33999910;">
    <section class="container top-items">
      <div class="row d-flex flex-column">
        <div class="col my-4">
          <div class="row d-flex">
            <div class="col text-center position-relative">
              <h4>Frequently Booked Lab Tests</h4>
              <div class="view-all-link position-absolute"><a href="allTest.php?sort=book_count">View All</a></div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="medi-carousel-container" id="carousel1">
            <div class="medi-carousel px-4">
              <?php
              $resultTest = mysqli_query($con, "select t_id,t_name,t_fee,t_final_fee from test where t_status!=0 order by t_book_count LIMIT 6 OFFSET 0");
              while ($rowTest = mysqli_fetch_assoc($resultTest)) {
              ?>
                <!-- loop -->
                <div class="d-flex flex-column medi-carousel-item single-product">
                  <div class="d-flex flex-column justify-content-between">
                    <div class="mb-2">
                      <a href="test.php?t_id=<?php echo $rowTest['t_id']; ?>">
                        <b><?php echo $rowTest['t_name']; ?></b>
                      </a>
                    </div>
                    <div>
                      <ul class="pricing-list">
                        <li class="desc">Includes</li>
                        <li style="color:green;"><i class="icofont-check-circled"></i>
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
                  </div>
                  <div class="product-details p-2 d-flex flex-column justify-content-end">
                    <div class="money d-flex flex-column">
                      <p style="color:green;">₹<?php echo $rowTest['t_final_fee']; ?>/-</p>
                      <p style="color:black; text-decoration:line-through;"> (<?php echo $rowTest['t_fee']; ?> Rs/-)</p>
                    </div>
                    <div class="pricing-footer">
                      <a class="btn-theme btn-border" href="test.php?t_id=<?php echo $rowTest['t_id']; ?>">Book Now</a>
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
  </div>

  <!-- top sell package -->
  <div class="container-fluid" style="background-color:#33999910;">
    <section class="container top-items">
      <div class="row d-flex flex-column">
        <div class="col my-4">
          <div class="row d-flex">
            <div class="col text-center position-relative">
              <h4>Frequently Booked Health Packages</h4>
              <div class="view-all-link position-absolute"><a href="allPackage.php?sort=book_count">View All</a></div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="medi-carousel-container" id="carousel1">
            <div class="medi-carousel px-4">
              <?php
              $resultPackage = mysqli_query($con, "select * from package where pk_status!=0 order by pk_book_count LIMIT 6 OFFSET 0");
              while ($rowPackage = mysqli_fetch_assoc($resultPackage)) {
              ?>
                <!-- loop -->
                <div class="d-flex flex-column medi-carousel-item single-product">
                  <div class="d-flex flex-column justify-content-between">
                    <div class="mb-2">
                      <a href="package.php?pk_id=<?php echo $rowPackage['pk_id']; ?>">
                        <b><?php echo $rowPackage['pk_name']; ?></b>
                      </a>
                    </div>
                    <div>
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
                        <li style="color:green;"><i class="icofont-check-circled"></i>
                          <?php echo $testCount; ?> Tests</li>
                        <?php if ($subTestCount > 0) { ?><li style="color:green;"><i class="icofont-check-circled"></i> <?php echo $subTestCount; ?> Sub Tests</li><?php  } ?>
                      </ul>
                    </div>
                  </div>
                  <div class="product-details p-2 d-flex flex-column justify-content-end">
                    <div class="money d-flex flex-column">
                      <p style="color:green;">₹<?php echo $rowPackage['pk_pay_fee']; ?>/-</p>
                      <p style="color:black; text-decoration:line-through;"> (<?php echo $rowPackage['pk_fee']; ?> Rs/-)</p>
                    </div>
                    <div class="pricing-footer">
                      <a class="btn-theme btn-border" href="diagnosis/package.php?pk_id=<?php echo $rowPackage['pk_id']; ?>">Book Now</a>
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
  </div>

  <!-- call us -->
  <div class="container">
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
</main>
<?php
require("$ROOT" . "includes/footer.php");
?>