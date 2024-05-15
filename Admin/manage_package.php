<?php $ROOT = "../";
require('includes/nav.php');
$id = '';
$pk_name = '';
$pk_descr = '';
$pk_short_descr = '';
$pk_preparation = '';
$pk_caution = '';
$pk_process = '';
$pk_fee = '';
$pk_pay_fee = '';
$isValidImage = 1;
$arr = [];
if (isset($_GET['type']) && $_GET['type'] != '') {
  $type = $_GET['type'];
  if ($type == 'remove') {
    if (isset($_GET['pk_id']) && $_GET['pk_id'] != '') {
      $pk_id = $_GET['pk_id'];
      $t_id = $_GET['t_id'];
      $removeTest = mysqli_query($con, "delete from test_pack_joint where pk_id=$pk_id and t_id=$t_id;");
      if ($removeTest) {
?>
        <input type="hidden" id="Removed_pk_id" value="<?php echo $pk_id ?>">
        <script>
          pk_id = $("#Removed_pk_id").val();
          window.location.href = "manage_package.php?type=edit&pk_id=" + pk_id;
        </script>
      <?php
      } else {
      ?>
        <input type="hidden" id="Removed_pk_id" value="<?php echo $pk_id ?>">
        <script>
          alert("test removed failed or test does not exist");
          pk_id = $("#Removed_pk_id").val();
          window.location.href = "manage_package.php?type=edit&pk_id=" + pk_id;
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        alert("illegal command");
        window.location.href = "packages.php";
      </script>
      <?php
    }
  } else if ($type == 'edit') {
    if (isset($_GET['pk_id']) && $_GET['pk_id'] != '') {
      $pk_id = $_GET['pk_id'];
      $res = mysqli_query($con, "select * from package where pk_id=$pk_id");
      $check = mysqli_num_rows($res);
      if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $pk_name = $row['pk_name'];
        $pk_short_descr = $row['pk_short_descr'];
        $pk_descr = $row['pk_descr'];
        $pk_preparation = $row['pk_preparation'];
        $pk_caution = $row['pk_caution'];
        $pk_process = $row['pk_process'];
        $pk_fee = $row['pk_fee'];
        $pk_pay_fee = $row['pk_pay_fee'];
        $result4 = mysqli_query($con, "select test_pack_joint.t_id from test_pack_joint where test_pack_joint.pk_id=$pk_id");
        while ($rowTestId = mysqli_fetch_assoc($result4)) {
          $arr[] = $rowTestId['t_id'];
        }
      } else {
      ?>
        <script>
          alert("illegal command");
          window.location.href = "packages.php";
        </script>
    <?php
      }
    }
  } else {
    ?>
    <script>
      alert("illegal command");
      window.location.href = "packages.php";
    </script>
  <?php
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $pk_name = trim($_POST['pk_name']);
  $pk_descr = trim($_POST['pk_descr']);
  $pk_short_descr = trim($_POST['pk_short_descr']);
  $pk_preparation = trim($_POST['pk_preparation']);
  $pk_caution = trim($_POST['pk_caution']);
  $pk_process = trim($_POST['pk_process']);
  $pk_fee = intval($_POST['pk_fee']);
  $pk_pay_fee = intval($_POST['pk_pay_fee']);
  $selectedTests = $_POST["test"];
  if (isset($_POST['pk_id']) && $_POST['pk_id'] != '') {
    $pk_id = $_POST['pk_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_PACKAGE_LOC . $img);
        $stmt = $con->prepare("update package set pk_name=?, pk_descr=?,pk_short_descr=?,pk_preparation=?,pk_process=?,pk_caution=?, pk_fee=?, pk_pay_fee=?, pk_image='$img' where pk_id=$pk_id");
        $stmt->bind_param("ssssssii", $pk_name, $pk_descr, $pk_short_descr, $pk_preparation, $pk_caution, $pk_process, $pk_fee, $pk_pay_fee);
        $stmt->execute();
        foreach ($selectedTests as $t_id) {
          $stmt2 = $con->prepare("INSERT INTO test_pack_joint (t_id, pk_id) VALUES (?, ?)");
          $stmt2->bind_param('ii', $t_id, $pk_id);
          $stmt2->execute();
          $stmt2->close();
        }
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("update package set pk_name=?, pk_descr=?,pk_short_descr=?,pk_preparation=?,pk_process=?,pk_caution=?,  pk_fee=?, pk_pay_fee=? where pk_id=$pk_id");
      $stmt->bind_param("ssssssii", $pk_name, $pk_descr, $pk_short_descr, $pk_preparation, $pk_process, $pk_caution, $pk_fee, $pk_pay_fee);
      $stmt->execute();
      foreach ($selectedTests as $t_id) {
        $stmt2 = $con->prepare("INSERT INTO test_pack_joint (t_id, pk_id) VALUES (?, ?)");
        $stmt2->bind_param('ii', $t_id, $pk_id);
        $stmt2->execute();
        $stmt2->close();
      }
      $stmt->close();
    }
  ?>
    <script>
      window.location.href = "packages.php"
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "packages.php";
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
                    <strong>Warning!</strong> Invalid image format(use jpg/hpeg/png), Package update failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>Package</h2>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Package</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-6 border border-dark border-start-0">
            <h5>Included Tests</h5>
            <table>
              <tbody>
                <?php
                foreach ($arr as $t_id) {
                  $rowTest = mysqli_query($con, "select t_name from test where t_id=$t_id");
                  while ($rowTestName = mysqli_fetch_assoc($rowTest)) {
                ?>
                    <tr>
                      <td><?php echo $rowTestName['t_name'] ?></td>
                      <td>
                        <a href="?type=remove&pk_id=<?php echo $pk_id; ?>&t_id=<?php echo $t_id; ?>" style="color:red;">Remove</a>
                      </td>
                    </tr>
                <?php }
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="col-6 border border-dark border-start-0 border-end-0">
            <label for="" class="form-control-label">Add new Tests(hold ctrl and select multiple)</label>
            <select name="test[]" class="form-select" multiple aria-label="multiple select example">
              <?php
              $sql = "SELECT test.t_id, test.t_name FROM test LEFT JOIN test_pack_joint ON test.t_id = test_pack_joint.t_id AND test_pack_joint.pk_id = $pk_id WHERE test_pack_joint.t_id IS NULL and test.t_id!=1 ORDER BY test.t_name";
              $resultNewTest = $con->query($sql);
              while ($rowNewTest = mysqli_fetch_assoc($resultNewTest)) {
              ?>
                <option value="<?php echo $rowNewTest['t_id'] ?>"><?php echo $rowNewTest['t_name'] ?></option>
              <?php
              }
              ?>
            </select>
          </div>

        </div>
        <div class="form-group m-2">
          <label for="pk_name" class="form-control-label">Package Name</label>
          <input type="text" name="pk_name" class="form-control" required value="<?php echo $pk_name ?>">
        </div>
        <div class="form-group m-2">
          <label for="pk_short_descr" class="form-control-label">Short Description</label>
          <input type="text" name="pk_short_descr" id="pk_short_descr" value="<?php echo $pk_short_descr; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="pk_descr" class=" form-control-label">Description</label>
          <textarea name="pk_descr" id="pk_descr" rows="3" class="form-control" required><?php echo $pk_descr; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="pk_preparation" class=" form-control-label">Preparation</label>
          <textarea name="pk_preparation" id="pk_preparation" rows="3" class="form-control" required><?php echo $pk_preparation; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="pk_process" class=" form-control-label">Process</label>
          <textarea name="pk_process" id="pk_process" rows="3" class="form-control" required><?php echo $pk_process; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="pk_caution" class=" form-control-label">Cautions</label>
          <textarea name="pk_caution" id="pk_caution" rows="3" class="form-control" required><?php echo $pk_caution; ?></textarea>
        </div>
        <div class="row">
          <div class="col">
            <label for="pk_fee" class=" form-control-label">Fee</label>
            <input type="number" name="pk_fee" id="pk_fee" value="<?php echo $pk_fee ?>" class="form-control" required>

          </div>
          <div class="col">
            <label for="pk_pay_fee" class=" form-control-label">Final Amount</label>
            <input type="number" name="pk_pay_fee" id="pk_pay_fee" value="<?php echo $pk_pay_fee ?>" class="form-control" required>

          </div>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="packages.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="pk_id" value="<?php echo $pk_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>