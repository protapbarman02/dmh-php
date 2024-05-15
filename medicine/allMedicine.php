<?php
$ROOT = '../';
require("$ROOT" . "includes/header.php");
// Define filtering, sorting, search, and pagination variables
$category = isset($_GET['ct_id']) ? $_GET['ct_id'] : '';
$sub_category = isset($_GET['m_sc_id']) ? $_GET['m_sc_id'] : '';
$type = isset($_GET['mt_id']) ? $_GET['mt_id'] : '';
$specialization = isset($_GET['sp_id']) ? $_GET['sp_id'] : '';
$dosage_type = isset($_GET['dosage_type']) ? $_GET['dosage_type'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'm_id';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 20; // Items per page

// Call the function to retrieve filtered and paginated medicines
$data = getFilteredMedicines($con, $category, $sub_category, $type, $specialization, $dosage_type, $search_query, $sort_by, $page, $limit);
$medicines = $data['medicines'];
$total_pages = $data['total_pages'];
?>

<main class="main-content site-wrapper-reveal" style="margin-top: 0px;">
 <section class="page-title-area">
  <div class="container">
   <div class="row">
    <div class="col-lg-12">
     <div class="page-title-content content-style3">
      <div class="bread-crumbs bread-crumbs-style2">
       <a href="index.php">Home<span class="breadcrumb-sep">/</span></a><a href="allMedicine.php" class="active text-success">All Medicines<span class="breadcrumb-sep">/</span></a>
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>
 <div class="container">
  <div class="row">
   <div class="col-xl-9 col-lg-9 col-12">
    <div class="filter-bar align-items-center">
     <div class="contaner d-flex justify-content-between filters p-2">
      <div>
       <div class="dropdown">
        <button class="dropdown-toggle filter-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
         Filter By : Dosage Type
        </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => ''])); ?>">All</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Syrup'])); ?>">Syrup</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Injection'])); ?>">Injection</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Lotion'])); ?>">Lotion</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Tablet'])); ?>">Tablet</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Drop'])); ?>">Drop</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Capsule'])); ?>">Capsule</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Inhaler'])); ?>">Inhaler</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Patches'])); ?>">Patches</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Sublingual'])); ?>">Sublingual</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Oral'])); ?>">Oral</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['dosage_type' => 'Others'])); ?>">Others</a></li>
        </ul>
       </div>
      </div>
      <div>
       <div class="dropdown">
        <button class="dropdown-toggle filter-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
         Sort By
        </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['sort_by' => 'm_id desc'])); ?>">Default: Latest</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['sort_by' => 'm_price asc'])); ?>">Price ⬇ (Low to High)</a></li>
         <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($_GET, ['sort_by' => 'm_price desc'])); ?>">Price ⬆ (High to Low)</a></li>
        </ul>
       </div>
      </div>
     </div>

     <!-- End Filter Bar -->
     <!-- Start Best Seller -->
     <div class="row">
      <div class="col">
       <section class="lattest-product-area pb-40 category-list">
        <div class="row pt-2">
         <?php
         if (empty($medicines)) {
          echo "0 results";
         } else {
          foreach ($medicines as $medicine) {
         ?>
           <!-- single product -->
           <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="single-product mb-2 d-flex flex-column justify-content-between v-100">
             <div>
              <?php
              if ($medicine['m_image'] != '') {
              ?>
               <a href="medicine.php?m_id=<?php echo $medicine['m_id']; ?>"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $medicine['m_image']; ?>" alt="medicine" style="height:125px;"></a>
              <?php
              } else {
              ?>
               <a href="medicine.php?m_id=<?php echo $medicine['m_id']; ?>"><img src="<?php echo SITE_IMAGE_MEDICINE_LOC; ?>allMedicine.png" alt="medicine"></a>
              <?php
              }
              ?>
              <a href="" class="mcart-icon">
               <img src="" alt="">
              </a>
             </div>

             <div class="product-details">
              <h6><a style="color:black; text-transform:none;" href="medicine.php?m_id=<?php echo $medicine['m_id']; ?>"><?php echo $medicine['m_name']; ?></a></h6>
              <div class="mprice">
               <h6 class="text-decoration-line-through">MRP <?php echo $medicine['m_mrp']; ?> Rs/-</h6>
               <p class="fs-6 text-success">₹ <?php echo $medicine['m_price']; ?> Rs/-</p>
              </div>

             </div>
            </div>
           </div>
         <?php }
         }
         ?>

         <!-- <div class="pagination-area mb-md-80">
                                        <nav>
                                            <ul class="page-numbers">
                                                <?php //for ($i = 1; $i <= 3; $i++) {
                                                ?>
                                                    <li><a class='page-number' href='?<?php //echo http_build_query(array_merge($_GET['page'] = $i)); 
                                                                                      ?>'>$i</a></li>"
                                                <?php
                                                // }
                                                ?>
                                            </ul>
                                        </nav>
                                    </div> -->
         <div class="pagination-area mb-md-80">
          <nav>
           <ul class="page-numbers">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
             echo '<li><a class="page-number" href="?page=' . $i . generateQueryString() . '">' . $i . '</a></li>';
            }
            ?>
           </ul>
          </nav>
          <?php
          // Function to generate URL query string from existing filters and sorting options
          function generateQueryString()
          {
           $query_string = '';
           $filter_params = ['category', 'sub_category', 'type', 'specialization', 'dosage_type', 'search', 'sort_by', 'sort_order'];
           foreach ($filter_params as $param) {
            if (!empty($_GET[$param])) {
             $query_string .= '&' . $param . '=' . $_GET[$param];
            }
           }
           return $query_string;
          }
          ?>
         </div>

        </div>
       </section>
      </div>
     </div>
    </div>
   </div>
   <div class="col-xl-3 col-lg-3 col-12">
    <div class="sidebar-categories">
     <div class="widget-item border-bottom">
      <div class="head mb-2">Search Medicine</div>
      <div class="widget-search-box">
       <form action="" method="get">
        <input type="text" id="search" name="search" placeholder="Enter Medicine Name">
       </form>
      </div>
     </div>
    </div>
    <div class="sidebar-categories" style="margin-top: 50px;">
     <div class="head">Browse By Category</div>
     <ul class="main-categories">
      <?php
      $ct_res = mysqli_query($con, "select ct_id,ct_name from category where ct_id != 1 and ct_status!=0;");
      while ($ct_row = mysqli_fetch_assoc($ct_res)) {
      ?>
       <li class="main-nav-list">
        <a data-bs-toggle="collapse" href="#collapseExample<?php echo $ct_row['ct_id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo $ct_row['ct_name']; ?></a>
        <ul class="collapse main-nav-list-child-ul" id="collapseExample<?php echo $ct_row['ct_id']; ?>">
         <li class="main-nav-list child"><a href="?ct_id=<?php echo $ct_row['ct_id']; ?>">Show All<span class="number"></li>
         <?php
         $sub_ct_res = mysqli_query($con, "select m_sc_id,m_sc_name from medicine_sub_category where ct_id={$ct_row['ct_id']}");
         while ($sub_ct = mysqli_fetch_assoc($sub_ct_res)) {
         ?>
          <li class="main-nav-list child"><a href="?ct_id=<?php echo $ct_row['ct_id']; ?>&m_sc_id=<?php echo $sub_ct['m_sc_id']; ?>"><?php echo $sub_ct['m_sc_name']; ?><span class="number"></li>
         <?php
         }
         ?>
        </ul>
       </li>
      <?php
      }
      ?>
     </ul>
    </div>
    <div class="sidebar-categories" style="margin-top: 50px;">
     <div class="head">Browse By Health Concern</div>
     <ul class="main-categories">
      <?php
      $sp_res = mysqli_query($con, "select sp_id,health_concern from specialization where sp_id !=1 and sp_status !=0;");
      while ($sp_row = mysqli_fetch_assoc($sp_res)) {
      ?>
       <li class="main-nav-list"><a href="?sp_id=<?php echo $sp_row['sp_id']; ?>"><?php echo $sp_row['health_concern']; ?></a></li>
      <?php
      }
      ?>
     </ul>
    </div>
    <div class="sidebar-categories" style="margin-top: 50px;">
     <div class="head">Browse By Type</div>
     <ul class="main-categories">
      <?php
      $mt_res = mysqli_query($con, "select mt_id,mt_name from medicine_type where mt_id !=1");
      while ($mt_row = mysqli_fetch_assoc($mt_res)) {
      ?>
       <li class="main-nav-list"><a href="?mt_id=<?php echo $mt_row['mt_id']; ?>"><?php echo $mt_row['mt_name']; ?></a></li>
      <?php
      }
      ?>
     </ul>
    </div>
   </div>
  </div>
 </div>
</main>
<script>
 viewCart('test', 'small_cart');
</script>
<?php require("$ROOT" . "includes/footer.php"); ?>