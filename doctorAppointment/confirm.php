<?php $ROOT = '../';
require($ROOT . "includes/header.php");
if (!isset($_POST['default_patient']) && !isset($_POST['new_patient'])) {
?>
  <script>
    window.location.href = "index.php";
  </script>
<?php
  exit();
}
if (!isset($_SESSION['appointment_details'])) {
?>
  <script>
    window.location.href = "index.php";
  </script>
<?php
  exit();
}
if (isset($_POST['default_patient'])) {
  $p_name = $_SESSION['appointment_details']['p_name'];
  $p_dob = $_SESSION['appointment_details']['p_dob'];
  $p_gen = $_SESSION['appointment_details']['p_gen'];
  $p_phn = $_SESSION['appointment_details']['p_phn'];
}
if (isset($_POST['new_patient'])) {
  $p_name = get_safe_value($con, $_POST['new_name']);
  $p_gen = get_safe_value($con, $_POST['new_gen']);
  $p_dob = get_safe_value($con, $_POST['new_dob']);
  $p_phn = get_safe_value($con, $_POST['new_phn']);
}
$doc_a_note = get_safe_value($con, $_POST['a_desc']);
$d_id = $_SESSION['appointment_details']['d_id'];
$doc_a_mode = $_SESSION['appointment_details']['mode'];
$d_shift_time = $_SESSION['appointment_details']['time'];
$doc_a_date = $_SESSION['appointment_details']['date'];
$doc_a_time = $_SESSION['appointment_details']['doc_a_time'];
$sl_no = $_SESSION['appointment_details']['sl_no'];
$p_email = $_SESSION['appointment_details']['p_email'];
$fee = $_SESSION['appointment_details']['fee'];

mysqli_query($con, "INSERT INTO `doc_appointment` (`p_id`, `p_name`, `p_email`, `p_phn`, `p_dob`, `p_gender`, `d_id`, `doc_a_note`, `d_shift_time`, `doc_a_create_time`, `doc_a_date`, `doc_a_time`, `doc_a_mode`, `doc_a_fee`,`doc_a_status`) 
VALUES ({$_SESSION['uid']}, '$p_name', '$p_email', '$p_phn', '$p_dob', '$p_gen', '$d_id', '$doc_a_note', '$d_shift_time', current_timestamp(), '$doc_a_date', '$doc_a_time', '$doc_a_mode',$fee, 'confirmed')")

?>
<?php
if ($doc_a_mode == 'online') {
  $msg = '<p><span class="text-danger">***</span>Your online consultation will take place via WhatsApp video call on your given Phone No. Please ensure you are ready at the scheduled appointment time.</p>';
  $a_mode = 'Online Consult';
} else if ($doc_a_mode == 'offline') {
  $msg = '<p><span class="text-danger">***</span>Please arrive at the AROGYA doctor\'s chamber before your scheduled appointment time.</p>';
  $a_mode = 'Chamber Visit';
}
?>
<?php
$res = mysqli_query($con, "select d_name,d_qualif,d_expernc from doctor where d_id=$d_id");
while ($row = mysqli_fetch_assoc($res)) {
  $d_name = $row['d_name'];
  $d_qualif = $row['d_qualif'];
  $d_expernc = $row['d_expernc'];
}
?>
<main class="main-content site-wrapper-reveal">

  <div class="container">
    <h5 class="text-success text-center">Your appointment is Confirmed</h5>
    <div id="appointment_details" class="border rounded shadow p-4 m-4 w-80">
      <div class="row">
        <div class="col-4">
          Date : <?php echo date("Y-m-d H:i:s"); ?>
        </div>
        <div class="col-4">
          <img src="../assets/img/others/logo-small.jpg" style="height:50px;">
        </div>
        <div class="col-4 text-end">
          <h4>Diagnostics and Medicine Hub</h4>
          <p>Opposite Sitalkuchi Block Hospital</p>
          <p>Sitalkuchi,Cooch Behar</p>
          <p>West Bengal,736158</p>
          <p><a href="mailto:protapb303@gmail.com">protapb303@gmail.com</a></p>
        </div>
      </div>
      <div class="row">
        <p class="text-dark fs-5">Dear <?php echo $p_name; ?>,</p>
        <h5>You are scheduled for an appointment,</h5>
      </div>
      <div class="row">
        <div class="col-6">
          <h6>With :</h6>
          <p class="fs-6 fw-bold text-dark"><span class="text-dark"><?php echo $d_name; ?></span></p>
          <p class="fs-6 fw-bold text-dark"><span>(<?php echo $d_qualif; ?>)</span></p>
          <p class="fs-6 fw-bold text-dark"><span><?php echo $d_expernc; ?> Years Exp.</span></p>
          <h6>At :</h6>
          <p class="fs-6 fw-bold text-dark"><span>Date : </span><span><?php echo $doc_a_date; ?></span></p>
          <p class="fs-6 fw-bold text-dark"><span>Time : </span><span><?php echo $doc_a_time; ?></span></p>
          <p class="fs-6 fw-bold text-dark"><span>Mode : </span><span><?php echo $a_mode; ?></span></p>
          <p class="fs-6 fw-bold text-dark"><span>Sl No. : </span><span><?php echo $sl_no; ?></span></p>
          <h6>Fees : <?php echo $fee; ?></h6>
        </div>
        <?php echo $msg; ?>
      </div>
    </div>
  </div>

</main>

<script src="../assets/js/html2canvas.js"></script>
<script src="../assets/js/jspdf.umd.min.js"></script>
<script>
  $(document).ready(function() {
    window.jsPDF = window.jspdf.jsPDF;

    function Convert_HTML_To_PDF() {
      var doc = new jsPDF();
      var elementHTML = document.querySelector("#appointment_details");
      html2canvas(elementHTML).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 10, 10, 180, 0);
        doc.save('appointment_confirmation.pdf');
      });
    }
    Convert_HTML_To_PDF();
  })
</script>

<?php
unset($_SESSION['appointment_details']);
require($ROOT . "includes/footer.php"); ?>