<?php
$ROOT = "../";
require("$ROOT" . "includes/header.php");
?>
<main class="main-content site-wrapper-reveal" style="margin-top: 0px;">
 <!-- search -->
 <div class="container-fluid" style="margin-bottom:28px; padding:0px; margin-right:0;">
  <div class="medicine-search-area">
   <div class="medicine-search-area-child">
    <div class="Home_insideSearchContainer__9TmTk">
     <h1 class="buyMedicineTitle">Buy Medicines and Essentials</h1>
     <div class="Home_searchSelectMain__VL1lN">
      <div class="SearchPlaceholder_searchRoot__LWDXI">
       <i class="icofont-search-1 medicine-search-icon"></i>
       <input id="searchProduct" placeholder="Search Medicines" class="SearchPlaceholder_inputBx__uFLF2">
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>


 <!-- frequently purchased -->
 <section class="container top-items">
  <div class="row d-flex flex-column">
   <div class="col m-2">
    <div class="row d-flex">
     <div class="col text-center position-relative">
      <h4><a href="medicine/allMedicine.php?sort=order_count" class="text-dark">Frequently Purchased</a></h4>
      <div class="view-all-link position-absolute"><a href="allMedicine.php?sort=order_count">View All</a></div>
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
         <a href="medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>" class="v-100 w-100"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $topMedRow['m_image']; ?>" alt=""></a>
        </div>
        <div class="product-details p-2 d-flex flex-column justify-content-end">
         <p>
          <a href="medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>">
           <b><?php echo $topMedRow['m_name']; ?></b>
          </a>
         </p>
         <div class="money d-flex flex-column">
          <p class="text-success fs-6">₹<?php echo $topMedRow['m_price']; ?> Rs/-</p>
          <p class="text-decoration-line-through"> (<?php echo $topMedRow['m_mrp']; ?> Rs/-)</p>
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

 <!-- shop by category -->
 <div class="container GridSection_gridMainSection__vBvkP  initialGridStyle dynamic_section p-4">
  <div class="sectionTop">
   <h4 class="sectionHeading text-center">Shop By Category</h4>
  </div>
  <div class="Grid_grid__sFg6e">
   <?php
   $res = mysqli_query($con, "select * from category where ct_status != 0 and ct_id != 1;");
   while ($row = mysqli_fetch_assoc($res)) {
   ?>
    <!-- loop -->
    <div class="Grid_Item__KaQ4v">
     <div class="OB">
      <a href="allMedicine.php?ct_id=<?php echo $row['ct_id']; ?>" aria-label="<?php echo $row['ct_name']; ?>" class="cardAnchorStyle PB">
       <div class="QB"><img src="<?php echo SITE_IMAGE_CATEGORIES_LOC . $row['ct_image']; ?>" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh"></div>
       <h2 class="ub sb RB Pb"><?php echo $row['ct_name']; ?></h2>
      </a>
     </div>
    </div>
    <!-- loop -->
   <?php
   }
   ?>
   <!-- extra item for all medicine -->
   <div class="Grid_Item__KaQ4v">
    <div class="OB">
     <a href="allMedicine.php" aria-label="View All Medicines" class="cardAnchorStyle PB ">
      <div class="QB"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>allMedicine.png" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh  "></div>
      <h2 class="ub sb RB Pb" style="color:#339999;">View All Medicines</h2>
     </a>
    </div>
   </div>
  </div>
 </div>


 <!-- vitamins -->
 <?php
 $topMedRes = mysqli_query($con, "select m_id, m_image,m_name,m_price,m_mrp from medicine where m_status!=0 and ct_id = 10 limit 10 offset 0");
 if (mysqli_num_rows($topMedRes) > 0) {
 ?>
  <section class="container top-items">
   <div class="row d-flex flex-column">
    <div class="col m-2">
     <div class="row d-flex">
      <div class="col text-center position-relative">
       <h4>Vitamins and Minerals</h4>
       <div class="view-all-link position-absolute"><a href="allMedicine.php?ct_id=10">View All</a></div>
      </div>
     </div>
    </div>
    <div class="col">
     <div class="medi-carousel-container" id="carousel1">
      <div class="medi-carousel mx-4">
       <?php
       while ($topMedRow = mysqli_fetch_assoc($topMedRes)) {
       ?>
        <!-- loop -->
        <div class="single-product medi-carousel-item">
         <div class="d-flex flex-column align-items-center" style="height:125px;">
          <a href="medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $topMedRow['m_image']; ?>" alt=""></a>
         </div>
         <div class="product-details p-2 d-flex flex-column justify-content-end">
          <p>
           <a href="medicine.php?m_id=10">
            <b><?php echo $topMedRow['m_name']; ?></b>
           </a>
          </p>
          <div class="money d-flex flex-column">
           <p class="text-success fs-6">₹<?php echo $topMedRow['m_price']; ?> </p>
           <p class="text-decoration-line-through"> (<?php echo $topMedRow['m_mrp']; ?> Rs/-)</p>
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
 <?php
 }
 ?>



 <!-- new medicines -->
 <section class="container top-items">
  <div class="row d-flex flex-column">
   <div class="col m-2">
    <div class="row d-flex">
     <div class="col text-center position-relative">
      <h4><a href="medicine/allMedicine.php?sort=order_count" class="text-dark">New Medicines</a></h4>
      <div class="view-all-link position-absolute"><a href="allMedicine.php?sort=added_at">View All</a></div>
     </div>
    </div>
   </div>

   <div class="col">
    <div class="medi-carousel-container" id="carousel1">
     <div class="medi-carousel mx-4">
      <?php
      $topMedRes = mysqli_query($con, "select m_id, m_image,m_name,m_price,m_mrp from medicine where m_status!=0 order by m_id desc limit 10 offset 0");
      while ($topMedRow = mysqli_fetch_assoc($topMedRes)) {
      ?>
       <!-- loop -->
       <div class="single-product medi-carousel-item">
        <div class="d-flex flex-column align-items-center" style="height:125px;">
         <a href="medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $topMedRow['m_image']; ?>" alt=""></a>
        </div>
        <div class="product-details p-2 d-flex flex-column justify-content-end">
         <p><a href="medicine.php?m_id=<?php echo $topMedRow['m_id']; ?>">
           <b><?php echo $topMedRow['m_name']; ?></b>
          </a>
         </p>
         <div class="money d-flex flex-column">
          <p class="text-success fs-6">₹<?php echo $topMedRow['m_price']; ?> Rs/-</p>
          <p class="text-decoration-line-through"> (<?php echo $topMedRow['m_mrp']; ?> Rs/-)</p>
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
 <!-- shop by health condition -->
 <div class="container GridSection_gridMainSection__vBvkP  initialGridStyle dynamic_section p-4">
  <div class="sectionTop">
   <h4 class="sectionHeading text-center">Shop By Health Condition</h4>
  </div>
  <div class="Grid_grid__sFg6e">
   <?php
   $res = mysqli_query($con, "select * from specialization where sp_id!=1 and sp_status != 0 and health_concern != '';");
   while ($row = mysqli_fetch_assoc($res)) {
   ?>
    <!-- loop -->
    <div class="Grid_Item__KaQ4v">
     <div class="OB">
      <a href="allMedicine.php?sp_id=<?php echo $row['sp_id']; ?>" aria-label="<?php echo $row['health_concern']; ?>" class="cardAnchorStyle PB ">
       <div class="QB"><img src="<?php echo SITE_IMAGE_SPECIALIZATION_LOC . $row['sp_image']; ?>" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh  "></div>
       <h2 class="ub sb RB Pb"><?php echo $row['health_concern']; ?></h2>
      </a>
     </div>
    </div>
    <!-- loop -->
   <?php
   }
   ?>
   <div class="Grid_Item__KaQ4v">
    <div class="OB">
     <a href="allMedicine.php" class="cardAnchorStyle PB ">
      <div class="QB"><img src="<?php echo SITE_IMAGE_SPECIALIZATION_LOC; ?>specialization.png" alt="Product Image" width="147" height="147" loading="lazy" fetchpriority="low" class="Qh  "></div>
      <h2 class="ub sb RB Pb" style="color:#339999;">View All Medicines</h2>
     </a>
    </div>
   </div>
  </div>
 </div>
 <!-- call us -->
 <div class="container">
  <div class="medicine-search-area">
   <div class="call-us-area-child ">
    <div class="call-us-area_9TmTk">
     <h1 class="call-us-heading text-light">Need Help?</h1>
     <div class="call-us-number">
      <h3 class="text-light">Call Us</h3>
      <h3 class="text-light"><a href="tel:+918327507847" class="text-light">+91-83275-07847</a></h3>
     </div>
    </div>
   </div>
  </div>
 </div>
</main>


<?php
require("$ROOT" . "includes/footer.php");
?>