<?php $ROOT = "../";
require('includes/nav.php');
$s_id = '';
$s_name = '';
$s_gen = '';
$s_addr = '';
$s_email = '';
$s_phn = '';
$s_pass = '';
$s_dob = '';
$s_join_date = '';
$s_salary = '';
$s_qualif = '';
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['s_id']) && $_GET['s_id'] != '') {
    $s_id = $_GET['s_id'];
    $res = mysqli_query($con, "select * from staff where s_id=$s_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $s_name = $row['s_name'];
      $s_gen = $row['s_gen'];
      $s_addr = $row['s_addr'];
      $s_email = $row['s_email'];
      $s_phn = $row['s_phn'];
      $s_pass = $row['s_pass'];
      $s_dob = $row['s_dob'];
      $s_join_date = $row['s_join_date'];
      $s_salary = $row['s_salary'];
      $s_qualif = $row['s_qualif'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "technician.php";
      </script>
    <?php
    }
  }
}
if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $s_name = trim($_POST['s_name']);
  $s_gen = trim($_POST['s_gen']);
  $s_addr = trim($_POST['s_addr']);
  $s_email = trim($_POST['s_email']);
  $s_phn = trim($_POST['s_phn']);
  $s_pass = md5(trim($_POST['s_pass']));
  $s_dob = trim($_POST['s_dob']);
  $s_join_date = trim($_POST['s_join_date']);
  $s_salary = trim($_POST['s_salary']);
  $s_qualif = trim($_POST['s_qualif']);
  if (isset($_POST['s_id']) && $_POST['s_id'] != '') {
    $s_id = $_POST['s_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_ADMIN_LOC . $img);
        $stmt = $con->prepare("UPDATE staff SET s_name=?, s_dob=?, s_gen=?, s_addr=?, s_email=?, s_phn=?, s_pass=?, s_join_date=?, s_salary=?, s_qualif=?, s_image='$img' WHERE s_id=$s_id");
        $stmt->bind_param("ssssssssss", $s_name, $s_dob, $s_gen, $s_addr, $s_email, $s_phn, $s_pass, $s_join_date, $s_salary, $s_qualif);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("UPDATE staff SET s_name=?, s_dob=?, s_gen=?, s_addr=?, s_email=?, s_phn=?, s_pass=?, s_join_date=?, s_salary=?, s_qualif=? WHERE s_id=$s_id");
      $stmt->bind_param("ssssssssss", $s_name, $s_dob, $s_gen, $s_addr, $s_email, $s_phn, $s_pass, $s_join_date, $s_salary, $s_qualif);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      window.location.href = "technician.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "technician.php";
    </script>
<?php
  }
}
?>
<section class="admin-right-panel">
  <h2>Technician</h2>
  <div class="admin-technicians-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Technician Details</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="s_name" class="form-control-label">Technician Name</label>
          <input type="text" id="s_name" name="s_name" value="<?php echo $s_name; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="s_addr" class=" form-control-label">Address</label>
          <textarea name="s_addr" id="s_addr" rows="3" class="form-control"><?php echo $s_addr; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="s_email" class="form-control-label">Email Address</label>
          <input type="email" id="s_email" name="s_email" value="<?php echo $s_email; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="s_phn" class=" form-control-label">Phone Number</label>
          <input type="text" id="s_phn" name="s_phn" value="<?php echo $s_phn; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="s_pass" class=" form-control-label">Password</label>
          <input type="text" id="s_pass" name="s_pass" value="<?php echo $s_pass; ?>" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="s_dob" class="form-control-label">Date Of Birth</label>
            <input type="date" id="s_dob" name="s_dob" value="<?php echo $s_dob; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="s_gen" class="form-control-label">Gender</label><br>
            <select name="s_gen" id="s_gen">
              <option value="<?php echo $s_gen; ?>"><?php echo $s_gen; ?></option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Others</option>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="s_join_date" class="form-control-label">Date Of Joining</label>
            <input type="date" id="s_join_date" name="s_join_date" value="<?php echo $s_join_date; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="s_salary" class="form-control-label">Salary Per Month</label><br>
            <input type="number" id="s_salary" name="s_salary" value="<?php echo $s_salary; ?>" class="form-control" required>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="s_qualif" class=" form-control-label">Educational Qualification</label>
          <input type="text" id="s_qualif" name="s_qualif" value="<?php echo $s_qualif; ?>" class="form-control" required>
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="technician.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="s_id" value="<?php echo $s_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>