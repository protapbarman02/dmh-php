<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isInvalidRequest = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $t_id = $_GET['t_id'];
  $check_sql = "select * from test where t_id='$t_id'";
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
      $update_status_sql = "update test set t_status=$status where t_id=$t_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from test where t_id=$t_id";
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
  $t_name = trim($_POST['t_name']);
  $t_fee = intval($_POST['t_fee']);
  $t_final_fee = intval($_POST['t_final_fee']);
  $t_sample_type = trim($_POST['t_sample_type']);
  $t_short_descr = trim($_POST['t_short_descr']);
  $t_descr = trim($_POST['t_descr']);
  $t_preparation = trim($_POST['t_preparation']);
  $t_process = trim($_POST['t_process']);
  $t_caution = trim($_POST['t_caution']);
  $res = mysqli_query($con, "select * from test where t_name='$t_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_TEST_LOC . $img);
        $stmt = $con->prepare("INSERT INTO test (t_name, t_fee, t_final_fee, t_sample_type, t_short_descr, t_descr,t_preparation, t_process, t_caution, t_image) VALUES (?,?,?,?, ?, ?, ?, ?, ?, '$img')");
        $stmt->bind_param("siissssss", $t_name, $t_fee, $t_final_fee, $t_sample_type, $t_short_descr, $t_descr, $t_preparation, $t_process, $t_caution);
        $stmt->execute();
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO test (t_name,t_fee, t_final_fee, t_sample_type, t_short_descr, t_descr,t_preparation, t_process, t_caution, t_image) VALUES (?,?,?,?, ?, ?, ?, ?, ?, 'testCategories.png')");
      $stmt->bind_param("siissssss", $t_name, $t_fee, $t_final_fee, $t_sample_type, $t_short_descr, $t_descr, $t_preparation, $t_process, $t_caution);
      $stmt->execute();
      $stmt->close();
      $isAdd = 1;
    }
  }
}
$res = mysqli_query($con, "select * from test where test.t_id !=1 order by t_id desc;");
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
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> category already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Test deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isInvalidRequest == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
            <strong>Warning!</strong> Invalid request, please go to dashboard and come back on this page
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> Test added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Lab Tests</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexDiagnosis.php" class="right-top-link">Diagnosis</a>
      <span> / </span>
      <a href="tests.php" class="right-top-link active">Lab Tests</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-tests-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Test</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="t_name" class="form-control-label">Test Name</label>
          <input type="text" id="t_name" name="t_name" placeholder="Enter Test name" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="t_sample_type" class="form-control-label">Sample Type</label>
            <select name="t_sample_type" id="t_sample_type" class="form-control">
              <option value="Nil">Select</option>
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
          <input type="file" id="image" name="image" placeholder="" class="form-control">
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="t_fee" class="form-control-label">Fees</label>
            <input type="number" id="t_fee" name="t_fee" placeholder="Enter Fees" class="form-control" required>
          </div>

          <div class="col-6">
            <label for="t_final_fee" class="form-control-label">Final Fees</label>
            <input type="number" id="t_final_fee" name="t_final_fee" placeholder="Enter Final Amount" class="form-control" required>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="t_short_descr" class=" form-control-label">Short Description</label>
          <input type="text" name="t_short_descr" id="t_short_descr" rows="3" class="form-control" placeholder="Enter Short Description" required>
        </div>

        <div class="form-group m-2">
          <label for="t_descr" class=" form-control-label">Description</label>
          <textarea name="t_descr" id="t_descr" rows="3" class="form-control" placeholder="Enter Description" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="t_preparation" class=" form-control-label">Test Preparation</label>
          <textarea name="t_preparation" id="t_preparation" rows="3" class="form-control" placeholder="Enter Description" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="t_process" class="form-control-label">Process</label>
          <textarea name="t_process" id="t_process" rows="3" class="form-control" placeholder="Enter Process" required></textarea>

        </div>
        <div class="form-group m-2" style="display:none;">
          <label for="t_caution" class="form-control-label">Caution</label>
          <textarea name="t_caution" id="t_caution" rows="3" class="form-control" placeholder="Enter Cautions"></textarea>

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
            <th>Test Name</th>
            <th>Image</th>
            <th>Fee</th>
            <th>Final Amount</th>
            <th>Sample Type</th>
            <th>Short Description</th>
            <th>Caution</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td class="truncated-text" style="max-width: 150px;"><?php echo $row['t_name'] ?></td>
              <?php if ($row['t_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC; ?>unavailable.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_TEST_LOC . $row['t_image']; ?>" /></td>
              <?php } ?>
              <td><?php echo $row['t_fee'] ?> Rs/-</td>
              <td><?php echo $row['t_final_fee'] ?> Rs/-</td>
              <td><?php echo $row['t_sample_type'] ?></td>
              <td class="truncated-text" style="max-width: 150px;"><?php echo $row['t_short_descr'] ?></td>
              <!-- <td class="truncated-text" style="max-width: 200px;"><?php //echo $row['t_caution'] 
                                                                        ?></td> -->
              <td class="admin-manage-td">
                <?php
                if ($row['t_status'] == 1) {
                  echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&t_id=" . $row['t_id'] . "' class='manage-links'> Actived </a></span>&nbsp;";
                } else {
                  echo "<span class='btn btn-danger'><a href='?type=status&operation=active&t_id=" . $row['t_id'] . "' class='manage-links'>Deactived</a></span>&nbsp;";
                }
                echo "<span class='btn btn-warning'><a href='manage_tests.php?type=edit&t_id=" . $row['t_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&t_id=" . $row['t_id'] . "' class='manage-links'>Delete</a></span>";
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