<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isInvalidRequest = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $pk_id = $_GET['pk_id'];
  $check_sql = "select * from package where pk_id='$pk_id'";
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
      $update_status_sql = "update package set pk_status=$status where pk_id=$pk_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from package where pk_id=$pk_id";
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
  $pk_name = trim($_POST['pk_name']);
  $pk_short_descr = trim($_POST['pk_short_descr']);
  $pk_descr = trim($_POST['pk_descr']);
  $pk_preparation = trim($_POST['pk_preparation']);
  $pk_caution = trim($_POST['pk_caution']);
  $pk_process = trim($_POST['pk_process']);
  $pk_fee = intval($_POST['pk_fee']);
  $pk_pay_fee = intval($_POST['pk_pay_fee']);
  $selectedTests = $_POST["test"];
  $res = mysqli_query($con, "select * from package where pk_name='$pk_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_PACKAGE_LOC . $img);
        $stmt = $con->prepare("INSERT INTO package (pk_name,pk_short_descr, pk_descr, pk_preparation,pk_caution, pk_process,pk_fee, pk_pay_fee, pk_image) VALUES (?,?,?,?,?,?,?,?, '$img')");
        $stmt->bind_param("ssssssii", $pk_name, $pk_short_descr, $pk_descr, $pk_preparation, $pk_caution, $pk_process, $pk_fee, $pk_pay_fee);
        $stmt->execute();
        $pk_id = mysqli_insert_id($con);
        foreach ($selectedTests as $t_id) {
          $stmt2 = $con->prepare("INSERT INTO test_pack_joint (t_id, pk_id) VALUES (?, ?)");
          $stmt2->bind_param('ii', $t_id, $pk_id);
          $stmt2->execute();
          $stmt2->close();
        }
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO package (pk_name,pk_short_descr, pk_descr, pk_preparation,pk_process,pk_caution, pk_fee, pk_pay_fee, pk_image) VALUES (?,?,?,?,?,?,?,?,'testPackages.png')");
      $stmt->bind_param("ssssssii", $pk_name, $pk_short_descr, $pk_descr, $pk_preparation, $pk_process, $pk_caution, $pk_fee, $pk_pay_fee);
      $stmt->execute();
      $pk_id = mysqli_insert_id($con);
      foreach ($selectedTests as $t_id) {
        $stmt2 = $con->prepare("INSERT INTO test_pack_joint (t_id, pk_id) VALUES (?, ?)");
        $stmt2->bind_param('ii', $t_id, $pk_id);
        $stmt2->execute();
        $stmt2->close();
      }
      $stmt->close();
      $isAdd = 1;
    }
  }
}
$sql = "select * from package order by pk_id desc";
$res = mysqli_query($con, $sql);
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(use jpg/hpeg/png), Package add failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Package already exist
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
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Package deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> Package added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Packages</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexDiagnosis.php" class="right-top-link">Diagnosis</a>
      <span> / </span>
      <a href="packages.php" class="right-top-link active">Packages</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Package</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="pk_name" class="form-control-label">Package Name</label>
          <input type="text" name="pk_name" id="pk_name" placeholder="Enter category name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="" class="form-control-label">Select Tests(hold ctrl and select multiple)</label>
          <select name="test[]" class="form-select" multiple aria-label="multiple select example">
            <?php
            $result = mysqli_query($con, "select t_id,t_name from test where t_id !=1");
            while ($rowTest = mysqli_fetch_assoc($result)) {
            ?>
              <option value="<?php echo $rowTest['t_id'] ?>"><?php echo $rowTest['t_name'] ?></option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="form-group m-2">
          <label for="pk_short_descr" class="form-control-label">Short Description</label>
          <input type="text" name="pk_short_descr" id="pk_short_descr" placeholder="Enter short description" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="pk_descr" class=" form-control-label">Description</label>
          <textarea name="pk_descr" id="pk_descr" rows="3" placeholder="Enter Package Description" class="form-control" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="pk_preparation" class=" form-control-label">Preparation</label>
          <textarea name="pk_preparation" id="pk_preparation" rows="3" placeholder="Enter Preparation for Patient" class="form-control" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="pk_process" class=" form-control-label">Process</label>
          <textarea name="pk_process" id="pk_process" rows="3" placeholder="Enter Process of Tests" class="form-control" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="pk_caution" class=" form-control-label">Cautions</label>
          <textarea name="pk_caution" id="pk_caution" rows="3" placeholder="Enter Cautions for Patient" class="form-control" required></textarea>
        </div>
        <div class="row">
          <div class="col">
            <label for="pk_fee" class=" form-control-label">Fee</label>
            <input type="number" name="pk_fee" id="pk_fee" placeholder="Enter Package Fee" class="form-control" required>

          </div>
          <div class="col">
            <label for="pk_pay_fee" class=" form-control-label">Final Amount</label>
            <input type="number" name="pk_pay_fee" id="pk_pay_fee" placeholder="Enter Final Amount" class="form-control" required>

          </div>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image</label>
          <input type="file" id="image" name="image" class="form-control">
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
            <th>Category Name</th>
            <th>Short Description</th>
            <th>Description</th>
            <th>Included tests</th>
            <th>Preparation</th>
            <th>Cautions</th>
            <th>Fee</th>
            <th>Final Amount</th>
            <th>Image</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['pk_name'] ?></td>
              <td><?php echo $row['pk_short_descr'] ?></td>
              <td class="truncated-text" style="max-width: 150px;"><?php echo $row['pk_descr'] ?></td>
              <td>
                <table>
                  <?php
                  $result2 = mysqli_query($con, "select t_name from test inner join test_pack_joint on test_pack_joint.t_id=test.t_id inner join package on test_pack_joint.pk_id=package.pk_id where package.pk_id={$row['pk_id']}");
                  $i = 1;
                  while ($rowTestName = mysqli_fetch_assoc($result2)) {
                  ?>
                    <tr>
                      <td class="truncated-text" style="max-width: 200px;"><?php echo $i;
                                                                            echo " " . $rowTestName['t_name']; ?>;</td>
                    </tr>
                  <?php
                    $i++;
                  }
                  ?>
                </table>
              </td>
              <td class="truncated-text" style="max-width: 150px;"><?php echo $row['pk_preparation'] ?></td>
              <td class="truncated-text" style="max-width: 150px;"><?php echo $row['pk_caution'] ?></td>
              <td><?php echo $row['pk_fee'] ?> Rs/-</td>
              <td><?php echo $row['pk_pay_fee'] ?> Rs/-</td>
              <?php if ($row['pk_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC ?>unavailable.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_PACKAGE_LOC . $row['pk_image']; ?>" /></td>
              <?php } ?>
              <td class="admin-manage-td">
                <?php
                if ($row['pk_status'] == 1) {
                  echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&pk_id=" . $row['pk_id'] . "' class='manage-links'> Actived </a></span>&nbsp;";
                } else {
                  echo "<span class='btn btn-danger'><a href='?type=status&operation=active&pk_id=" . $row['pk_id'] . "' class='manage-links'>Deactived</a></span>&nbsp;";
                }
                echo "<span class='btn btn-warning'><a href='manage_package.php?type=edit&pk_id=" . $row['pk_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&pk_id=" . $row['pk_id'] . "' class='manage-links'>Delete</a></span>";
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