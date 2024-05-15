<?php $ROOT = '../';
require("$ROOT" . "includes/header.php");
$isCart = 0;
if (isset($_GET['m_id']) && $_GET['m_id'] != null) {
 $m_id = $_GET['m_id'];
 $res = mysqli_query($con, "select * from medicine where m_id=$m_id");
 while ($row = mysqli_fetch_assoc($res)) {
  if ($row['m_qty'] < 10) {
?>
   <script>
    window.location.href = "allMedicine.php";
   </script>
 <?php
   exit();
  }
  $data[] = $row;
 }
} else {
 ?>
 <script>
  window.location.href = "allMedicine.php";
 </script>
<?php
 exit();
}
if (isset($isLoggedIn) && $isLoggedIn == 1) {
 $checkSql = "SELECT * FROM cart WHERE p_id = {$_SESSION['uid']} AND c_product_table = 'medicine' AND c_product_id = $m_id";
 $checkResult = $con->query($checkSql);
 if ($checkResult->num_rows > 0) {
  $isCart = 1;
 }
}
?>
<?php
foreach ($data as $medicine) {
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
        <a href="allMedicine.php">All Medicines<span class="breadcrumb-sep">/</span></a>
        <span class="active"><?php echo $medicine['m_name']; ?></span>
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
       <div class="department-content">
        <h2 class="title"><?php echo $medicine['m_name']; ?></h2>
        <div class="case-area">
         <div class="test-image">
          <?php
          if ($medicine['m_image'] != '') {
          ?>
           <img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $medicine['m_image']; ?>" alt="medicine" class="medi">
          <?php
          } else {
          ?>
           <img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>allMedicine.png" alt="medicine" class="medi">
          <?php
          }
          ?>

         </div>

         <div class="row border-top pt-2">
          <div class="col-8"><span><?php echo $medicine['m_short_descr']; ?></span></div>
          <div class="col-4">Price : <span class="price2"><?php echo $medicine['m_mrp']; ?> Rs/-</span><span class="final-price2"><?php echo $medicine['m_price']; ?> Rs/-</span></div>
         </div>

         <div class="row border-top pt-2">
          <div class="col">
           <p>Dosage : </p>
           <span><?php echo $medicine['m_type']; ?></span>
          </div>
          <div class="col">
           <p>Unit Measure : </p>
           <span><?php echo $medicine['qty_per_unit'] . " " . $medicine['m_unit']; ?></span>
          </div>
          <div class="col">
           <?php
           if ($isCart == 1) {
           ?>
            <button type="button" class="btn book-btn-medi">Added To Cart</button>
           <?php
           } else {
           ?>
            <button type="button" class="btn book-btn-medi" id="book-btn-medi_<?php echo $medicine['m_id'] ?>" onclick="m_add_to_cart(<?php echo $medicine['m_id'] ?>,'medicine','small_cart')">Add To Cart</button>
           <?php }
           ?>
          </div>
         </div>
         <div class="row border-top pt-2">
          <div class="col">
           <p>Key Ingredients</p>
           <span><?php echo $medicine['m_compose'] ?></span>
          </div>
         </div>
         <div class="row border-top pt-2">
          <div class="col">
           <p>Gender Specific</p>
           <span><?php echo $medicine['m_gender_spec'] ?></span>
          </div>
          <div class="col">
           <p>Age Group</p>
           <span><?php echo $medicine['m_age_grp'] ?></span>
          </div>
         </div>
        </div>

        <div class="case-area">
         <div class="section-title">
          <h5 class="title"><span>Description</span></h5>
         </div>
         <div class="content">
          <?php echo $medicine['m_descr']; ?>
         </div>
        </div>
        <div class="case-area">
         <div class="section-title">
          <h5 class="title"><span>Direction Of Use</span></h5>
         </div>
         <div class="content">
          <?php echo $medicine['m_direction']; ?>
         </div>
        </div>
        <div class="case-area">
         <div class="section-title">
          <h5 class="title"><span>Side Effect</span></h5>
         </div>
         <div class="content">
          ***<?php echo $medicine['m_side_effect']; ?>
         </div>
        </div>
        <div class="case-area">
         <div class="section-title">
          <h5 class="title">Marketed By<span></span></h5>
         </div>
         <div class="content">
          <?php echo $medicine['m_mfg_by']; ?>
          <div>
           <h6>Expriry Date : <span><?php echo $medicine['m_mfg_date']; ?></span></h6>
          </div>
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
         <h4 class="widget-title">Medicine cart <img style="width:30px;" src="<?php echo SITE_IMAGE_ICON_LOC ?>cart.png" alt=""></h4>
         <div class="cart-table-small">

         </div>
         <div class="widget-search-box">
          <div class="add-cart">
           <button class="btn-view-cart" type="button"><a href="<?php echo $ROOT; ?>myCart.php">VIEW CART</a></button>
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
  viewCart('medicine', 'small_cart');
 </script>
 <?php require("$ROOT" . "includes/footer.php"); ?>