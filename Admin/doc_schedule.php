<?php $ROOT = "../";
require('includes/nav.php');

if (!isset($_GET['d_id'])) {
?>
  <script>
    window.location.href = "doctor.php";
  </script>
<?php
  exit();
}

$d_id = $_GET['d_id'];
$res = mysqli_query($con, "select d_online_fee,d_visit_fee from doctor where d_id=$d_id");
while ($row = mysqli_fetch_assoc($res)) {
  $d_online_fee = $row['d_online_fee'];
  $d_visit_fee = $row['d_visit_fee'];
}
$res = mysqli_query($con, "select * from doc_schedule where d_id=$d_id and sc_shift_type='online'");
while ($row = mysqli_fetch_assoc($res)) {
  $online_sc_id = $row['sc_id'];
  $online_shift_start = $row['sc_shift_start'];
  $online_shift_end = $row['sc_shift_end'];
  $online_patient_duration = $row['sc_patient_duration'];
  $online_status = $row['sc_status'];
}
$res = mysqli_query($con, "select * from doc_schedule where d_id=$d_id and sc_shift_type='offline'");
while ($row = mysqli_fetch_assoc($res)) {
  $offline_sc_id = $row['sc_id'];
  $offline_shift_start = $row['sc_shift_start'];
  $offline_shift_end = $row['sc_shift_end'];
  $offline_patient_duration = $row['sc_patient_duration'];
  $offline_status = $row['sc_status'];
}

?>

<section class="admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Doctors</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexStaffs.php" class="right-top-link">Staffs</a>
      <span> / </span>
      <a href="doctor.php" class="right-top-link">Doctors</a>
      <span> / </span>
      <a href="" class="right-top-link active">Doctor Schedule</a>
      <span> / </span>
      <a href="" class="right-top-link active">#<?php echo $d_id; ?></a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-doctors-main">
    <div class="admin-add-container p-2">
      <form action="manage_doc_schedule.php" method="post" class="p-2">
        <div class="row">
          <div class="col-8 p-2 border shadow">
            <p><b>Doctor's Online Shift:</b></p>
            <div id="online_shift_schedule_box">
              <div class="row">
                <div class="col form-group">
                  <label class="form-label">From :(24H Clock Format)</label>
                  <input type="time" class="form-control" name="online_shift_start" id="online_shift_start" value="<?php echo $online_shift_start; ?>" required>
                  to
                  <input type="time" class="form-control" name="online_shift_end" id="online_shift_end" value="<?php echo $online_shift_end; ?>" required>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="form-label">Patient's Online Visit Duration(Minutes):</label>
                    <input type="number" class="form-control" name="patient_online_duration" id="patient_online_duration" min="0" step="1" value="<?php echo $online_patient_duration; ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="d_online_fee" class="form-control-label">Online Consult Fees(Keep this empty or 0 in case the doctor does not attend this shift)</label><br>
                  <input type="number" id="d_online_fee" name="d_online_fee" value="<?php echo $d_online_fee; ?>" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 my-4">
            <div class="admin-manage-td">
              <?php
              if ($online_status == 1) {
                echo "<span class='btn btn-success'><a class='text-light' href='manage_doc_schedule.php?type=status&operation=deactive&sc_id=" . $online_sc_id . "&d_id=" . $d_id . "&shift=online'> Actived </a></span>";
              } else if ($online_status == 0) {
                echo "<span class='btn btn-danger'><a class='text-light' href='manage_doc_schedule.php?type=status&operation=active&sc_id=" . $online_sc_id . "&d_id=" . $d_id . "&shift=online'>Deactived</a></span> &nbsp;";
              }
              ?>
            </div>
          </div>
          <!--  -->
          <div class="col-8 p-2 border shadow my-4">
            <p><b>Doctor's Offline Shift:</b></p>
            <div id="offline_shift_schedule_box">
              <div class="row">
                <div class="col form-group">
                  <label class="form-label">From:(24H Clock Format)</label>
                  <input type="time" class="form-control" name="offline_shift_start" id="offline_shift_start" value="<?php echo $offline_shift_start; ?>" required>
                  to
                  <input type="time" class="form-control" name="offline_shift_end" id="offline_shift_end" value="<?php echo $offline_shift_end; ?>" required>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="form-label">Patient's Offline Visit Duration(Minutes):</label>
                    <input type="number" class="form-control" name="patient_offline_duration" id="patient_offline_duration" min="0" step="1" value="<?php echo $offline_patient_duration; ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="d_visit_fee" class="form-control-label">Visiting Fees(Keep this empty or 0 in case the doctor does not attend this shift)</label>
                  <input type="number" id="d_visit_fee" name="d_visit_fee" value="<?php echo $d_visit_fee; ?>" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 my-4">
            <div class="admin-manage-td">
              <?php
              if ($offline_status == 1) {
                echo "<span class='btn btn-success'><a class='text-light' href='manage_doc_schedule.php?type=status&operation=deactive&sc_id=" . $offline_sc_id . "&d_id=" . $d_id . "&shift=offline'> Actived </a></span>";
              } else if ($offline_status == 0) {
                echo "<span class='btn btn-danger'><a class='text-light' href='manage_doc_schedule.php?type=status&operation=active&sc_id=" . $offline_sc_id . "&d_id=" . $d_id . "&shift=offline'>Deactived</a></span> &nbsp;";
              }
              ?>
            </div>
          </div>
        </div>
        <input type="hidden" name="online_sc_id" value="<?php echo $online_sc_id; ?>">
        <input type="hidden" name="offline_sc_id" value="<?php echo $offline_sc_id; ?>">
        <input type="hidden" name="d_id" value="<?php echo $d_id; ?>">
        <div class="m-2" class="text-center">
          <button name="submit" type="submit" value="submit" class="btn btn-success btn-lg btn-block admin-submit-btn">Update (Both)</button>
        </div>
      </form>
    </div>
  </div>
