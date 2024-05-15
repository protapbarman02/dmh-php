<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isAlreadyDelete = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
  $s_id = $_GET['s_id'];
  $check_sql = "select * from staff where s_id='$s_id'";
  $res = mysqli_query($con, $check_sql);
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $delete_sql = "delete from staff where s_id=$s_id";
    $res = mysqli_query($con, $delete_sql);
    if ($res) {
      $isDelete = 1;
      //successfuly deleted
    } else {
      //delete failed
    }
  } else {
    $isAlreadyDelete = 1;
    // echo "technician was already deleted or does not exist";
  }
}
if (isset($_POST['submit']) && $_POST['submit'] != '') {
  $s_name = trim($_POST['s_name']);
  $s_uname = trim($_POST['s_uname']);
  $s_dob = trim($_POST['s_dob']);
  $s_gen = trim($_POST['s_gen']);
  $s_addr = trim($_POST['s_addr']);
  $s_email = trim($_POST['s_email']);
  $s_phn = trim($_POST['s_phn']);
  $s_pass = md5(trim($_POST['s_pass']));
  $s_join_date = trim($_POST['s_join_date']);
  $s_salary = intval($_POST['s_salary']);
  $s_qualif = trim($_POST['s_qualif']);
  $res = mysqli_query($con, "select * from staff where s_email='$s_email'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_ADMIN_LOC . $img);
        $stmt = $con->prepare("INSERT INTO staff (s_name, s_uname, s_dob, s_gen, s_addr, s_email, s_phn, s_pass, s_join_date, s_salary, s_qualif, s_role, s_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'technician', '$img')");
        $stmt->bind_param("sssssssssis", $s_name, $s_uname, $s_dob, $s_gen, $s_addr, $s_email, $s_phn, $s_pass, $s_join_date, $s_salary, $s_qualif);
        $stmt->execute();
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO staff (s_name, s_uname, s_dob, s_gen, s_addr, s_email, s_phn, s_pass, s_join_date, s_salary, s_qualif, s_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'technician')");
      $stmt->bind_param("sssssssssis", $s_name, $s_uname, $s_dob, $s_gen, $s_addr, $s_email, $s_phn, $s_pass, $s_join_date, $s_salary, $s_qualif);
      $stmt->execute();
      $stmt->close();
      $isAdd = 1;
    }
  }
}
$res = mysqli_query($con, "select * from staff where staff.s_role='technician' order by staff.s_name;");
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
                    <strong>Deleted!</strong> technician deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isAlreadyDelete == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
            <strong>Warning!</strong> technician was deleted already or does not exist
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> technician added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Technicians</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexStaffs.php" class="right-top-link">Staffs</a>
      <span> / </span>
      <a href="technician.php" class="right-top-link active">Technician</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-technicians-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Technician</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="s_name" class="form-control-label">Technician Name</label>
          <input type="text" id="s_name" name="s_name" placeholder="Enter Technician name" class="form-control" required>
        </div>
        <input type="hidden" name="s_unameId" id="s_unameId" value="<?php echo getId($con); ?>">
        <div class="form-group m-2">
          <label for="s_name" class="form-control-label">User Name</label>
          <input type="text" id="s_uname" name="s_uname" class="form-control" placeholder="username will auto generate after you enter technician name and email address, username will be used while login" readonly>
        </div>
        <div class="form-group m-2">
          <label for="s_addr" class=" form-control-label">Address</label>
          <textarea name="s_addr" id="s_addr" rows="3" class="form-control" placeholder="Enter Address"></textarea>
        </div>
        <div class="form-group m-2">
          <label for="s_email" class="form-control-label">Email Address</label>
          <input type="email" id="s_email" name="s_email" placeholder="Enter Email" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" placeholder="" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="s_phn" class=" form-control-label">Phone Number</label>
          <input type="text" id="s_phn" name="s_phn" placeholder="Enter Phone No." class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="s_pass" class=" form-control-label">Password</label>
          <input type="text" id="s_pass" name="s_pass" placeholder="Create Password" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="s_dob" class="form-control-label">Date Of Birth</label>
            <input type="date" id="s_dob" name="s_dob" placeholder="Enter DOB" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="s_gen" class="form-control-label">Gender</label><br>
            <select name="s_gen" id="s_gen">
              <option value="Nil">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="s_join_date" class="form-control-label">Date Of Joining</label>
            <input type="date" id="s_join_date" name="s_join_date" placeholder="Enter joining date" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="s_salary" class="form-control-label">Salary Per Month</label><br>
            <input type="number" id="s_salary" name="s_salary" placeholder="Enter salary" class="form-control" required>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="s_qualif" class=" form-control-label">Educational Qualification</label>
          <input type="text" id="s_qualif" name="s_qualif" placeholder="Enter qualification" class="form-control" required>
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
            <th>Technician Name</th>
            <th>DOB</th>
            <th>Age(y)</th>
            <th>Gender</th>
            <th>Image</th>
            <th>Email</th>
            <th>Phone No.</th>
            <th>Date of Joining</th>
            <th>Salary(/m)</th>
            <th>Qualification</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['s_name'] ?></td>
              <td><?php echo $row['s_dob'] ?></td>
              <td><?php echo age($row['s_dob']) ?></td>
              <td><?php echo $row['s_gen'] ?></td>
              <?php if ($row['s_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC; ?>profile-icon.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ADMIN_LOC . $row['s_image']; ?>" /></td>
              <?php } ?>
              <td><?php echo $row['s_email'] ?></td>
              <td><?php echo $row['s_phn'] ?></td>
              <td><?php echo $row['s_join_date'] ?></td>
              <td><?php echo $row['s_salary'] ?></td>
              <td><?php echo $row['s_qualif'] ?></td>
              <td>
                <?php
                echo "<span class='btn btn-warning'><a href='manage_technicians.php?type=edit&s_id=" . $row['s_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&s_id=" . $row['s_id'] . "' class='manage-links'>Delete</a></span>";
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
  $("#s_email").on("focusout", (e) => {
    let name = $("#s_name").val();
    let s_uname = name.replace(/\s/g, '');
    let s_unameId = $("#s_unameId").val();
    s_uname = s_uname + s_unameId;
    $('#s_uname').val(s_uname);
    console.log($('#s_uname').val());
  });
</script>
<?php
require('includes/footer.php');
?>