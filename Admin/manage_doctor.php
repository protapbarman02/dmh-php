<?php $ROOT = "../";
require('includes/nav.php');
$isValidImage = 1;
$d_id = '';
$d_name = '';
$d_gen = '';
$d_addr = '';
$d_email = '';
$d_phn = '';
$d_dob = '';
$d_join_date = '';
$d_qualif = '';
$d_visit_fee = '';
$d_online_fee = '';
$d_expernc = '';
$d_hospital = '';
$sp_name = '';
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['d_id']) && $_GET['d_id'] != '') {
    $d_id = $_GET['d_id'];
    $res = mysqli_query($con, "select * from  doctor where d_id=$d_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $d_name = $row['d_name'];
      $d_gen = $row['d_gen'];
      $d_addr = $row['d_addr'];
      $d_email = $row['d_email'];
      $d_phn = $row['d_phn'];
      $d_dob = $row['d_dob'];
      $d_join_date = $row['d_join_date'];
      $d_qualif = $row['d_qualif'];
      $d_visit_fee = $row['d_visit_fee'];
      $d_online_fee = $row['d_online_fee'];
      $d_expernc = $row['d_expernc'];
      $d_hospital = $row['d_hospital'];
      $sp_id = $row['sp_id'];
      $sp_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT sp_name FROM specialization WHERE specialization.sp_id=$sp_id;"))['sp_name'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "doctor.php";
      </script>
    <?php
    }
  }
}
if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $d_name = trim($_POST['d_name']);
  $d_gen = trim($_POST['d_gen']);
  $d_addr = trim($_POST['d_addr']);
  $d_email = trim($_POST['d_email']);
  $d_phn = trim($_POST['d_phn']);
  $d_dob = trim($_POST['d_dob']);
  $d_join_date = trim($_POST['d_join_date']);
  $d_qualif = trim($_POST['d_qualif']);
  $d_visit_fee = trim($_POST['d_visit_fee']);
  $d_online_fee = trim($_POST['d_online_fee']);
  $d_expernc = trim($_POST['d_expernc']);
  $d_hospital = trim($_POST['d_hospital']);
  $sp_id = intval($_POST['sp_id']);
  if (isset($_POST['d_id']) && $_POST['d_id'] != '') {
    $d_id = $_POST['d_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_DOCTOR_LOC . $img);
        $stmt = $con->prepare("UPDATE doctor SET d_name=?, d_dob=?, d_gen=?, d_addr=?, d_email=?, d_phn=?, d_join_date=?, d_qualif=?,d_hospital=?, d_visit_fee=?, d_online_fee=?, d_expernc=?, sp_id=?, d_image='$img' WHERE d_id=$d_id");
        $stmt->bind_param("ssssssssssssi", $d_name, $d_dob, $d_gen, $d_addr, $d_email, $d_phn, $d_join_date, $d_qualif, $d_hospital, $d_visit_fee, $d_online_fee, $d_expernc, $sp_id);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("UPDATE doctor SET d_name=?, d_dob=?, d_gen=?, d_addr=?, d_email=?, d_phn=?, d_join_date=?, d_qualif=?,d_hospital=?, d_visit_fee=?, d_online_fee=?, d_expernc=?, sp_id=? WHERE d_id=$d_id");
      $stmt->bind_param("ssssssssssssi", $d_name, $d_dob, $d_gen, $d_addr, $d_email, $d_phn, $d_join_date, $d_qualif, $d_hospital, $d_visit_fee, $d_online_fee, $d_expernc, $sp_id);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      window.location.href = "doctor.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "doctor.php";
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
                    <strong>Warning!</strong> Invalid image format(use jpg/jpeg/png), doctor update failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>Medicine Store Staffs</h2>
  <div class="admin-staffs-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update doctor Details</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="d_name" class="form-control-label">doctor Name</label>
          <input type="text" id="d_name" name="d_name" value="<?php echo $d_name; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="d_addr" class=" form-control-label">Address</label>
          <textarea name="d_addr" id="d_addr" rows="3" class="form-control"><?php echo $d_addr; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="d_email" class="form-control-label">Email Address</label>
          <input type="email" id="d_email" name="d_email" value="<?php echo $d_email; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="d_phn" class=" form-control-label">Phone Number</label>
          <input type="text" id="d_phn" name="d_phn" value="<?php echo $d_phn; ?>" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="d_dob" class="form-control-label">Date Of Birth</label>
            <input type="date" id="d_dob" name="d_dob" value="<?php echo $d_dob; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="d_gen" class="form-control-label">Gender</label><br>
            <select name="d_gen" id="d_gen">
              <option value="<?php echo $d_gen; ?>"><?php echo $d_gen; ?></option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="d_join_date" class="form-control-label">Date Of Joining</label>
            <input type="date" id="d_join_date" name="d_join_date" value="<?php echo $d_join_date; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="sp_id" class="form-control-label">Specialization</label><br>
            <select name="sp_id" id="sp_id">
              <option value="<?php echo $sp_id; ?>"><?php echo $sp_name; ?></option>
              <?php
              $result = mysqli_query($con, "select * from specialization where `sp_id`!=1 order by sp_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['sp_id']; ?>"><?php echo $data['sp_name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="d_visit_fee" class="form-control-label">Visiting Fees</label>
            <input type="number" id="d_visit_fee" name="d_visit_fee" value="<?php echo $d_visit_fee; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="d_online_fee" class="form-control-label">Diagnostic Fees</label><br>
            <input type="number" id="d_online_fee" name="d_online_fee" value="<?php echo $d_online_fee; ?>" class="form-control" required>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="d_qualif" class=" form-control-label">Educational Qualification</label>
          <input type="text" id="d_qualif" name="d_qualif" value="<?php echo $d_qualif; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="d_expernc" class=" form-control-label">Medical Experience</label>
          <input type="text" id="d_expernc" name="d_expernc" value="<?php echo $d_expernc; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="d_hospital" class=" form-control-label">Workplace</label>
          <input type="text" id="d_hospital" name="d_hospital" value="<?php echo $d_hospital; ?>" class="form-control">
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="doctor.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="d_id" value="<?php echo $d_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>