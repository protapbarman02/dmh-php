<?php
$ROOT = "../";
require("nav.php");

//schedule
$online = 0;
$offline = 0;
$res = mysqli_query($con, "select sc_shift_start,sc_shift_end from doc_schedule where d_id=$d_id and sc_shift_type='online'");
if (mysqli_num_rows($res) > 0) {
  $online = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    $online_shift_start = $row['sc_shift_start'];
    $online_shift_end = $row['sc_shift_end'];
  }
}
$res = mysqli_query($con, "select sc_shift_start,sc_shift_end from doc_schedule where d_id=$d_id and sc_shift_type='offline'");
if (mysqli_num_rows($res) > 0) {
  $offline = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    $offline_shift_start = $row['sc_shift_start'];
    $offline_shift_end = $row['sc_shift_end'];
  }
}
//appointments
$offline_appointments_available = 0;
$online_appointments_available = 0;
$offline_appointments = [];
$online_appointments = [];
$total_p_count = 0;
$res = mysqli_query($con, "select doc_appointment.p_id,doc_appointment.p_name,doc_appointment.p_phn,doc_appointment.doc_a_time,doc_appointment.doc_a_status,patient.p_image from doc_appointment inner join patient on doc_appointment.p_id=patient.p_id WHERE doc_appointment.d_id=$d_id and doc_appointment.doc_a_date = CURRENT_DATE and doc_appointment.doc_a_mode='offline' ORDER BY CAST(doc_appointment.doc_a_time AS TIME) DESC");
$total_p_count += mysqli_num_rows($res);
if (mysqli_num_rows($res) > 0) {
  $offline_appointments_available = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    $offline_appointments[] = $row;
  }
}
$res = mysqli_query($con, "select doc_appointment.p_id,doc_appointment.p_name,doc_appointment.p_phn,doc_appointment.doc_a_time,doc_appointment.doc_a_status,patient.p_image from doc_appointment inner join patient on doc_appointment.p_id=patient.p_id WHERE doc_appointment.d_id=$d_id and doc_appointment.doc_a_date = CURRENT_DATE and doc_appointment.doc_a_mode='online' ORDER BY CAST(doc_appointment.doc_a_time AS TIME) DESC");
$total_p_count += mysqli_num_rows($res);
if (mysqli_num_rows($res) > 0) {
  $online_appointments_available = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    $online_appointments[] = $row;
  }
}
?>
<section class="admin-right-panel" style="background-color:white;">
  <div class="d-flex justify-content-between bg-light m-0 px-4 top-bar-doc">
    <p><a href="index.php" class="text-dark text-decoration-none">DASHBOARD</a></p>
    <p><?php echo date('l, F jS Y'); ?></p>
  </div>
  <div class="container">
    <div class="d-flex align-items-center justify-content-center position-relative">
      <div class="px-4">
        <p class="fs-3 my-2"><b class="text-info ">Welcome,</b> <?php echo $d_name; ?> !</p>
        <p class="fs-5">You have <b><?php echo $total_p_count; ?> patients</b> remaining today</p>
      </div>
      <div class="px-4">
        <img src="<?php echo SITE_IMAGE_DOCTOR_LOC; ?>steth.jpg" class="index-top-steth" alt="">
      </div>
      <div class="position-absolute end-0 top-20 p-2 border shadow rounded" id="schedule-float">
        <p class="fs-5 text-center border-bottom">📌 My schedule</p>
        <?php
        if ($online == 1) {
        ?>
          <div class="p-1 border-bottom my-1">
            <p>📱 Online Consultation</p>
            <p><?php echo convertTo12HourFormat($online_shift_start); ?> ---- <?php echo convertTo12HourFormat($online_shift_end); ?></p>
          </div>
        <?php
        }
        if ($offline == 1) {
        ?>
          <div class="p-1">
            <p>🪑 Chamber Attend</p>
            <p><?php echo convertTo12HourFormat($offline_shift_start); ?> ---- <?php echo convertTo12HourFormat($offline_shift_end); ?></p>
          </div>
        <?php
        }
        ?>

      </div>
    </div>

    <?php if ($total_p_count > 0) { ?>
      <div class="my-4">
        <p class="fs-4">Todays upcoming appointments</p>
        <div class="d-flex flex-col-media">
          <?php
          $res = mysqli_query($con, "select doc_appointment.p_id,doc_appointment.p_name,doc_appointment.p_phn,doc_appointment.doc_a_time,doc_appointment.doc_a_status,patient.p_image from doc_appointment inner join patient on doc_appointment.p_id=patient.p_id WHERE doc_appointment.d_id=$d_id and doc_appointment.doc_a_date = CURRENT_DATE and doc_appointment.doc_a_mode='online' AND CAST(doc_appointment.doc_a_time AS TIME) < CURRENT_TIME ORDER BY CAST(doc_appointment.doc_a_time AS TIME) DESC");
          if (mysqli_num_rows($res) > 0) {
          ?>
            <div class="schedule-vertical p-4 m-2">
              <p class="fs-6">Online Consultation</p>
              <table class="m-2 p-4" style="width:100%;">
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_assoc($res)) {
                  ?>
                    <tr class="schedule-single">
                      <td class="p-2"><img src="<?php echo SITE_IMAGE_PATIENT_LOC . $row['p_image']; ?>" alt="" style="height:30px;width:30px;" class="border rounded-circle"></td>
                      <td class="p-2"><?php echo $row['p_name']; ?></td>
                      <td class="p-2"><?php echo convertTo12HourFormat($row['doc_a_time']); ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          <?php
          }
          ?>
          <?php
          $res = mysqli_query($con, "select doc_appointment.p_id,doc_appointment.p_name,doc_appointment.p_phn,doc_appointment.doc_a_time,doc_appointment.doc_a_status,patient.p_image from doc_appointment inner join patient on doc_appointment.p_id=patient.p_id WHERE doc_appointment.d_id=$d_id and doc_appointment.doc_a_date = CURRENT_DATE and doc_appointment.doc_a_mode='offline' AND CAST(doc_appointment.doc_a_time AS TIME) < CURRENT_TIME ORDER BY CAST(doc_appointment.doc_a_time AS TIME) DESC");
          if (mysqli_num_rows($res) > 0) {
          ?>
            <div class="schedule-vertical p-4 m-2">
              <p class="fs-6">In Chamber</p>
              <table class="m-2 p-4" style="width:100%;">
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_assoc($res)) {
                  ?>
                    <tr class="schedule-single">
                      <td class="p-2"><img src="<?php echo SITE_IMAGE_PATIENT_LOC . $row['p_image']; ?>" alt="" style="height:30px;width:30px;" class="border rounded-circle"></td>
                      <td class="p-2"><?php echo $row['p_name']; ?></td>
                      <td class="p-2"><?php echo convertTo12HourFormat($row['doc_a_time']); ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
    <div class="today-appointment-doc">
      <p class="fs-5">Todays Appointments List</p>
      <div class="d-flex flex-col-media">
        <div class="schedule-vertical p-4 m-2">
          <p class="fs-6">Online Consultation</p>
          <table class="m-2 p-4" style="width:100%;">
            <tbody>
              <?php
              if ($online_appointments_available == 1) {
                foreach ($online_appointments as $online_appointment) {
              ?>
                  <tr class="schedule-single">
                    <td class="p-2"><img src="<?php echo SITE_IMAGE_PATIENT_LOC . $online_appointment['p_image']; ?>" alt="" style="height:30px;width:30px;" class="border rounded-circle"></td>
                    <td class="p-2"><?php echo $online_appointment['p_name']; ?></td>
                    <td class="p-2"><?php echo convertTo12HourFormat($online_appointment['doc_a_time']); ?></td>
                  </tr>
              <?php
                }
              } else {
                echo "<tr><td>Empty</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="schedule-vertical p-4 m-2">
          <p class="fs-6">In Chamber</p>
          <table class="m-2 p-4" style="width:100%;">
            <tbody>
              <?php
              if ($offline_appointments_available == 1) {
                foreach ($offline_appointments as $offline_appointment) {
              ?>
                  <tr class="schedule-single">
                    <td class="p-2"><img src="<?php echo SITE_IMAGE_PATIENT_LOC . $offline_appointment['p_image']; ?>" alt="" style="height:30px;width:30px;" class="border rounded-circle"></td>
                    <td class="p-2"><?php echo $offline_appointment['p_name']; ?></td>
                    <td class="p-2"><?php echo convertTo12HourFormat($offline_appointment['doc_a_time']); ?></td>
                  </tr>
              <?php
                }
              } else {
                echo "<tr><td>Empty</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</section>
</main>
<?php
require("$ROOT" . "admin/includes/footer.php");
?>