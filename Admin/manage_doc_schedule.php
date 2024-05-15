<?php $ROOT = "../";
require($ROOT . "includes/db.inc.php");

if (isset($_GET['type']) && ($_GET['type'] == 'status')) {
  $sc_id = $_GET['sc_id'];
  $d_id = $_GET['d_id'];
  $operation = $_GET['operation'];
  if ($operation == 'active') {
    $res = mysqli_query($con, "select d_online_fee,d_visit_fee from doctor where d_id=$d_id");
    while ($row = mysqli_fetch_assoc($res)) {
      $d_online_fee = $row['d_online_fee'];
      $d_visit_fee = $row['d_visit_fee'];
    }
    if ($_GET['shift'] == 'online') {
      if ($d_online_fee == 0 || $d_online_fee == '0') {
?>
        <script>
          alert("please set online consult fee before activating the shift");
          window.location.href = "doc_schedule.php?d_id=<?php echo $d_id; ?>";
        </script>
      <?php
        exit();
      } else {
        $status = '1';
      }
    } else if ($_GET['shift'] == 'offline') {
      if ($d_visit_fee == 0 || $d_visit_fee == '0') {
      ?>
        <script>
          alert("please set offline visit fee before activating the shift");
          window.location.href = "doc_schedule.php?d_id=<?php echo $d_id; ?>";
        </script>

  <?php
        exit();
      } else {
        $status = '1';
      }
    }
  } else {
    $status = '0';
  }
  $update_status_sql = "update doc_schedule set sc_status=$status where sc_id=$sc_id";
  mysqli_query($con, $update_status_sql);
  ?>
  <script>
    window.location.href = "doc_schedule.php?d_id=<?php echo $d_id; ?>";
  </script>
<?php
  exit();
}

if (isset($_POST['submit'])) {
  $onlineStartTime = mysqli_real_escape_string($con, $_POST['online_shift_start']);
  $onlineEndTime = mysqli_real_escape_string($con, $_POST['online_shift_end']);
  $patientOnlineDuration = mysqli_real_escape_string($con, $_POST['patient_online_duration']);
  $offlineStartTime = mysqli_real_escape_string($con, $_POST['offline_shift_start']);
  $offlineEndTime = mysqli_real_escape_string($con, $_POST['offline_shift_end']);
  $patientOfflineDuration = mysqli_real_escape_string($con, $_POST['patient_offline_duration']);
  $d_visit_fee = trim($_POST['d_visit_fee']);
  $d_online_fee = trim($_POST['d_online_fee']);
  $d_id = $_POST['d_id'];
  $online_sc_id = $_POST['online_sc_id'];
  $offline_sc_id = $_POST['offline_sc_id'];
  mysqli_query($con, "update doctor set d_online_fee=$d_online_fee, d_visit_fee=$d_visit_fee where d_id=$d_id");

  // Prepare the SQL statement
  $stmt = $con->prepare("UPDATE doc_schedule SET sc_shift_start=?, sc_shift_end=?, sc_patient_duration=?, sc_status=? where sc_id=?");

  // Online shift
  $status = ($d_online_fee > 0) ? 1 : 0;
  $stmt->bind_param("ssiii", $onlineStartTime, $onlineEndTime, $patientOnlineDuration, $status, $online_sc_id);
  $stmt->execute();

  // Offline shift
  $shiftType = 'offline';
  $status = ($d_visit_fee > 0) ? 1 : 0;
  $stmt->bind_param("ssiii", $offlineStartTime, $offlineEndTime, $patientOfflineDuration, $status, $offline_sc_id);
  $stmt->execute();
  $stmt->close();
?>
  <script>
    window.location.href = "doc_schedule.php?d_id=<?php echo $d_id; ?>";
  </script>
<?php
  exit();
}
