<?php $ROOT = '../';
require($ROOT . "includes/header.php");
if (isset($_SESSION['cancel'])) {
 unset($_SESSION['cancel']);
?>
 <script>
  window.location.href = "index.php";
 </script>
<?php
 exit();
}
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['jsonData'])) {
 $_SESSION['cancel'] = 1;
?>
 <script>
  window.location.href = "index.php";
 </script>
<?php
 exit();
}
$jsonData = $_POST['jsonData'];
$customData = json_decode($jsonData, true);
$_SESSION['appointment_details'] = $customData;
$msg = '';
$d_id = $customData['d_id'];
$mode = $customData['mode'];
$time = $customData['time'];
$date = $customData['date'];
$schedules = [];
$res = mysqli_query($con, "select * from doc_schedule where d_id=$d_id and sc_shift_type='$mode' and sc_status!=0");
while ($row = mysqli_fetch_assoc($res)) {
 $schedules[] = $row;
}
foreach ($schedules as $schedule) {
 $isScheduleAvailable = false;
 calculateTotalTime($schedule['sc_shift_start'], $schedule['sc_shift_end']);
 $patient_eligib_count = calculatePatients(calculateTotalTime($schedule['sc_shift_start'], $schedule['sc_shift_end']), $schedule['sc_patient_duration']);
 $total_doc_appointment = mysqli_query($con, "select doc_a_id from doc_appointment where d_id=$d_id and doc_a_mode='$mode' and d_shift_time='$time' and doc_a_date='$date'");
 if (mysqli_num_rows($total_doc_appointment) < $patient_eligib_count) {
  $sno = mysqli_num_rows($total_doc_appointment) + 1;
  $estimate_time_unformatted = addMinutesToTime($schedule["sc_shift_start"], $schedule['sc_patient_duration'] * ($sno - 1)); //submit to db
  $estimate_time = convertTo12HourFormat($estimate_time_unformatted);
  $isScheduleAvailable = true;
  $_SESSION['appointment_details']['doc_a_time'] = $estimate_time_unformatted;
  $_SESSION['appointment_details']['sl_no'] = $sno;
 } else if (mysqli_num_rows($total_doc_appointment) == $patient_eligib_count) {
  $msg = "Sorry Appointment list is full, please try again tomorrow";
 }
}

