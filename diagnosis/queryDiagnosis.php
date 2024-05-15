<?php
$ROOT = "../";
require("$ROOT" . "includes/header.php");
if (isset($_GET['search'])) {
  $search = get_safe_value($con, $_GET['search']);
  $testArr = [];
  $packageArr = [];
  $res = mysqli_query($con, "SELECT t_id, t_name, t_fee, t_final_fee FROM test WHERE (t_name LIKE '%$search%' or t_descr LIKE '%$search%' or t_short_descr LIKE '%$search%') and t_status != 0;");
  $testQueryCount = mysqli_num_rows($res);
  while ($row = mysqli_fetch_assoc($res)) {
    $testArr[] = $row;
  }
  $res = mysqli_query($con, "SELECT pk_id,pk_name,pk_fee,pk_pay_fee from package where (pk_name like '%$search%' or pk_descr LIKE '%$search%' or pk_short_descr LIKE '%$search%') and pk_status != 0;");
  $packageQueryCount = mysqli_num_rows($res);
  while ($row = mysqli_fetch_assoc($res)) {
    $packageArr[] = $row;
  }
} else {
?>
  <script>
    window.location.href = "index.php";
  </script>
<?php
}
?>
<main class="main-content site-wrapper-reveal" style="margin-top: 20px;">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-8">
        <div class="test-query-res">
          <div class="row">
            <div class="col-lg-10 col-md-10 col-12">
              <h4>Lab Tests related to your search : <?php echo $search; ?></h4>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
              <h6 class="text-success"><?php echo $testQueryCount; ?> found</h6>
            </div>
          </div>
          <div class="d-flex flex-column">
            <?php
            if (empty($testArr)) {
              echo "<p>No Lab Tests found related to your search</p>";
            } else {
              foreach ($testArr as $test) {
            ?>
                <!-- loop start -->
                <div class="row p-3 rounded m-2" style="border:1px solid #33999940;">
                  <div class="col-md-9 col-12">
                    <div class="row">
                      <div class="col-1">
                        <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>test-tube.png" alt="" style="width:40px;">
                      </div>
                      <div class="col-11 d-flex flex-column">
                        <h5><a href="test.php?t_id=<?php echo $test['t_id']; ?>"><?php echo $test['t_name']; ?></a></h5>
                        <p>
                        <ul style="margin-bottom: 4px;">
                          <li style="color:green;"><i class="icofont-check-circled"></i>Includes
                            <?php
                            $testComponentRes = mysqli_query($con, "select tc_id from test_components where t_id={$test['t_id']}");
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
                        </p>
                        <p>
                          <span class="text-success fs-6 fw-bold">₹ <?php echo $test['t_fee']; ?></span>
                          <span class="text-secondary text-decoration-line-through">(₹ <?php echo $test['t_final_fee']; ?>)</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-12">
                    <a class="btn-theme btn-border" href="test.php?t_id=<?php echo $test['t_id']; ?>">Book Now</a>
                  </div>
                </div>
                <!-- loop end -->
            <?php
              }
            }
            ?>
          </div>
        </div>

        <div class="test-query-res my-4">
          <div class="row">
            <div class="col-lg-10 col-md-10 col-12">
              <h4>Health Packages related to your search : <?php echo $search; ?></h4>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
              <h6 class="text-success"><?php echo $packageQueryCount; ?> found</h6>
            </div>
          </div>
          <div class="d-flex flex-column">
            <?php
            if (empty($packageArr)) {
              echo "<p>No Health Package found related to your search</p>";
            } else {
              foreach ($packageArr as $package) {
            ?>
                <!-- loop start -->
                <div class="row p-3 rounded m-2" style="border:1px solid #33999940;">
                  <div class="col-md-9 col-12">
                    <div class="row">
                      <div class="col-1">
                        <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>pack-icon.png" alt="" style="width:40px;">
                      </div>
                      <div class="col-11 d-flex flex-column">
                        <h5><a href="package.php?pk_id=<?php echo $package['pk_id']; ?>"><?php echo $package['pk_name']; ?></a></h5>
                        <p>
                        <ul class="pricing-list" style="margin-bottom:4px;">
                          <?php
                          $packageResult = mysqli_query($con, "select t_id from test_pack_joint where test_pack_joint.pk_id={$package['pk_id']}");
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
                        </p>
                        <p>
                          <span class="text-success fs-6 fw-bold">₹ <?php echo $package['pk_fee']; ?></span>
                          <span class="text-secondary text-decoration-line-through">(₹ <?php echo $package['pk_pay_fee']; ?>)</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-12">
                    <a class="btn-theme btn-border" href="package.php?pk_id=<?php echo $package['pk_id']; ?>">Book Now</a>
                  </div>
                </div>
                <!-- loop end -->
            <?php
              }
            }
            ?>
          </div>
        </div>

      </div>
      <div class="col-4">

      </div>
    </div>

  </div>
</main>
<?php
require("$ROOT" . "includes/footer.php");
?>