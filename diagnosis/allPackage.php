<?php
$ROOT = '../';
require("$ROOT" . "includes/header.php");
$table = "package";
$searchColumn = "pk_name";
$status = "pk_status";
$resultsPerPage = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$productModule = new ProductModule($table, $searchColumn, $resultsPerPage, $con);
$data = $productModule->searchWithPagination($currentPage, $searchTerm, $status);
$totalPages = $productModule->getTotalPages($searchTerm);
?>

<main class="main-content site-wrapper-reveal" style="margin-top: 0px;">
  <section class="test-list-sidebar">
    <img style="height:15px; cursor:pointer;" src="<?php echo SITE_IMAGE_ICON_LOC ?>cross-sign.png" alt="">
    <h4 class="text-center"> Included Tests</h4>
    <ul class="test-list-ul"></ul>
  </section>
  <!--== Start Page Title Area ==-->
  <section class="page-title-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="page-title-content content-style3">
            <div class="bread-crumbs bread-crumbs-style2">
              <a href="index.php">Home<span class="breadcrumb-sep">/</span></a>
              <span class="active">Health Packages</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--== End Page Title Area ==-->

  <!--== Start Blog Area Wrapper ==-->
  <section class="blog-area pb-sm-70 pb-lg-90" data-padding-bottom="137">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="post-items-style2">
            <!--== Start Blog Post Item pending test component count==-->
            <?php
            foreach ($data as $row) {
              $isRemove = 0;
              $testResult = mysqli_query($con, "select test_pack_joint.t_id from test_pack_joint where test_pack_joint.pk_id={$row['pk_id']}");
              $tRowCount = mysqli_num_rows($testResult);
            ?>
              <div class="post-item" id="post_item_<?php echo $row['pk_id']; ?>">
                <div class="thumb">
                  <?php
                  if ($row['pk_image'] != '') {
                  ?>
                    <a href="package.php?pk_id=<?php echo $row['pk_id']; ?>"><img src="<?php echo SITE_IMAGE_PACKAGE_LOC . $row['pk_image']; ?>" alt="test"></a>
                  <?php
                  } else {
                  ?>
                    <a href="package.php?pk_id=<?php echo $row['pk_id']; ?>"><img src="<?php echo SITE_IMAGE_PACKAGE_LOC; ?>testPackages.png" alt="test"></a>
                  <?php
                  }
                  ?>
                </div>
                <div class="content">
                  <h4 class="title">
                    <a href="package.php?pk_id=<?php echo $row['pk_id']; ?>"><?php echo $row['pk_name']; ?></a>
                  </h4>
                  <p class="short-description">
                    <?php echo $row['pk_short_descr']; ?>
                  </p>
                  <?php
                  if ($tRowCount > 0) {
                  ?>
                    <span class="category mt-4" onclick="viewTest(<?php echo $row['pk_id']; ?>,'smallAllT')">Included <?php echo $tRowCount; ?> Tests <span style="text-transform:none; cursor:pointer; text-decoration:underline;">(view all)</span></span>
                  <?php
                  }
                  ?>
                  <div class="meta"><?php echo $row['pk_fee']; ?>Rs/-</div>
                  <div class="meta2"><?php echo $row['pk_pay_fee']; ?> Rs/-</div>
                </div>
                <div class="book-btn-all">
                  <?php
                  if ($isLoggedIn == 1) {
                    $getCartQty = mysqli_query($con, "SELECT c_qty FROM cart WHERE p_id = {$_SESSION['uid']} AND c_product_table = 'package' AND c_product_id = {$row['pk_id']}");
                    if (mysqli_num_rows($getCartQty) > 0) {
                      $isRemove = 1;
                      $cartQty = mysqli_fetch_assoc($getCartQty)['c_qty'];
                  ?>

                      <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $row['pk_id']; ?>">Added</button>
                    <?php
                    } else {
                    ?>
                      <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $row['pk_id']; ?>" onclick="add_to_cart(1,<?php echo $row['pk_id'] ?>,'package','small_cart')">BOOK NOW</button>
                    <?php
                    }
                    ?>
                  <?php
                  } else {
                  ?>
                    <button class="btn btn-person-select" type="button" id="btn_person_select_<?php echo $row['pk_id']; ?>" onclick="restrict()">BOOK NOW</button>

                  <?php } ?>
                </div>
              </div>
            <?php
            } ?>


          </div>
          <div class="pagination-area mb-md-80 mb-4">
            <nav>
              <ul class="page-numbers">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                  if (empty($searchTerm)) {
                    echo "<li class='border border-dark p-2'><a class='page-number' href='allPackage.php?page=$i'>$i</a></li> ";
                  } else {
                    echo "<li class='border border-dark p-2'><a class='page-number' href='allPackage.php?page=$i&search=$searchTerm'>$i</a></li> ";
                  }
                }
                ?>
              </ul>
            </nav>
          </div>
        </div>
        <div class="col-lg-4">
          <!--== Start Sidebar Wrapper ==-->
          <div class="sidebar-wrapper blog-sidebar-wrapper">
            <!--== Start Sidebar Item ==-->
            <div class="widget-item border-bottom">
              <h4 class="widget-title">Search</h4>
              <div class="widget-search-box">
                <form action="" method="get">
                  <input type="text" id="search" name="search" placeholder="Search Health Package">
                </form>
              </div>
            </div>
            <!--== Start Sidebar Item ==-->
            <?php
            if ($isLoggedIn == 1) {

            ?>
              <div class="widget-item mt-2">
                <h4 class="widget-title">Health Package Cart <img style="width:30px;" src="<?php echo SITE_IMAGE_ICON_LOC ?>cart.png" alt=""></h4>
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
    </div>
  </section>
  <!--== End Blog Area Wrapper ==-->
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
  viewCart('package', 'small_cart');
</script>
<?php require("$ROOT" . "includes/footer.php"); ?>