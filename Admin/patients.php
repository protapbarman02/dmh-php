<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isAlreadyDelete = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
  $p_id = $_GET['p_id'];
  $check_sql = "select p_id from patient where p_id='$p_id'";
  $res = mysqli_query($con, $check_sql);
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $delete_sql = "update patient set p_status=0 where p_id=$p_id";
    $res = mysqli_query($con, $delete_sql);
    if ($res) {
      $isDelete = 1;
      //successfuly deleted
    } else {
      //delete failed
    }
  } else {
    $isAlreadyDelete = 1;
    // echo "patient was already deleted or does not exist";
  }
}
if (isset($_POST['submit']) && $_POST['submit'] != '') {
  $p_name = trim($_POST['p_name']);
  $p_dob = trim($_POST['p_dob']);
  $p_gen = trim($_POST['p_gen']);
  // $p_addr=trim($_POST['p_addr']);
  $p_email = trim($_POST['p_email']);
  $p_phn = trim($_POST['p_phn']);
  $p_pass = md5(trim($_POST['p_pass']));
  $res = mysqli_query($con, "select * from patient where p_email='$p_email'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_PATIENT_LOC . $img);
        $stmt = $con->prepare("INSERT INTO patient (p_name, p_dob, p_gen,p_email, p_phn, p_pass, p_reg_date,p_status, p_image) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), 1, '$img')");
        $stmt->bind_param("ssssss", $p_name, $p_dob, $p_gen, $p_email, $p_phn, $p_pass);
        $stmt->execute();
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO patient (p_name, p_dob, p_gen, p_email, p_phn, p_pass, p_reg_date,p_status) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), 1)");
      $stmt->bind_param("ssssss", $p_name, $p_dob, $p_gen, $p_email, $p_phn, $p_pass);
      $stmt->execute();
      $stmt->close();
      $isAdd = 1;
    }
  }
}

$res = mysqli_query($con, "select * from patient order by p_name;");
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(use jpg / jpeg / png), Patient add failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Specialization already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> patient deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isAlreadyDelete == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
            <strong>Warning!</strong> patient was deleted already or does not exist
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> patient added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Patients</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="patients.php" class="right-top-link active">Patients</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-patients-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add patient</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="name" class="form-control-label">Patient Name</label>
          <input type="text" id="name" name="name" placeholder="Enter patient name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="email" class="form-control-label">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" placeholder="" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="phn" class=" form-control-label">Phone Number</label>
          <input type="text" id="phn" name="phn" placeholder="Enter Phone No." class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="pass" class=" form-control-label">Password</label>
          <input type="text" id="pass" name="pass" placeholder="Create Password" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="dob" class="form-control-label">Date Of Birth</label>
            <input type="date" id="dob" name="dob" placeholder="Enter DOB" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="gen" class="form-control-label">Gender</label><br>
            <select name="gen" id="gen">
              <option value="Nil">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
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
            <th>Patient Name</th>
            <th>DOB</th>
            <th>Age(y)</th>
            <th>Gender</th>
            <th>Image</th>
            <th>Email</th>
            <th>Phone No.</th>
            <th>Reg. Date</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['p_name'] ?></td>
              <td><?php echo $row['p_dob'] ?></td>
              <td><?php echo age($row['p_dob']) ?></td>
              <td><?php echo $row['p_gen'] ?></td>
              <?php if ($row['p_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC ?>profile-icon.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_PATIENT_LOC . $row['p_image']; ?>" /></td>
              <?php } ?>
              <td><?php echo $row['p_email'] ?></td>
              <td><?php echo $row['p_phn'] ?></td>
              <td><?php echo $row['p_reg_date'] ?></td>
              <td>
                <?php
                echo "<span class='btn btn-warning'><a href='manage_patients.php?type=edit&p_id=" . $row['p_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                if ($row['p_status'] == 1) {
                  echo "<span class='btn btn-danger'><a href='?type=delete&p_id=" . $row['p_id'] . "' class='manage-links'>Delete</a></span>";
                } else {
                  echo "<span class='btn btn-secondary'>Deleted</a></span>";
                }
                ?>
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
</script>
<?php
require('includes/footer.php');
?>