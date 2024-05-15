<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isAlreadyDelete = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $d_id = $_GET['d_id'];
  $check_sql = "select * from doctor where d_id='$d_id'";
  $res = mysqli_query($con, $check_sql);
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    if ($type == 'status') {
      $operation = $_GET['operation'];
      if ($operation == 'active') {
        $status = '1';
      } else {
        $status = '0';
      }
      $update_status_sql = "update doctor set d_status=$status where d_id=$d_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from doctor where d_id=$d_id";
      $res = mysqli_query($con, $delete_sql);
      if ($res) {
        $isDelete = 1;
      } else {
        //delete failed
      }
    }
  } else {
    $isInvalidRequest = 1;
  }
}
if (isset($_POST['submit']) && $_POST['submit'] != '') {
  $d_name = trim($_POST['d_name']);
  $d_dob = trim($_POST['d_dob']);
  $d_gen = trim($_POST['d_gen']);
  $d_addr = trim($_POST['d_addr']);
  $d_email = trim($_POST['d_email']);
  $d_phn = trim($_POST['d_phn']);
  $d_pass = md5(trim($_POST['d_pass']));
  $d_join_date = trim($_POST['d_join_date']);
  $d_qualif = trim($_POST['d_qualif']);
  $d_visit_fee = trim($_POST['d_visit_fee']);
  $d_online_fee = trim($_POST['d_online_fee']);
  $d_expernc = trim($_POST['d_expernc']);
  $d_hospital = trim($_POST['d_hospital']);
  $sp_id = intval($_POST['sp_id']);

  $res = mysqli_query($con, "select * from doctor where d_email='$d_email'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_DOCTOR_LOC . $img);
        $stmt = $con->prepare("INSERT INTO doctor (d_name, d_dob, d_gen, d_addr, d_email, d_phn, d_pass, d_join_date, d_qualif,d_hospital, d_visit_fee, d_online_fee, sp_id, d_expernc, d_image) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, '$img')");
        $stmt->bind_param("ssssssssssssis", $d_name, $d_dob, $d_gen, $d_addr, $d_email, $d_phn, $d_pass, $d_join_date, $d_qualif, $d_hospital, $d_visit_fee, $d_online_fee, $sp_id, $d_expernc);
        $stmt->execute();
        $insert_id = $con->insert_id;
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO doctor (d_name, d_dob, d_gen, d_addr, d_email, d_phn, d_pass, d_join_date, d_qualif,d_hospital, d_visit_fee, d_online_fee, sp_id, d_expernc) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssssssssis", $d_name, $d_dob, $d_gen, $d_addr, $d_email, $d_phn, $d_pass, $d_join_date, $d_qualif, $d_hospital, $d_visit_fee, $d_online_fee, $sp_id, $d_expernc);
      $stmt->execute();
      $insert_id = $con->insert_id;
      $stmt->close();
      $isAdd = 1;
    }

    $onlineStartTime = mysqli_real_escape_string($con, $_POST['online_shift_start']);
    $onlineEndTime = mysqli_real_escape_string($con, $_POST['online_shift_end']);
    $patientOnlineDuration = mysqli_real_escape_string($con, $_POST['patient_online_duration']);
    $offlineStartTime = mysqli_real_escape_string($con, $_POST['offline_shift_start']);
    $offlineEndTime = mysqli_real_escape_string($con, $_POST['offline_shift_end']);
    $patientOfflineDuration = mysqli_real_escape_string($con, $_POST['patient_offline_duration']);

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO doc_schedule (d_id, sc_shift_type, sc_shift_start, sc_shift_end, sc_patient_duration, sc_status) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
      // Online shift
      $shiftType = 'online';
      $status = ($d_online_fee > 0) ? 1 : 0;
      $stmt->bind_param("isssii", $insert_id, $shiftType, $onlineStartTime, $onlineEndTime, $patientOnlineDuration, $status);
      $stmt->execute();

      // Offline shift
      $shiftType = 'offline';
      $status = ($d_visit_fee > 0) ? 1 : 0;
      $stmt->bind_param("isssii", $insert_id, $shiftType, $offlineStartTime, $offlineEndTime, $patientOfflineDuration, $status);
      $stmt->execute();
      $stmt->close();
    }
  }
}
$res = mysqli_query($con, "select doctor.*,specialization.sp_name,specialization.sp_id from doctor inner join specialization on doctor.sp_id=specialization.sp_id order by doctor.d_name;");
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php

    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(use jpg/hpeg/png), doctor add failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Doctor already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Doctor deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isAlreadyDelete == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
            <strong>Warning!</strong> doctor was deleted already or does not exist
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> Doctor added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Doctors</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexStaffs.php" class="right-top-link">Staffs</a>
      <span> / </span>
      <a href="doctor.php" class="right-top-link active">Doctors</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-doctors-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Doctor</button>
      <form id="doctor-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="d_name" class="form-control-label">Doctor Name</label>
          <input type="text" id="d_name" name="d_name" placeholder="Enter Doctor name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="d_addr" class=" form-control-label">Address</label>
          <textarea name="d_addr" id="d_addr" rows="3" class="form-control" placeholder="Enter Address"></textarea>
        </div>
        <div class="form-group m-2">
          <label for="d_email" class="form-control-label">Email Address</label>
          <input type="email" id="d_email" name="d_email" placeholder="Enter Email" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" placeholder="" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="d_phn" class=" form-control-label">Phone Number</label>
          <input type="text" id="d_phn" name="d_phn" placeholder="Enter Phone No." class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="d_pass" class=" form-control-label">Password</label>
          <input type="text" id="d_pass" name="d_pass" placeholder="Create Password" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="d_dob" class="form-control-label">Date Of Birth</label>
            <input type="date" id="d_dob" name="d_dob" placeholder="Enter DOB" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="d_gen" class="form-control-label">Gender</label><br>
            <select name="d_gen" id="d_gen">
              <option value="Nil">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-3">
            <label for="d_join_date" class="form-control-label">Date Of Joining</label>
            <input type="date" id="d_join_date" name="d_join_date" placeholder="Enter joining date" class="form-control" required>
          </div>
          <div class="col-3">
            <label for="sp_id" class="form-control-label">Specialization</label><br>
            <select name="sp_id" id="sp_id">
              <option value="1">Select</option>
              <?php
              $result = mysqli_query($con, "select * from specialization where `sp_id`!=1 order by sp_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['sp_id']; ?>"><?php echo $data['sp_name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-3">
            <label for="d_expernc" class=" form-control-label">Experience(Years)</label>
            <input type="text" id="d_expernc" name="d_expernc" placeholder="Enter experience" class="form-control" required>
          </div>
          <div class="col-3">
            <label for="d_hospital" class=" form-control-label">Workplace(Hospital/Nursing Home Name)</label>
            <input type="text" id="d_hospital" name="d_hospital" placeholder="Currently working at" class="form-control">
          </div>
        </div>

        <div class="form-group m-2">
          <label for="d_qualif" class=" form-control-label">Educational Qualification</label>
          <input type="text" id="d_qualif" name="d_qualif" placeholder="Enter qualification" class="form-control" required>
        </div>

        <div class="row">
          <div class="col-6 p-2 border shadow">
            <p><b>Doctor's Online Shift:</b></p>
            <div id="online_shift_schedule_box">
              <div class="row">
                <div class="col form-group">
                  <label class="form-label">From :(24H Clock Format)</label>
                  <input type="time" class="form-control" name="online_shift_start" id="online_shift_start" required>
                  to
                  <input type="time" class="form-control" name="online_shift_end" id="online_shift_end" required>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="form-label">Patient's Online Visit Duration(Minutes):</label>
                    <input type="number" class="form-control" name="patient_online_duration" id="patient_online_duration" min="0" step="1" placeholder="e.g. 15" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="d_online_fee" class="form-control-label">Online Consult Fees(Keep this empty or 0 in case the doctor does not attend this shift)</label><br>
                  <input type="number" id="d_online_fee" name="d_online_fee" placeholder="Enter Consult Fees" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <!--  -->
          <div class="col-6 p-2 border shadow">
            <p><b>Doctor's Offline Shift:</b></p>
            <div id="offline_shift_schedule_box">
              <div class="row">
                <div class="col form-group">
                  <label class="form-label">From:(24H Clock Format)</label>
                  <input type="time" class="form-control" name="offline_shift_start" id="offline_shift_start" required>
                  to
                  <input type="time" class="form-control" name="offline_shift_end" id="offline_shift_end" required>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="form-label">Patient's Offline Visit Duration(Minutes):</label>
                    <input type="number" class="form-control" name="patient_offline_duration" id="patient_offline_duration" min="0" step="1" placeholder="e.g. 10">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="d_visit_fee" class="form-control-label">Visiting Fees(Keep this empty or 0 in case the doctor does not attend this shift)</label>
                  <input type="number" id="d_visit_fee" name="d_visit_fee" placeholder="Enter visiting fees" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="m-2">
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Add</button>
        </div>
      </form>
    </div>
    <div class="admin-table-container">
      <table class="table">
        <thead>
          <tr>
            <th class="serial">#</th>
            <th>Doctor Name</th>
            <th>DOB</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Image</th>
            <th>Email</th>
            <th>Phone No.</th>
            <th>Date of Joining</th>
            <th>Visit Fees</th>
            <th>Online Consult Fee</th>
            <th>Qualification</th>
            <th>Experience</th>
            <th>Specialization</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><a href="doc_schedule.php?d_id=<?php echo $row['d_id'] ?>"><?php echo $row['d_name'] ?></a></td>
              <td><?php echo $row['d_dob'] ?></td>
              <td><?php echo age($row['d_dob']) ?></td>
              <td><?php echo $row['d_gen'] ?></td>
              <?php if ($row['d_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC; ?>profile-icon.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_DOCTOR_LOC . $row['d_image']; ?>" /></td>
              <?php } ?>
              <td><?php echo $row['d_email'] ?></td>
              <td><?php echo $row['d_phn'] ?></td>
              <td><?php echo $row['d_join_date'] ?></td>
              <td><?php echo $row['d_visit_fee'] ?></td>
              <td><?php echo $row['d_online_fee'] ?></td>
              <td class="truncated-text" style="max-width: 300px;"><?php echo $row['d_qualif'] ?></td>
              <td><?php echo $row['d_expernc'] ?></td>
              <td><?php echo $row['sp_name'] ?></td>
              <td>
                <div class="admin-manage-td">
                  <?php
                  if ($row['d_status'] == 1) {
                    echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&d_id=" . $row['d_id'] . "' class='manage-links'> Actived </a></span>";
                  } else {
                    echo "<span class='btn btn-danger'><a href='?type=status&operation=active&d_id=" . $row['d_id'] . "' class='manage-links'>Deactived</a></span> &nbsp;";
                  }
                  ?>
                  <?php
                  echo "<span class='btn btn-warning'><a href='manage_doctor.php?type=edit&d_id=" . $row['d_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                  echo "<span class='btn btn-danger'><a href='?type=delete&d_id=" . $row['d_id'] . "' class='manage-links'>Delete</a></span>&nbsp;";
                  ?>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</main>
<script>
  $(".add-btn-dropdown").click(() => {
    $(".field_error").html('');
    $(".admin-add-dorpdown-form").toggleClass("admin-add-dorpdown-form-hide");
  });
  $(".admin-alert-dismiss-btn").click(() => {
    $(".admin-alert-dismiss-container").css("display", "none");
  });
  $(document).ready(function() {
    $('form').on('submit', function(event) {
      event.preventDefault();
      const onlineShiftStart = $('#online_shift_start').val();
      const onlineShiftEnd = $('#online_shift_end').val();
      const offlineShiftStart = $('#offline_shift_start').val();
      const offlineShiftEnd = $('#offline_shift_end').val();
      const patientOnlineDuration = $('#patient_online_duration').val();
      const patientOfflineDuration = $('#patient_offline_duration').val();

      if (onlineShiftStart === '00:00' || onlineShiftEnd === '00:00' || offlineShiftStart === '00:00' || offlineShiftEnd === '00:00') {
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