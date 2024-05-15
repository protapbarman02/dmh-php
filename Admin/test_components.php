<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isAlreadyDelete = 0;
$isAdd = 0;
$isAlreadyExist = 0;
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
  $tc_id = $_GET['tc_id'];
  $check_sql = "select * from test_components where tc_id=$tc_id";
  $res = mysqli_query($con, $check_sql);
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $delete_sql = "delete from test_components where tc_id=$tc_id";
    $res = mysqli_query($con, $delete_sql);
    if ($res) {
      $isDelete = 1;
      //successfuly deleted
    } else {
      //delete failed
    }
  } else {
    $isAlreadyDelete = 1;
    // echo "component was already deleted or does not exist";
  }
}
if (isset($_POST['submit']) && $_POST['submit'] != '') {
  $tc_name = trim($_POST['tc_name']);
  $tc_descr = trim($_POST['tc_descr']);
  $tc_lower_val = floatval($_POST['tc_lower_val']);
  $tc_upper_val = floatval($_POST['tc_upper_val']);
  $tc_unit = trim($_POST['tc_unit']);
  $tc_range = trim($_POST['tc_range']);
  if ($tc_range == '') {
    $tc_range = "N/A";
  }
  $t_id = intval($_POST['t_id']);
  $res = mysqli_query($con, "select * from test_components where tc_name='$tc_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    $stmt = $con->prepare("INSERT INTO test_components (tc_name, tc_descr, tc_lower_val,tc_upper_val, tc_unit,tc_range,  t_id) VALUES (?, ?, ?,?, ?,?, ?)");
    $stmt->bind_param("ssddssi", $tc_name, $tc_descr, $tc_lower_val, $tc_upper_val, $tc_unit, $tc_range, $t_id);
    $stmt->execute();
    $stmt->close();
    $isAdd = 1;
  }
}
$sql = "select test_components.*,test.t_name from test_components inner join test on test_components.t_id=test.t_id order by tc_name";
$res = mysqli_query($con, $sql);
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Specialization already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Test Component deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isAlreadyDelete == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
            <strong>Warning!</strong> Test Component was deleted already or does not exist
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> Test Component added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Test Components(Sub Tests)</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexDiagnosis.php" class="right-top-link">Diagnosis</a>
      <span> / </span>
      <a href="test_components.php" class="right-top-link active">Test Components</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-testComponent-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Test Components</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide">
        <!-- add component form -->
        <div class="form-group m-2">
          <label for="tc_name" class="form-control-label">Test Component Name</label>
          <input type="text" name="tc_name" id="tc_name" placeholder="Enter component name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="tc_descr" class=" form-control-label">Description</label>
          <input type="text" name="tc_descr" id="tc_descr" placeholder="Enter component Description" class="form-control">
        </div>
        <div class="row">
          <div class="col-2">
            <label for="tc_lower_val" class="form-control-label">min Value</label>
            <input type="text" id="tc_lower_val" name="tc_lower_val" placeholder="Enter minimum value" class="form-control">
          </div>
          <div class="col-2">
            <label for="tc_upper_val" class="form-control-label">max Value</label>
            <input type="text" id="tc_upper_val" name="tc_upper_val" placeholder="Enter maximum value" class="form-control">
          </div>
          <div class="col-2">
            <label for="tc_unit" class="form-control-label">Unit</label><br>
            <select name="tc_unit" id="tc_unit" class="form-control">
              <option value="N/A">Select</option>
              <option value="Present">Present</option>
              <option value="/H.P.F">/H.P.F</option>
              <option value="%">%</option>
              <option value="g/dL">g/dL</option>
              <option value="&mu;g/dL">&mu;g/dL</option>
              <option value="mg/dL">mg/dL</option>
              <option value="cells/&mu;L">cells/&mu;L</option>
              <option value="fl">fl</option>
              <option value="pg">pg</option>
              <option value="pq">pq</option>
              <option value="ng/ml">ng/ml</option>
              <option value="mil/ml3">mil/ml3</option>
              <option value="/cu.mm.">/cu.mm.</option>
              <option value="&mu;lU/mL">&mu;lU/mL</option>
            </select>
          </div>
          <div class="col-4">
            <label for="range" class="form-lable">Range : write yourlself(value and unit)</label>
            <input type="text" name="tc_range" id="range" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <label for="t_id" class="form-label">Test Name</label> <br>
            <select name="t_id" id="t_id" required class="form-control">
              <option value="1">Select</option>
              <?php
              $result = mysqli_query($con, "select * from test where test.t_id !=1 order by test.t_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['t_id']; ?>"><?php echo $data['t_name']; ?></option>
              <?php } ?>
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
            <th>Component Name</th>
            <th>Description</th>
            <th>lower Value</th>
            <th>upper Value</th>
            <th>Unit</th>
            <th>Custom Range</th>
            <th>Test Name</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['tc_name'] ?></td>
              <td class="truncated-text" style="max-width: 300px;"><?php echo $row['tc_descr'] ?></td>
              <td><?php if ($row['tc_lower_val'] == '0' || $row['tc_lower_val'] == 0) {
                    echo "N/A";
                  } else {
                    echo $row['tc_lower_val'];
                  } ?></td>
              <td><?php if ($row['tc_upper_val'] == '0' || $row['tc_upper_val'] == 0) {
                    echo "N/A";
                  } else {
                    echo $row['tc_upper_val'];
                  } ?></td>
              <td><?php echo $row['tc_unit'] ?></td>
              <td><?php echo $row['tc_range'] ?></td>
              <td><?php echo $row['t_name'] ?></td>
              <td>
                <?php
                echo "<span class='btn btn-warning'><a href='manage_test_components.php?type=edit&tc_id=" . $row['tc_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&tc_id=" . $row['tc_id'] . "' class='manage-links'>Delete</a></span>";
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
  console.log("clicked");
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