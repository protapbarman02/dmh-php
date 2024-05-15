<?php $ROOT = "../";
require('includes/nav.php');
$tc_id = '';
$tc_name = '';
$tc_descr = '';
$tc_lower_val = '';
$tc_upper_val = '';
$tc_unit = '';
$tc_range = '';
$t_id = '';
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['tc_id']) && $_GET['tc_id'] != '') {
    $tc_id = $_GET['tc_id'];
    $res = mysqli_query($con, "select * from test_components where tc_id=$tc_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $tc_name = $row['tc_name'];
      $tc_descr = $row['tc_descr'];
      $tc_lower_val = $row['tc_lower_val'];
      $tc_upper_val = $row['tc_upper_val'];
      $tc_unit = $row['tc_unit'];
      $tc_range = $row['tc_range'];
      $t_id = $row['t_id'];
      $t_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT t_name FROM test WHERE test.t_id=$t_id;"))['t_name'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "test_component.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $tc_name = trim($_POST['tc_name']);
  $tc_descr = trim($_POST['tc_descr']);
  $tc_lower_val = floatval($_POST['tc_lower_val']);
  $tc_upper_val = floatval($_POST['tc_upper_val']);
  $tc_unit = trim($_POST['tc_unit']);
  $tc_range = trim($_POST['tc_range']);
  $t_id = intval($_POST['t_id']);
  if (isset($_POST['tc_id']) && $_POST['tc_id'] != '') {
    $tc_id = $_POST['tc_id'];
    $stmt = $con->prepare("UPDATE test_components SET tc_name=?, tc_descr=?, tc_lower_val=?,tc_upper_val=?, tc_unit=?,tc_range=?, t_id=? WHERE tc_id=$tc_id");
    $stmt->bind_param("ssddssi", $tc_name, $tc_descr, $tc_lower_val, $tc_upper_val, $tc_unit, $tc_range, $t_id);
    $stmt->execute();
    $stmt->close();
    ?>
    <script>
      window.location.href = "test_components.php"
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "test_components.php";
    </script>
<?php
  }
}
?>
<section class="admin-right-panel">
  <h2>Test Components</h2>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Component</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form">
        <div class="form-group m-2">
          <label for="tc_name" class="form-control-label">Test Component Name</label>
          <input type="text" name="tc_name" class="form-control" required value="<?php echo $tc_name; ?>">
        </div>
        <div class="form-group m-2">
          <label for="tc_descr" class=" form-control-label">Description</label>
          <input type="text" name="tc_descr" class="form-control" value="<?php echo $tc_descr; ?>">
        </div>
        <div class="row p-2">
          <div class="col-2">
            <label for="tc_lower_val" class="form-control-label">lower Value</label>
            <input type="text" id="tc_lower_val" name="tc_lower_val" value="<?php echo $tc_lower_val; ?>" class="form-control">
          </div>
          <div class="col-2">
            <label for="tc_upper_val" class="form-control-label">lower Value</label>
            <input type="text" id="tc_upper_val" name="tc_upper_val" value="<?php echo $tc_upper_val; ?>" class="form-control">
          </div>
          <div class="col-2">
            <label for="tc_unit" class="form-control-label">Unit</label><br>
            <select name="tc_unit" id="tc_unit" class="form-control">
              <option value="<?php echo $tc_unit ?>"><?php echo $tc_unit ?></option>
              <option value="N/A">N/A</option>
              <option value="Present">Present</option>
              <option value="/H.P.F">/H.P.F</option>
              <option value="%">%</option>
              <option value="g/dL">g/dL</option>
              <option value="mg/dL">mg/dL</option>
              <option value="&mu;g/dL">&mu;g/dL</option>
              <option value="fl">fl</option>
              <option value="pg">pg</option>
              <option value="pq">pq</option>
              <option value="ng/ml">ng/ml</option>
              <option value="cells/&mu;L">cells/&mu;L</option>
              <option value="mil/ml3">mil/ml3</option>
              <option value="/cu.mm.">/cu.mm.</option>
              <option value="&mu;lU/mL">&mu;lU/mL</option>
            </select>
          </div>
          <div class="col-4">
            <label for="range" class="form-lable">Range : write yourlself(value and unit)</label>
            <input type="text" name="tc_range" id="range" class="form-control" value="<?php echo $tc_range; ?>">
          </div>
        </div>
        <div class="row">
          <div class="col-2">
            <label for="t_id" class="form-control-label">Test Name</label> <br>
            <select name="t_id" id="t_id" class="form-control">
              <option value="<?php echo $t_id ?>"><?php echo $t_name ?></option>
              <?php
              $result = mysqli_query($con, "select * from test where test.t_id !=1 order by test.t_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['t_id']; ?>"><?php echo $data['t_name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="test_components.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="tc_id" value="<?php echo $tc_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>