$doctor_details = [];
$res = mysqli_query($con, "select d_online_fee,d_visit_fee,doctor.d_image,doctor.d_name, doctor.sp_id, doctor.d_hospital,specialization.sp_name from doctor inner join specialization on doctor.sp_id=specialization.sp_id where doctor.d_id=$d_id");
while ($row = mysqli_fetch_assoc($res)) {
 $d_image = $row['d_image'];
 $d_online_fee = $row['d_online_fee'];
 $d_visit_fee = $row['d_visit_fee'];
 $doctor_details[] = $row;
}
if ($mode == 'online') {
 $a_type_front_end = "Online Consult";
 $fee = $d_online_fee;
} else if ($mode == 'offline') {
 $a_type_front_end = "Chamber Visit";
 $fee = $d_visit_fee;
}
$user_details = [];
$res = mysqli_query($con, "select * from patient where p_id={$_SESSION['uid']} and p_status!=0");
while ($row = mysqli_fetch_assoc($res)) {
 $user_details[] = $row;
}
?>
<main class="main-content site-wrapper-reveal">

 <section class="checkout_area my-4">
  <div class="container">
   <form action="confirm.php" class="contact-form" method="post" id="order_form">
    <div class="billing_details">
     <div class="row">
      <div class="col-lg-6">
       <div class="mb-4">
        <h2>Patient Details</h2>

        <div class="default-address">
         <?php
         foreach ($user_details as $user) {
         ?>
          <div class="div border p-2">
           <p><span class="text-dark">Name :</span> <?php echo $user['p_name']; ?></p>
           <?php $_SESSION['appointment_details']['p_name'] = $user['p_name']; ?>
           <p><span class="text-dark">Age :</span> <?php echo age($user['p_dob']); ?> Years</p>
           <?php $_SESSION['appointment_details']['p_dob'] = $user['p_dob']; ?>
           <p><span class="text-dark">Gender :</span> <?php echo $user['p_gen']; ?></p>
           <?php $_SESSION['appointment_details']['p_gen'] = $user['p_gen']; ?>
           <p><span class="text-dark">Phone No. :</span> <?php echo $user['p_phn']; ?></p>
           <?php $_SESSION['appointment_details']['p_phn'] = $user['p_phn']; ?>
           <p><span class="text-dark">Email Addr. :</span> <?php echo $user['p_email']; ?></p>
           <?php $_SESSION['appointment_details']['p_email'] = $user['p_email']; ?>

          </div>

         <?php
         }
         ?>
        </div>
        <?php
        ?>
       </div>

       <div class="col-md-12 mt-4">
        <div class="form-check form-switch">
         <input class="form-check-input" type="checkbox" id="f-option3" name="selector" checked>
         <label class="form-check-label" for="f-option3">
          <h3>I am the patient</h3>
         </label>
        </div>
       </div>
       <div class="row hidden-new-address border rounded p-2" id="new_address">
        <b>Patient Details : </b>
        <div class="col-md-6 form-group">
         <input type="text" class="form-control" id="name" name="new_name" placeholder="Full Name">
        </div>
        <div class="col-md-6 form-group ">
         <input type="number" class="form-control" id="phone" name="new_phn" placeholder="Phone Number">
        </div>
        <div class="col-md-6 form-group">
         <label for="dob">Date of Birth : </label>
         <input type="date" class="form-control" id="dob" name="new_dob">
        </div>
        <div class="col-md-6 form-group">
         <label for="gen">Gender : </label>
         <select name="new_gen" id="gen">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Others">Others</option>
         </select>
        </div>
       </div>
       <div class="my-4">
        <label for="a_desc" class="form-label fs-6 fw-bold text-dark">Describe your problem in short if you want</label>
        <textarea class="form-control" name="a_desc" id="a_desc" rows="3">Write here...</textarea>
       </div>
      </div>
      <div class="col-lg-6">
       <div class="order_box">
        <h2 class="text-center"><b>Doctor Details</b></h2>
        <div class="border p-4 d-flex" id="doc-side-profile">
         <div class="single-doc-thumb-cont">
          <img src="<?php echo SITE_IMAGE_DOCTOR_LOC . $d_image; ?>" alt="" class="rounded-circle">
         </div>
         <div class="ms-2">
          <?php
          foreach ($doctor_details as $doctor) {
          ?>
           <p class="text-light"><b><?php echo $doctor['d_name']; ?></b></p>
           <p class="text-dark"><?php echo replaceLastY($doctor['sp_name']); ?></p>
           <p class="text-dark"><?php echo $doctor['d_hospital']; ?></p>
          <?php
          }
          ?>
         </div>
        </div>
        <?php
        if (!$msg == '') {
         echo "<p>.$msg.</p>";
        } else {
        ?>
         <h2 class="text-center mt-4"><b>Appointment Details</b></h2>
         <div class="d-flex justify-content-between">
          <div>
           <p class="text-light">Time</p>
           <p class="text-light">Date</p>
           <p class="text-light">Mode</p>
           <p class="text-light">Sl No.</p>
          </div>
          <div>
           <p><b class="text-light">:</b></p>
           <p><b class="text-light">:</b></p>
           <p><b class="text-light">:</b></p>
           <p><b class="text-light">:</b></p>
          </div>
          <div>
           <p class="text-light"><?php echo $estimate_time; ?></p>
           <p class="text-light"><?php echo $date; ?></p>
           <p class="text-light"><?php echo $a_type_front_end; ?></p>
           <p class="text-light"><?php echo $sno; ?></p>
          </div>
         </div>
         <div class="payment_item">
          <?php
          if ($mode == 'online') {
           echo '<p>Your online consultation will take place via WhatsApp video call on your given Phone No. Please ensure you are ready at the scheduled appointment time.</p>';
          } else if ($mode == 'offline') {
           echo '<p>Please arrive at the AROGYA doctor\'s chamber before your scheduled appointment time.</p>';
          }
          ?>
         </div>
         <p><b class="text-dark">Fees :</b> <span class="text-light"><?php echo $fee; ?> Rs/-</span></p>
         <?php $_SESSION['appointment_details']['fee'] = $fee; ?>
         <div class="form-check form-switch my-2">
          <input class="form-check-input" type="checkbox" id="f-option7" name="payment_type" value="pay_later" required checked>
          <label class="form-check-label f-option-black" for="f-option7">
           <h6>Pay Later</h6>
          </label>
         </div>

         <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="f-option8" name="terms" value="pay_later" required>
          <label class="form-check-label f-option-black" for="f-option8">
           <h6>I’ve read and accept the </h6>
          </label>
          <a href="#" class="text-light">terms & conditions*</a>
         </div>
        <?php
        }
        ?>
        <div class="row">
         <div class="col-6">
          <button type="button" class="btn confirm-btn">
           <a href="<?php echo $ROOT; ?>index.php">Cancel</a>
          </button>
         </div>
         <?php
         if ($msg == '') {
          echo '
                                    <div class="col-6">
                                        <button type="submit" name="default_patient" class="btn confirm-btn" id="confirm_btn">Confirm</button>
                                    </div>
                                    ';
         }
         ?>
        </div>
       </div>
      </div>
     </div>
    </div>
   </form>
  </div>
 </section>
</main>
<script>
 $(document).ready(() => {
  $('#f-option3').change(function() {
   if ($(this).is(':checked')) {
    $('#new_address').addClass('hidden-new-address');
    $('#new_address input, #new_address select').prop('required', false);
    $('#confirm_btn').attr('name', 'default_patient');
   } else {
    $('#new_address').removeClass('hidden-new-address');
    $('#new_address input, #new_address select').prop('required', true);
    $('#confirm_btn').attr('name', 'new_patient');
   }
  });

 })
</script>
<?php require($ROOT . "includes/footer.php"); ?>