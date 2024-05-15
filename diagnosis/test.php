<?php $ROOT = '../';
require("$ROOT" . "includes/header.php");
if (isset($_GET['t_id']) && $_GET['t_id'] != null) {
  $t_id = $_GET['t_id'];
  $res = mysqli_query($con, "select * from test where t_id=$t_id");
  while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
  }
}
?>
<?php
foreach ($data as $test) {
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
                <a href="allTest.php">All Tests<span class="breadcrumb-sep">/</span></a>
                <span class="active"><?php echo $test['t_name']; ?></span>
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
                <h2 class="title"><?php echo $test['t_name']; ?></h2>
                <div class="case-area">
                  <div class="test-image">
                    <?php
                    if ($test['t_image'] != '') {
                    ?>
                      <img src="<?php echo SITE_IMAGE_TEST_LOC . $test['t_image']; ?>" alt="test">
                    <?php
                    } else {
                    ?>
                      <img src="<?php echo SITE_IMAGE_TEST_LOC; ?>testCategories.png" alt="test">
                    <?php
                    }
                    ?>

                  </div>
                  <div class="row">
                    <div class="col-8"><span><?php echo $test['t_short_descr']; ?></span></div>
                    <div class="col-4">Fee : <span class="price2"><?php echo $test['t_fee']; ?> Rs/-</span><span class="final-price2"><?php echo $test['t_final_fee']; ?> Rs/-</span></div>
                  </div>
                  <!-- <p></p>
                                    <p></p> -->
                  <div class="row border-top pt-2">
                    <div class="col">
                      <p>
                        You have to provide :
                      </p>
                      <span><?php echo $test['t_sample_type']; ?></span>
                    </div>
                    <?php
                    $res2 = mysqli_query($con, "select * from test_components where t_id={$test['t_id']}");
                    $tcCount = mysqli_num_rows($res2);
                    if ($tcCount > 0) {
                    ?>
                      <div class="col">
                        <p>
                          It Includes :
                        </p>
                        <span><?php echo $tcCount; ?> Tests</span>

                      </div>
                    <?php
                      while ($tcRow = mysqli_fetch_assoc($res2)) {
                        $tc[] = $tcRow;
                      }
                    } ?>
                    <div class="col">
                      <div class="book-btn-inside">
                        <?php
                        if ($isLoggedIn == 1) {
                          $getCartQty = mysqli_query($con, "SELECT c_qty FROM cart WHERE p_id = {$_SESSION['uid']} AND c_product_table = 'test' AND c_product_id = {$test['t_id']}");
                          if (mysqli_num_rows($getCartQty) > 0) {
                            $isRemove = 1;
                            $cartQty = mysqli_fetch_assoc($getCartQty)['c_qty'];
                        ?>

                            <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $test['t_id']; ?>">Added</button>
                          <?php
                          } else {
                          ?>
                            <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $test['t_id']; ?>" onclick="add_to_cart(1,<?php echo $test['t_id'] ?>,'test','small_cart')">BOOK NOW</button>
                          <?php
                          }
                          ?>
                        <?php
                        } else {
                        ?>
                          <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $test['t_id']; ?>" onclick="restrict()">BOOK NOW</button>

                        <?php } ?>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="case-area">
                  <div class="section-title">
                    <h5 class="title"><span>Test Preparation</span></h5>
                  </div>
                  <div class="content">
                    <?php echo $test['t_preparation']; ?>
                  </div>
                </div>
                <div class="case-area">
                  <div class="section-title">
                    <h5 class="title"><span>Description</span></h5>
                  </div>
                  <div class="content">
                    <?php echo $test['t_descr']; ?>
                  </div>
                </div>
                <?php if ($test['t_process'] == "N/A" || $test['t_process'] == "") {
                } else { ?>

                  <div class="case-area">
                    <div class="section-title">
                      <h5 class="title"><span>Process</span></h5>
                    </div>
                    <div class="content">
                      <?php echo $test['t_process']; ?>
                    </div>
                  </div>
                <?php } ?>
                <?php if ($test['t_caution'] == "N/A" || $test['t_caution'] == "") {
                } else { ?>
                  <div class="case-area">
                    <div class="section-title">
                      <h5 class="title"><span>Cautions</span></h5>
                    </div>
                    <div class="content">
                      ***<?php echo $test['t_caution']; ?>
                    </div>
                  </div>
                <?php } ?>
                <?php
                if ($tcCount > 0) {
                ?>
                  <div class="case-area">
                    <div class="section-title">
                      <h5 class="title"><span>Tests that we will perform :</span></h5>
                    </div>
                    <?php
                    $i = 1;
                    foreach ($tc as $tcDetails) {
                    ?>
                      <div class="content">
                        <article>
                          <h6>
                            <?php echo $i . ". " . $tcDetails['tc_name']; ?><img src="<?php echo SITE_IMAGE_ICON_LOC ?>down-arrow.png" class="collapse-down-icon" onclick="show_hide(<?php echo $tcDetails['tc_id']; ?>)" alt="">
                          </h6>
                          <p class="hide-block" id="tcDetails<?php echo $tcDetails['tc_id']; ?>">
                            <?php echo $tcDetails['tc_descr']; ?>
                            </br><span>Normal value of <?php echo $tcDetails['tc_name']; ?> is
                              <?php if ($tcDetails['tc_range'] != "N/A") {
                                echo $tcDetails['tc_range'];
                              } else {
                                echo $tcDetails['tc_lower_val'] . ' to' . $tcDetails['tc_upper_val'] . ' ' . $tcDetails['tc_unit'];
                              }
                              ?></span>
                          </p>
                        </article>
                      </div>
                    <?php
                      $i++;
                    } ?>
                  </div>
                <?php

                }
                ?>
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
                  <h4 class="widget-title">Test Appointment cart <img style="width:30px;" src="<?php echo SITE_IMAGE_ICON_LOC ?>cart.png" alt=""></h4>
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
      $(".alert-custom-test-page>span").html("login to add test into cart");
    }
    $("#btn-close").click(() => {
      $(".alert-custom-test-page").css("display", "none");
    })
    viewCart('test', 'small_cart');
  </script>
  <?php require("$ROOT" . "includes/footer.php"); ?>