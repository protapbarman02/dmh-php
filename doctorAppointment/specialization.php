<?php $ROOT = '../';
require($ROOT . "includes/header.php");
if (isset($_GET['sp_id'])) {
  $sp_id = $_GET['sp_id'];
} else {
?>
  <script>
    window.location.href = "index.php";
  </script>
<?php
}
$search = '';
if (isset($_GET['search'])) {
  $search = get_safe_value($con, $_GET['search']);
}
$sp_name = mysqli_fetch_assoc(mysqli_query($con, "select sp_name from specialization where sp_id=$sp_id"))['sp_name'];
$noDoc = 0;
$docArr = [];
$res = mysqli_query($con, "select * from doctor where sp_id=$sp_id and d_name like '%$search%' and d_status!=0");
if (mysqli_num_rows($res) <= 0) {
  $noDoc = 1;
}
while ($row = mysqli_fetch_assoc($res)) {
  $docArr[] = $row;
}
?>
<main class="main-content site-wrapper-reveal">
  <section class="schedule" id="schedule-bar" style="background-color:white;">
    <div class="d-flex flex-column justify-content-between position-relative">
      <div class="position-relative border-bottom border-secondary p-2 mb-2">
        <div class="position-absolute" onclick="cancel_schedule_bar()">
          <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>left-arrow.png" alt="" class="icon-20">
        </div>
        <h4 class="text-center">Appointment Schedule</h4>
      </div>
      <div class="m-2" id="doc_details_bar">

      </div>
    </div>
  </section>

  <section class="page-title-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="page-title-content">
            <div class="bread-crumbs">
              <a href="index.php">Home<span class="breadcrumb-sep">/</span></a>
              <span>Specialists</span><span class="breadcrumb-sep">/</span>
              <span class="active"><?php echo $sp_name; ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- search area -->
  <section class="container p-4 mt-2 theme-bg" id="doc_sp_search_area">
    <form action="" method="get">
      <div class="form-group row">
        <label for="doc-search" class="col-sm-2 col-form-label text-light">Search <?php echo replaceLastY($sp_name); ?> :</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="doc-search" name="search" placeholder="Enter doctor Name">
          <input type="hidden" type="text" name="sp_id" value="<?php echo $sp_id ?>">
        </div>
      </div>
    </form>
  </section>

  <section class="department-area" id="doc_sp_content_area">
    <div class="container">
      <div class="row">
        <?php
        if ($noDoc == 1) {
          echo "<p>Sorry No doctor available in this department</p>";
        } else {
        ?>
          <!-- loop -->
          <?php
          foreach ($docArr as $doc) {
          ?>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 border rounded shadow m-2 p-2">
              <div class="d-flex p-2">
                <div>
                  <div class="single-doc-thumb-cont">
                    <a href="doctor/doctor_appointment.php">
                      <img class="rounded-circle" src="<?php echo SITE_IMAGE_DOCTOR_LOC . $doc['d_image']; ?>" alt="">
                    </a>
                  </div>
                </div>
                <div class="px-2">
                  <p class="theme-color"><b><?php echo $doc['d_name']; ?></b></p>
                  <p class="text-success"><?php echo replaceLastY($sp_name); ?></p>
                  <p class="text-success"><?php echo $doc['d_expernc']; ?> Years Epxp.</p>
                </div>
              </div>

              <div>
                <div class="d-flex align-items-center">
                  <div>
                    <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>school.png" alt="" class="icon-20">
                  </div>
                  <p class="ps-2"><?php echo $doc['d_qualif']; ?></p>
                </div>
                <div class="d-flex align-items-center">
                  <div>
                    <img src="<?php echo SITE_IMAGE_ICON_LOC; ?>hospital.png" alt="" class="icon-20">
                  </div>
                  <p class="ps-2">From <?php echo $doc['d_hospital']; ?></p>
                </div>
                <div class="d-flex align-items-center justify-content-around mt-2">
                  <?php
                  if ($doc['d_online_fee'] != 0) {
                  ?>
                    <button class="theme-border-flat btn btn-light" onclick="getDocBar(<?php echo $doc['d_id']; ?>,'<?php echo $sp_name; ?>')">
                      <div>
                        <p><img src="<?php echo SITE_IMAGE_ICON_LOC; ?>video-camera.png" alt="" class="icon-20"> Consult Online</p>
                        <p class="text-success text-center">₹ <?php echo $doc['d_online_fee']; ?>/-</p>
                      </div>
                    </button>

                  <?php
                  }
                  ?>
                  <?php
                  if ($doc['d_visit_fee'] != 0) {
                  ?>
                    <button class="theme-border-flat btn btn-light" onclick="getDocBar(<?php echo $doc['d_id']; ?>,'<?php echo $sp_name; ?>')">
                      <div>
                        <p><img src="<?php echo SITE_IMAGE_ICON_LOC; ?>doctor-visit.png" alt="" class="icon-20"> Book a Visit</p>
                        <p class="text-success text-center">₹ <?php echo $doc['d_visit_fee']; ?>/-</p>
                      </div>
                    </button>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
          <!-- loop end -->
        <?php
        }
        ?>
      </div>
  </section>
  <script>
    function getDocBar(d_id, sp_name) {
      if (<?php echo $isLoggedIn; ?> == 0) {
        window.location.href = "../login.php";
      } else {
        $("#schedule-bar").css("display", "block");
        $("#doc_sp_content_area").css("opacity", "0.5");
        $("#doc_sp_content_area").css("filter", "blur(2px)");
        $("#doc_sp_search_area").css("opacity", "0.5");
        $("#doc_sp_search_area").css("filter", "blur(2px)");
        $.ajax({
          url: 'getDocBar.php',
          method: 'POST',
          data: 'd_id=' + d_id + '&sp_name=' + sp_name,
          success: function(result) {
            $("#doc_details_bar").html(result);
          }
        });
      }
    }

    function cancel_schedule_bar() {
      $("#schedule-bar").css("display", "none");
      $("#doc_sp_content_area").css("opacity", "1");
      $("#doc_sp_content_area").css("filter", "none");
      $("#doc_sp_search_area").css("opacity", "1");
      $("#doc_sp_search_area").css("filter", "none");
    }

    function viewSchedule(d_id, date, button) {
      $('.date-picker').css('background-color', 'white');
      $('.date-picker').css('color', 'black');
      $(button).css('background-color', '#339999');
      $(button).css('color', 'white');

      $.ajax({
        url: 'viewSchedule.php',
        method: 'POST',
        data: 'd_id=' + d_id + '&date=' + date,
        success: function(result) {
          $('#schedule-container').html(result);
        }
      });
    }

    function time_picker_style_event(d_id, date, button, time, mode) {
      $('.time-picker').css('background-color', 'white');
      $('.time-picker').css('color', 'black');
      $(button).css('background-color', '#339999');
      $(button).css('color', 'white');

      if (($(button).closest('.time-label').next('input[type="hidden"]').val()) != '') {
        $("#apply_appointment_btn").prop("disabled", false)
        $("#appointment-form")[0].reset();

        var customData = {
          "d_id": d_id,
          "date": date,
          "time": time,
          "mode": mode
        };
        var hiddenField = $("<input>")
          .attr("type", "hidden")
          .attr("name", "jsonData")
          .val(JSON.stringify(customData));
        // Append the hidden field to the form
        $("#appointment-form").append(hiddenField);
        // Submit the form
        $("#appointment-form").submit();
      }

    }


    // });
  </script>

</main>
<?php require($ROOT . "includes/footer.php"); ?>