</section>
</main>
<script>
  $(document).ready(function() {
    $('form').on('submit', function(event) {
      event.preventDefault();
      const onlineShiftStart = $('#online_shift_start').val();
      const onlineShiftEnd = $('#online_shift_end').val();
      const offlineShiftStart = $('#offline_shift_start').val();
      const offlineShiftEnd = $('#offline_shift_end').val();
      const patientOnlineDuration = $('#patient_online_duration').val();
      const patientOfflineDuration = $('#patient_offline_duration').val();

      if (onlineShiftStart === '00:00' || onlineShiftEnd === '00:00' || offlineShiftStart === '00:00' || offlineShiftEnd === '00:00' ||
        onlineShiftStart === '00:00:00' || onlineShiftEnd === '00:00:00' || offlineShiftStart === '00:00:00' || offlineShiftEnd === '00:00:00') {
        alert('Please do not enter 00:00 as any shift start and end, use +/-10 minutes in that case');
        return false;
      }
      // Check if patient's online or offline visit duration is 0 or empty
      if (patientOnlineDuration === '0' || patientOnlineDuration === '' || patientOfflineDuration === '0' || patientOfflineDuration === '') {
        alert('Please enter a valid patient visit duration (neither 0 nor empty).');
        return false;
      }
      if (!isOrder(onlineShiftStart, onlineShiftEnd, offlineShiftStart, offlineShiftEnd)) {
        alert("end shift can not be smaller than start shift as it is 24 hour format");
        return false
      }
      // Check for overlapping shifts
      if (isOverlapping(onlineShiftStart, onlineShiftEnd, offlineShiftStart, offlineShiftEnd)) {
        alert('Online and offline shifts are overlapping.');
        return false;
      }
      // If all validations pass, submit the form
      $(this).unbind('submit').submit();
    });
  });

  function isOrder(start1, end1, start2, end2) {
    if ((end1 < start1) || (end2 < start2)) {
      return false;
    }
    return true;
  }

  function isOverlapping(start1, end1, start2, end2) {
    start1 = new Date("2000-01-01T" + start1);
    end1 = new Date("2000-01-01T" + end1);
    start2 = new Date("2000-01-01T" + start2);
    end2 = new Date("2000-01-01T" + end2);

    if (start1 < start2 && start2 < end1) {
      return true;
    }
    if (start1 < end2 && end2 < end1) {
      return true;
    } else if (start2 < start1 && start1 < end2) {
      return true;
    }
    if (start2 < end1 && end1 < end2) {
      return true;
    }
    return false;
  }
</script>

<?php
require('includes/footer.php');
?>