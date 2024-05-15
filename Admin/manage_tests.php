<?php $ROOT = "../";
require('includes/nav.php');
$t_id = '';
$t_name = '';
$t_fee = '';
$t_final_fee = '';
$t_sample_type = '';
$t_short_descr = '';
$t_descr = '';
$t_preparation = '';
$t_process = '';
$t_caution = '';
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['t_id']) && $_GET['t_id'] != '') {
    $t_id = $_GET['t_id'];
    $res = mysqli_query($con, "select * from test where t_id=$t_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $t_name = $row['t_name'];
      $t_fee = $row['t_fee'];
      $t_final_fee = $row['t_final_fee'];
      $t_sample_type = $row['t_sample_type'];
      $t_short_descr = $row['t_short_descr'];
      $t_descr = $row['t_descr'];
      $t_preparation = $row['t_preparation'];
      $t_process = $row['t_process'];
      $t_caution = $row['t_caution'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "tests.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $t_name = trim($_POST['t_name']);
  $t_fee = intval($_POST['t_fee']);
  $t_final_fee = intval($_POST['t_final_fee']);
  $t_sample_type = trim($_POST['t_sample_type']);
  $t_descr = trim($_POST['t_descr']);
  $t_preparation = trim($_POST['t_preparation']);
  $t_short_descr = trim($_POST['t_short_descr']);
  $t_process = trim($_POST['t_process']);
  $t_caution = trim($_POST['t_caution']);
  if (isset($_POST['t_id']) && $_POST['t_id'] != '') {
    $t_id = $_POST['t_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_TEST_LOC . $img);
        $stmt = $con->prepare("UPDATE test SET t_name=?,t_fee=?,_final_fee=?, t_sample_type=?, t_short_descr=?, t_descr=?,t_preparation=?, t_process=?, t_caution=?, t_image='$img' WHERE t_id=$t_id");
        $stmt->bind_param("siissssss", $t_name, $t_fee, $t_final_fee, $t_sample_type, $t_short_descr, $t_descr, $t_preparation, $t_process, $t_caution);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("UPDATE test SET t_name=?,t_fee=?,t_final_fee=?, t_sample_type=?, t_short_descr=?, t_descr=?,t_preparation=?, t_process=?, t_caution=? WHERE t_id=$t_id");
      $stmt->bind_param("siissssss", $t_name, $t_fee, $t_final_fee, $t_sample_type, $t_short_descr, $t_descr, $t_preparation, $t_process, $t_caution);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      //window.location.href = "tests.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      //window.location.href = "tests.php";
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
                    <strong>Warning!</strong> Invalid image format, medicine add failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>Lab Test</h2>
  <div class="admin-tests-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Test Details</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="t_name" class="form-control-label">Test Name</label>
          <input type="text" id="t_name" name="t_name" value="<?php echo $t_name; ?>" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="t_sample_type" class=" form-control-label">Sample Type</label>
            <select name="t_sample_type" id="t_sample_type" class="form-control">
              <option value="<?php echo $t_sample_type; ?>"><?php echo $t_sample_type; ?></option>
              <option value="Blood">Blood</option>
              <option value="Urine">Urine</option>
              <option value="Cough">Cough</option>
              <option value="Saliva">Saliva</option>
              <option value="Tissue">Tissue</option>
              <option value="N/A">N/A</option>
            </select>
          </div>

        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="t_fee" class="form-control-label">Fees</label>
            <input type="number" id="t_fee" name="t_fee" value="<?php echo $t_fee; ?>" class="form-control" required>
          </div>
          <div class="col-6">
            <label for="t_final_fee" class="form-control-label">Final Amount</label>
            <input type="number" id="t_final_fee" name="t_final_fee" value="<?php echo $t_final_fee; ?>" class="form-control" required>
          </div>
        </div>
        <div class="col-6">
          <label for="t_short_descr" class=" form-control-label">Short Description</label>
          <input type="text" id="t_short_descr" name="t_short_descr" value="<?php echo $t_short_descr; ?>" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="t_descr" class=" form-control-label">Description</label>
          <textarea name="t_descr" id="t_descr" rows="3" class="form-control" required><?php echo $t_descr; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="t_preparation" class=" form-control-label">Preparation</label>
          <textarea name="t_preparation" id="t_preparation" rows="3" class="form-control" required><?php echo $t_preparation; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="t_process" class="form-control-label">Process</label>
          <textarea name="t_process" id="t_process" rows="3" class="form-control" required><?php echo $t_process; ?></textarea>
        </div>
        <div class="form-group m-2" style="display:none;">
          <label for="t_caution" class="form-control-label">Caution</label>
          <textarea name="t_caution" id="t_caution" rows="3" class="form-control" required><?php echo $t_caution; ?></textarea>
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="tests.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="t_id" value="<?php echo $t_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>