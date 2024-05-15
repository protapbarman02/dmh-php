<?php $ROOT = '../';
require("$ROOT" . "includes/header.php");
if (isset($_GET['pk_id']) && $_GET['pk_id'] != null) {
  $pk_id = $_GET['pk_id'];
  $res = mysqli_query($con, "select * from package where pk_id=$pk_id");
  while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
  }
}
?>
<?php
foreach ($data as $package) {
  $isRemove = 0;
?>
  <main class="main-content site-wrapper-reveal">
    <!--== Start Page Title Area ==-->
    <section class="page-title-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-title-content">
              <div class="bread-crumbs">
                <a href="index.php">Home<span class="breadcrumb-sep">/</span></a>
                <a href="allPackage.php">Health Packages<span class="breadcrumb-sep">/</span></a>
                <span class="active"><?php echo $package['pk_name']; ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Page Title Area ==-->

    <!--== Start Departments Area ==-->
    <section class="department-area">
      <div class="container">
        <div class="row">


          <div class="col-lg-8">
            <div class="department-wrap">
              <!--== Start Sidebar Wrapper ==-->
              <!--== Ens Sidebar Wrapper ==-->

              <div class="department-content">
                <h2 class="title"><?php echo $package['pk_name']; ?></h2>
                <div class="case-area">
                  <div class="test-image">
                    <?php
                    if ($package['pk_image'] != '') {
                    ?>
                      <img src="<?php echo SITE_IMAGE_PACKAGE_LOC . $package['pk_image']; ?>" alt="package">
                    <?php
                    } else {
                    ?>
                      <img src="<?php echo SITE_IMAGE_PACKAGE_LOC; ?>testPackages.png" alt="package">
                    <?php
                    }
                    ?>

                  </div>
                  <div class="row">
                    <div class="col-8"><span><?php echo $package['pk_short_descr']; ?></span></div>
                    <div class="col-4">Fee : <span class="price2"><?php echo $package['pk_fee']; ?> Rs/-</span><span class="final-price2"><?php echo $package['pk_pay_fee']; ?> Rs/-</span></div>
                  </div>
                  <div class="row border-top pt-2">
                    <div class="col">
                      <p>
                        You have to provide :
                      </p>
                      <!-- pending -->
                      <span><a href="#included_tests">Please see included tests</a></span>
                    </div>
                    <?php
                    $res2 = mysqli_query($con, "select * from test inner join test_pack_joint on test_pack_joint.t_id=test.t_id where test_pack_joint.pk_id={$package['pk_id']}");
                    $tCount = mysqli_num_rows($res2);
                    if ($tCount > 0) {
                    ?>
                      <div class="col">
                        <p>
                          It Includes :
                        </p>
                        <span><?php echo $tCount; ?> Tests</span>

                      </div>
                    <?php
                      while ($tRow = mysqli_fetch_assoc($res2)) {
                        $t[] = $tRow;
                      }
                    } ?>
                    <div class="col">
                      <div class="book-btn-inside">
                        <?php
                        if ($isLoggedIn == 1) {
                          $getCartQty = mysqli_query($con, "SELECT c_qty FROM cart WHERE p_id = {$_SESSION['uid']} AND c_product_table = 'package' AND c_product_id = {$package['pk_id']}");
                          if (mysqli_num_rows($getCartQty) > 0) {
                            $isRemove = 1;
                            $cartQty = mysqli_fetch_assoc($getCartQty)['c_qty'];
                        ?>
                            <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $package['pk_id']; ?>">Added</button>
                          <?php
                          } else {
                          ?>
                            <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $package['pk_id']; ?>" onclick="add_to_cart(1,<?php echo $package['pk_id'] ?>,'package','small_cart')">BOOK NOW</button>
                          <?php
                          }
                          ?>
                        <?php
                        } else {
                        ?>
                          <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $package['pk_id']; ?>" onclick="restrict()">BOOK NOW</button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="case-area">
                  <div class="section-title">
                    <h5 class="title"><span>Preparation</span></h5>
                  </div>
                  <div class="content">
                    <?php echo $package['pk_preparation']; ?>
                  </div>
                </div>
                <div class="case-area" id="included_tests">
                  <div class="section-title">
                    <h5 class="title"><span>Description</span></h5>
                  </div>
                  <div class="content">
                    <?php echo $package['pk_descr']; ?>
                  </div>
                </div>
                <?php
                if ($tCount > 0) {
                ?>
                  <div class="case-area">
                    <div class="section-title">
                      <h5 class="title"><span>Tests that we will perform :</span></h5>
                    </div>
                    <?php
                    $i = 1;
                    foreach ($t as $test) {
                    ?>
                      <div class="content">
                        <div>
                          <h4>
                            <?php echo $i . ".<a href='test.php?t_id=$test[t_id]'> " . $test['t_name'] . "</a>"; ?><img src="<?php echo SITE_IMAGE_ICON_LOC ?>down-arrow.png" class="collapse-down-icon" onclick="show_hide(<?php echo $test['t_id']; ?>)" alt="">
                          </h4>
                          <div class="hide-block" id="tcDetails<?php echo $test['t_id']; ?>">
                            <article>
                              <h5>
                                Description :
                              </h5>
                              <p><?php echo $test['t_descr']; ?></p>
                            </article>
                            <article>
                              <h5>
                                Process :
                              </h5>
                              <p><?php echo $test['t_process']; ?></p>
                            </article>
                            <article>
                              <h5>
                                You Have To Provide:
                              </h5>
                              <p><?php echo $test['t_sample_type']; ?></p>
                            </article>
                            <?php
                            $res3 = mysqli_query($con, "select * from test_components where t_id={$test['t_id']}");
                            $tcCount = mysqli_num_rows($res3);
                            if ($tcCount > 0) {
                            ?>
                              <div>
                                <h5>Sub-tests that are included : </h5>
                                <?php $j = 1.1;
                                while ($tcDetails = mysqli_fetch_assoc($res3)) {
                                ?>
                                  <div>
                                    <article>
                                      <h6>
                                        <?php echo $j . ". " . $tcDetails['tc_name']; ?><img src="<?php echo SITE_IMAGE_ICON_LOC ?>down-arrow.png" class="collapse-down-icon" onclick="show_hide_sub(<?php echo $test['t_id']; ?>,<?php echo $tcDetails['tc_id']; ?>)" alt="">
                                      </h6>
                                      <p class="hide-block" id="tcDetails<?php echo $test['t_id']; ?><?php echo $tcDetails['tc_id']; ?>">
                                        <?php echo $tcDetails['tc_descr']; ?>
                                        </br><span>Normal value of <?php echo $tcDetails['tc_name']; ?> is <?php if ($tcDetails['tc_range'] != "N/A") {
                                                                                                              echo $tcDetails['tc_range'];
                                                                                                            } else {
                                                                                                              echo $tcDetails['tc_lower_val'] . ' to' . $tcDetails['tc_upper_val'] . ' ' . $tcDetails['tc_unit'];
                                                                                                            }
                                                                                                            ?></span>
                                      </p>
                                    </article>
                                  </div>
                                <?php
                                  $j += 0.1;
                                } ?>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    <?php
                      $i++;
                    } ?>
                  </div>
                <?php

                }
                ?>
                <div class="case-area">
                  <div class="section-title">
                    <h5 class="title"><span>Cautions</span></h5>
                  </div>
                  <div class="content">
                    ***<?php echo $package['pk_caution']; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <!--== Start Sidebar Wrapper ==-->
            <div class="sidebar-wrapper blog-sidebar-wrapper">
              <!--== Start Sidebar Item ==-->
              <?php
              if ($isLoggedIn == 1) {

              ?>
                <div class="widget-item mt-2">
                  <h4 class="widget-title">Health Package cart <img style="width:30px;" src="<?php echo SITE_IMAGE_ICON_LOC ?>cart.png" alt=""></h4>
                  <div class="cart-table-small">

                  </div>
                  <div class="widget-search-box">
                    <div class="add-cart">
                      <button class="btn-view-cart" type="button"><a href="<?php echo $ROOT ?>myCart.php">VIEW CART</a></button>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
            <!--== End Sidebar Wrapper ==-->
          </div>
        </div>
      <?php } ?>
      </div>
    </section>
    <!--== End Departments Area ==-->
  </main>
  <script>
    function restrict() {
      $(".alert-custom-test-page").css("display", "block");
      $(".alert-custom-test-page>strong").html("Please!");
      $(".alert-custom-test-page>span").html("login to add package into cart");
    }
    $("#btn-close").click(() => {
      $(".alert-custom-test-page").css("display", "none");
    })

    function show_hide_sub(m, n) {
      $("#tcDetails" + m.toString() + n.toString()).toggleClass("hide-block");
    }
    viewCart('package', 'small_cart');
  </script>
  <?php require("$ROOT" . "includes/footer.php"); ?>