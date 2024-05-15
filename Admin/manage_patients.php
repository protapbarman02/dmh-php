<?php $ROOT = "../";
require('includes/nav.php');
$p_id = '';
$p_name = '';
$p_gen = '';
$p_addr = '';
$p_email = '';
$p_phn = '';
$p_pass = '';
$p_dob = '';
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['p_id']) && $_GET['p_id'] != '') {
    $p_id = $_GET['p_id'];
    $res = mysqli_query($con, "select * from patient where p_id=$p_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $p_name = $row['p_name'];
      $p_gen = $row['p_gen'];
      $p_addr = $row['p_addr'];
      $p_email = $row['p_email'];
      $p_phn = $row['p_phn'];
      $p_pass = $row['p_pass'];
      $p_dob = $row['p_dob'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "patients.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $p_name = trim($_POST['p_name']);
  $p_gen = trim($_POST['p_gen']);
  $p_addr = trim($_POST['p_addr']);
  $p_email = trim($_POST['p_email']);
  $p_phn = trim($_POST['p_phn']);
  $p_pass = md5(trim($_POST['p_pass']));
  $p_dob = trim($_POST['p_dob']);
  if (isset($_POST['p_id']) && $_POST['p_id'] != '') {
    $p_id = $_POST['p_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_PATIENT_LOC . $img);
        $stmt = $con->prepare("UPDATE patient SET p_name=?, p_dob=?, p_gen=?, p_addr=?, p_email=?, p_phn=?, p_pass=?, p_image='$img' WHERE p_id=$p_id");
        $stmt->bind_param("sssssss", $p_name, $p_dob, $p_gen, $p_addr, $p_email, $p_phn, $p_pass);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("UPDATE patient SET p_name=?, p_dob=?, p_gen=?, p_addr=?, p_email=?, p_phn=?, p_pass=? WHERE p_id=$p_id");
      $stmt->bind_param("sssssss", $p_name, $p_dob, $p_gen, $p_addr, $p_email, $p_phn, $p_pass);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      window.location.href = "patients.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "patients.php";
    </script>
<?php
  }
}
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(use jpg/ jpeg/ png), doctor update failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>Patients</h2>
  <div class="admin-patientss-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Patients Details</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="p_name" class="form-control-label">Patient Name</label>
          <input type="text" id="p_name" name="p_name" value="<?php echo $p_name; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="p_addr" class=" form-control-label">Address</label>
          <textarea name="p_addr" id="p_addr" rows="3" class="form-control"><?php echo $p_addr; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="p_email" class="form-control-label">Email Address</label>
          <input type="email" id="p_email" name="p_email" value="<?php echo $p_email; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="p_phn" class=" form-control-label">Phone Number</label>
          <input type="text" id="p_phn" name="p_phn" value="<?php echo $p_phn; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="p_pass" class=" form-control-label">Password</label>
          <input type="text" id="p_pass" name="p_pass" value="<?php echo $p_pass; ?>" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="p_dob" class="form-control-label">Date Of Birth</label>
            <input type="date" id="p_dob" name="p_dob" value="<?php echo $p_dob; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="p_gen" class="form-control-label">Gender</label><br>
            <select name="p_gen" id="p_gen">
              <option value="<?php echo $p_gen; ?>"><?php echo $p_gen; ?></option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="patients.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>