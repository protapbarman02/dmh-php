<?php $ROOT = '';
require("includes/header.php");
$sp_array = [];
if (isset($_GET['sp_id'])) {
  $sp_id = $_GET['sp_id'];
} else {
  $sp_id = 2;
}
$res = mysqli_query($con, "select * from specialization where sp_id=$sp_id");
while ($row = mysqli_fetch_assoc($res)) {
  $sp_array[] = $row;
}

?>
<main class="main-content site-wrapper-reveal">
  <section class="page-title-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="page-title-content">
            <div class="bread-crumbs">
              <a href="index.php">Home<span class="breadcrumb-sep">/</span></a>
              <span class="active">Specialization</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="department-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="department-wrpp">
            <div class="sidebar-wrapper">
              <div class="widget-item">
                <h4 class="widget-title">Specializations</h4>
                <div class="widget-side-nav">
                  <ul>
                    <?php
                    $res = mysqli_query($con, "select sp_id,sp_name from specialization where sp_id !=1 and sp_status!=0");
                    while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                      <li>
                        <a href="specialization.php?sp_id=<?php echo $row['sp_id']; ?>" <?php if ($row['sp_id'] == $sp_id) {
                                                                                          echo 'class="active"';
                                                                                        } ?>>
                          <?php echo $row['sp_name']; ?>
                        </a>
                      </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
            <div style="display:flex;flex-direction:column;">

              <?php
              foreach ($sp_array as $sp) {
              ?>
                <div class="department-content">
                  <h2 class="title mb-2 p-2"><?php echo $sp['sp_name']; ?></h2>
                  <div style="height:150px;width:150px;">
                    <img src="<?php echo SITE_IMAGE_SPECIALIZATION_LOC . $sp['sp_image']; ?>" alt="spec" style="width:100%;">
                  </div>
                  <div class="content">
                    <p><?php echo $sp['sp_descr']; ?></p>
                  </div>
                </div>

                <?php
                $res = mysqli_query($con, "select d_id,d_name,d_image,d_expernc,d_visit_fee from doctor where sp_id=$sp_id and d_status!=0");
                if (mysqli_num_rows($res) > 0) {
                ?>
                  <div class="department-content">
                    <h2 class="title mb-2 p-2">Specialists</h2>
                    <div class="all-cards px-4">
                      <!-- loop -->
                      <?php
                      while ($row = mysqli_fetch_assoc($res)) {
                      ?>
                        <div class="single-card mx-2">
                          <div class="single-card-img-cont">
                            <a href="doctorAppointment/specialization.php?sp_id=<?php echo $sp_id; ?>">
                              <img src="<?php echo SITE_IMAGE_DOCTOR_LOC . $row['d_image']; ?>" alt="">
                            </a>
                          </div>
                          <p><a href=""><?php echo $row['d_name']; ?></a></p>
                          <p><?php echo replaceLastY($sp['sp_name']); ?></p>
                          <p>Experience : <?php echo $row['d_expernc']; ?> Years</p>
                          <!-- <p class="text-success fs-6">Fee : <?php //echo $row['d_visit_fee'];
                                                                  ?> Rs/-</p> -->
                        </div>
                      <?php
                      }
                      ?>
                      <!-- loop end -->
                    </div>
                  </div>
                <?php
                }
                ?>
            </div>
          <?php
              }
          ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php require("includes/footer.php"); ?>